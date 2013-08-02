<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

/**
 * Class lpPDOModel PDO Model
 * 该类提供了简单的PDO数据源的访问,
 * 使用时需要继承该类并重写 metaData() 函数, 返回有关数据表的信息.
 */

abstract class lpPDOModel implements ArrayAccess
{
    protected $id = null;
    protected $data = [];

    public function __construct($id)
    {
        if($id)
        {
            $this->id = $id;
            $this->data = static::find([static::metaData()[self::PRIMARY] => $id]);
        }
    }

    public function data()
    {
        return $this->data;
    }

    public function isNull()
    {
        if($this->data)
            return false;
        return true;
    }

    static public function by($k, $v)
    {
        /** @var lpPDOModel $i */
        $i = new static(null);
        $i->data = static::find([$k => $v]);
        $i->id = $i->data[static::metaData()[self::PRIMARY]];
        return $i;
    }

    /* ArrayAccess */
    public function offsetSet($offset, $value)
    {
        if(is_null($offset))
            $this->data[] = $value;
        else
            $this->data[$offset] = $value;
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * @var int 默认结果抓取方式
     */
    static protected $defaultDataType = PDO::FETCH_ASSOC;

    /* 数据类型 */
    const INT = "INT";
    const UINT = "INT UNSIGNED";
    const AI = "AUTO_INCREMENT";
    const VARCHAR = "VARCHAR";
    const TEXT = "TEXT";
    const JSON = "JSON";

    /* 数据修饰 */
    const PRIMARY = "PRIMARY";
    const NOTNULL = "NOT NULL";

    static protected function metaData()
    {
        return null;
    }

    /**
     * 检索数据
     * @param array $if     条件: [<字段1> => <值1>, <字段1> => <值2>]
     * @param array $config 额外参数: ["sort" => [<排序字段>, <是否为正序>], "skip" => <跳过条数>, "limit" => <检索条数>, "mode" => <抓取方式>, "count" => <只获取结果数>]
     *
     * @return PDOStatement
     * @throws Exception
     */
    static public function select($if = [], $config = [])
    {
        $meta = static::metaData();

        $where = static::buildWhere($if);
        if(isset($config["count"]) && $config["count"])
            $sql = "SELECT COUNT(*) FROM `{$meta['table']}` {$where}";
        else
            $sql = "SELECT * FROM `{$meta['table']}` {$where}";

        if(isset($config["sort"][0]) && $config["sort"][0]) {
            $orderBy = $config["sort"][0];

            if(!array_key_exists($orderBy, $meta["struct"]))
                throw new Exception("lpPDOModel: Field name is not in the struct");

            $sql .= " ORDER BY `{$orderBy}`";

            if(isset($config["sort"][1]))
                $sql .= $config["sort"][1] ? " ASC" : " DESC";
        }

        $skip = isset($config["skip"]) ? $config["skip"] : -1;
        $limit = isset($config["limit"]) ? $config["limit"] : -1;

        if($limit > -1 && $skip > -1)
            $sql .= " LIMIT {$skip}, {$limit}";
        if($limit > -1 && !($skip > -1))
            $sql .= " LIMIT {$limit}";

        $rs = static::getDB()->query($sql);
        $rs->setFetchMode(isset($config["mode"]) ? : static::$defaultDataType);
        return $rs;
    }

    /**
     * 获取符合条件的第一条数据
     * @param array $if     条件
     * @param array $config 额外参数
     *
     * @return array|null  成功返回数组, 失败返回null
     */
    static public function find($if = [], $config = [])
    {
        $config = array_merge($config, ["limit" => 1]);
        $data = static::select($if, $config)->fetch();
        if($data)
            return static::jsonDecode($data);
        else
            return null;
    }

    /**
     * 获取所有符合条件的记录为二维数组
     * @param array $if     条件
     * @param array $config 额外参数
     *
     * @return array
     */
    static public function selectArray($if = [], $config = [])
    {
        $rs = static::select($if, $config)->fetchAll();
        foreach($rs as &$v)
            $v = static::jsonDecode($v);
        return $rs;
    }

    /**
     * 获取符合条件的行数
     * @param array $if
     * @param array $config
     *
     * @return int
     */
    static public function count($if = [], $config = [])
    {
        $config = array_merge($config, ["count" => true]);
        return static::select($if, $config)->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];
    }

    /**
     * 插入数据
     * @param $data     数据
     *
     * @return string   Last Insert ID
     */
    static public function insert($data)
    {
        $meta = static::metaData();
        $db = static::getDB();

        $data = static::jsonEncode($data);

        $columns = array_keys($data);
        $values = array_values($data);

        array_walk($columns, function (&$v) {
            $v = "`{$v}`";
        });

        array_walk($values, function (&$v) use ($db) {
            $v = $db->quote($v);
        });

        $columns = implode(", ", $columns);
        $values = implode(", ", $values);

        $sql = "INSERT INTO `{$meta['table']}` ({$columns}) VALUES ({$values});";

        $db->query($sql);
        return $db->lastInsertId();
    }

    /**
     * 更新数据
     * @param $if   条件
     * @param $data 新数据
     *
     * @return int  被更新行数
     */
    static public function update($if, $data)
    {
        $db = static::getDB();
        $meta = static::metaData();

        $data = static::jsonEncode($data);

        $sqlSet = [];
        foreach($data as $k => $v) {
            $v = $db->quote($v);
            $sqlSet[] = "`{$k}` = {$v}";
        }

        $sqlSet = implode(", ", $sqlSet);
        $where = static::buildWhere($if);

        $sql = "UPDATE `{$meta['table']}` SET {$sqlSet} {$where}";

        return $db->exec($sql);
    }

    /**
     * 删除数据
     * @param $if   条件
     *
     * @return int  删除行数
     */
    static public function delete($if)
    {
        $meta = static::metaData();

        $where = static::buildWhere($if);
        $sql = "DELETE FROM `{$meta['table']}` {$where}";

        return static::getDB()->exec($sql);
    }

    /**
     *  安装数据表
     */
    static public function install()
    {
        $meta = static::metaData();
        $db = static::getDB();

        $sql = "CREATE TABLE IF NOT EXISTS `{$meta['table']}` (";

        foreach($meta["struct"] as $k => $v)
        {
            switch($v["type"])
            {
                case self::AI:
                    $type = self::INT . " " . self::AI;
                    break;
                case self::JSON:
                    $type = self::TEXT;
                    break;
                case self::VARCHAR:
                    $type = self::VARCHAR . "({$v['length']})";
                    break;
                default:
                    $type = $v["type"];
            }
            if(isset($v[self::NOTNULL]) && $v[self::NOTNULL])
                $type .= " " . self::NOTNULL;

            if(isset($v["default"]))
                $type .= " DEFAULT " . $db->quote($v["default"]);

            $sql .= "`{$k}` {$type},";
        }

        $sql .= " PRIMARY KEY (`{$meta['PRIMARY']}`) ) ENGINE={$meta['engine']} CHARSET={$meta['charset']};";

        $db->exec($sql);
    }

    /**
     * @return PDO
     */
    static protected function getDB()
    {
        return static::metaData()["db"];
    }

    static protected function buildWhere($if)
    {
        $where = "";
        foreach($if as $k => $v) {
            if(!array_key_exists($k, static::metaData()["struct"]))
                throw new Exception("lpPDOModel: Field name is not in the struct");

            $v = static::getDB()->quote($v);

            if(!$where)
                $where = "(`{$k}` = {$v})";
            else
                $where = "{$where} AND (`{$k}` = {$v})";
        }

        if($where)
            $where = "WHERE {$where}";

        return $where;
    }

    static public function jsonEncode($data)
    {
        foreach(static::metaData()["struct"] as $k => $v)
        {
            if($v["type"] == self::JSON && array_key_exists($k, $data))
                $data[$k] = json_encode($data[$k]);
        }
        return $data;
    }

    static public function jsonDecode($data)
    {
        foreach(static::metaData()["struct"] as $k => $v)
        {
            if($v["type"] == self::JSON && array_key_exists($k, $data))
                $data[$k] = json_decode($data[$k], true);
        }
        return $data;
    }
}