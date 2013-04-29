<?php

/**
 * Class lpPDOModel PDO Model
 * 该类提供了简单的PDO数据源的访问,
 * 使用时需要继承该类并重写 init() 函数,
 * 在其中给 $db, $struct, $table 赋值.
 */
class lpPDOModel
{
    /**
     * @var PDO 数据库连接
     */
    static protected $db = null;
    /**
     * @var array 数据表结构
     */
    static protected $struct = [];
    /**
     * @var array 数据表信息
     */
    static protected $table = [];

    /**
     * @var int 默认结果抓取方式
     */
    static protected $defaultDataType = PDO::FETCH_ASSOC;

    /* 数据类型 */
    const INT = "INT";
    const UINT = "UNSIGNED INT";
    const AI = "AUTO INCREMENT";
    const VARCHAR = "VARCHAR";
    const TEXT = "TEXT";

    /* 数据修饰 */
    const PRIMARY = "PRIMARY";
    const NOTNULL = "NOT NULL";

    /**
     *  请重写该函数, 并在其中给 $db, $struct, $table 赋值.
     */
    static protected function init()
    {

    }

    /**
     * 检索数据
     * @param array $if     条件: [<字段1> => <值1>, <字段1> => <值2>]
     * @param array $config 额外参数: ["sort" => [<排序字段>, <是否为正序>], "skip" => <跳过条数>, "limit" => <检索条数>, "mode" => <抓取方式>]
     *
     * @return PDOStatement
     * @throws Exception
     */
    static public function select($if = [], $config = [])
    {
        if(!self::$db)
            static::init();

        $where = self::buildWhere($if);

        $table = self::$table["table"];
        $sql = "SELECT * FROM `{$table}` {$where}";

        if(isset($config["sort"][0]) && $config["sort"][0]) {
            $orderBy = $config["sort"][0];

            if(!array_key_exists($orderBy, self::$struct))
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

        $rs = self::$db->query($sql);
        $rs->setFetchMode(isset($config["mode"]) ? : self::$defaultDataType);
        return $rs;
    }

    /**
     * 获取符合条件的第一条数据
     * @param array $if     条件
     * @param array $config 额外参数
     *
     * @return array|false  成功返回数组, 失败返回false
     */
    static public function find($if = [], $config = [])
    {
        $config = array_merge($config, ["limit" => 1]);
        return self::select($if, $config)->fetch();
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
        return self::select($if, $config)->fetchAll();
    }

    /**
     * 插入数据
     * @param $data     数据
     *
     * @return string   Last Insert ID
     */
    static public function insert($data)
    {
        if(!self::$db)
            static::init();

        $columns = array_keys($data);
        $values = array_values($data);

        array_walk($columns, function (&$v) {
            $v = "`{$v}`";
        });

        array_walk($values, function (&$v) {
            $v = self::$db->quote($v);
        });

        $columns = implode(", ", $columns);
        $values = implode(", ", $values);

        $table = self::$table["table"];
        $sql = "INSERT INTO `{$table}` ({$columns}) VALUES ({$values});";

        self::$db->query($sql);
        return self::$db->lastInsertId();
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
        if(!self::$db)
            static::init();

        foreach($data as $k => $v) {
            $k = self::$db->quote($k);
            $v = self::$db->quote($v);
            $sqlSet[] = "`{$k}` = {$v}";
        }

        $sqlSet = implode(", ", $sqlSet);
        $where = self::buildWhere($if);

        $table = self::$table["table"];
        $sql = "UPDATE `{$table}` SET {$sqlSet} {$where}";

        return self::$db->exec($sql);
    }

    /**
     * 删除数据
     * @param $if   条件
     *
     * @return int  删除行数
     */
    static public function delete($if)
    {
        if(!self::$db)
            static::init();

        $where = self::buildWhere($if);
        $sql = "DELETE FROM `{$table}` {$where}";

        return self::$db->exec($sql);
    }

    static protected function buildWhere($if)
    {
        $where = "";
        foreach($if as $k => $v) {
            if(!array_key_exists($k, self::$struct))
                throw new Exception("lpPDOModel: Field name is not in the struct");

            $v = self::$db->quote($v);

            if(!$where)
                $where = "(`{$k}` = {$v})";
            else
                $where = "{$where} AND (`{$k}` = {$v})";
        }

        if($where)
            $where = "WHERE {$where}";

        return $where;
    }
}