<?php

/**
*   该文件包含 lpPDODBDrive 和 lpPDODBInquiryDrive 的类定义.
*
*   @package LightPHP
*/

class lpPDODBDrive extends lpDBDrive
{
	/** @type resource 到MySQL的连接. */
	private $connect = null;
    
    /** @type array 连接选项, 参见 connect() . */
    private $config = null;

    /** 
    *   排序字段.
    *   
    *   @param string
    *   
    *   @type enum(SelectConfig)
    */
    const OrderBy = "orderby";
    
    /** 
    *   是否按正序排序.
    *   
    *   @param bool
    *   
    *   @type enum(SelectConfig)
    */
    const IsAsc = "isasc";

    /** 
    *   开始行数.
    *   
    *   @param int
    *   
    *   @type enum(SelectConfig)
    */
    const Start = "start";

    /** 
    *   总行数.
    *   
    *   @param int
    *   
    *   @type enum(SelectConfig)
    */
    const Limit = "limit";

	/**
	*	
	*	该类会从 /lp-main-config.php 中的 `Default.lpMySQLDrive` 段读取默认连接选项, 可用的选项请参见 /lp-main-config.php .
	*/

    public function __construct($config=[])
    {
        global $lpCfg;

        $config = array_merge(["type" => "mysql"], $lpCfg["Default.lpMySQLDBDrive"], $config);

        $this->config = $config;

        $this->connect = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config["user"], $config["passwd"]);
    }

    public function __destruct()
    {

    }

    public function insert($table, $row)
    {
        $sqlColumns = array_keys($row);
        $sqlValues = array_values($row);

        array_walk($sqlColumns, function(&$v)
        {
            $v = $this->escape($v);
            $v = "`{$v}`";
        });

        array_walk($sqlValues, function(&$v)
        {
            $v = $this->escape($v);
            $v = "'{$v}'";
        });

        $sqlColumns = implode(", ", $sqlColumns);
        $sqlValues = implode(", ", $sqlValues);

        $sql = "INSERT INTO `{$table}` ({$sqlColumns}) VALUES ({$sqlValues});";

        return $this->connect->query($sql);
    }

    /**
    *
    *   支持的选项见 enum(SelectConfig) .
    *   
    */

    public function select($table, $if=null, $config=[])
    {
        if(!$if)
            $if = $this->getInquiry();

        $sql = "SELECT * FROM `{$table}` " . $if->buildWhere();

        if(isset($config[$this::OrderBy]))
        {
            $orderBy = $this->escape($config[$this::OrderBy]);

            $sql .=" ORDER BY `{$orderBy}` ";

            if(isset($config[$this::IsAsc]) && !$config[$this::IsAsc])
            {
                $sql .= " DESC ";
            }
        }

        $start = isset($config[$this::Start]) ? $config[$this::Start] : -1;
        $limit = isset($config[$this::Limit]) ? $config[$this::Limit] : -1;

        if($limit>-1 && $start>-1)
            $sql .= " LIMIT {$start}, {$limit} ";
        if($limit>-1 && !($start>-1))
            $sql .= " LIMIT {$limit} ";

        return $this->connect->query($sql);
    }

    public function update($table, $if, $new)
    {
        foreach($new as $k => $v)
        {
            $k = $this->escape($k);
            $v = $this->escape($v);
            $sqlSet[]= "`{$k}`='{$v}'";
        }

        $sqlSet = implode(", ", $sqlSet);

        $sql = "UPDATE `{$table}` SET {$sqlSet} " . $if->buildWhere();

        return $this->connect->query($sql);
    }

    public function delete($table, $if)
    {
        $sql = "DELETE FROM `{$table}` " . $if->buildWhere();

        return $this->connect->query($sql);
    }

    public function tableList()
    {
        return null;
    }

    public function operator($name, $args=null)
    {
        switch($name)
        {
            
        }
    }

    /**
    *   执行带占位符的SQL指令.
    *
    *   该函数支持占位符语法, 占位符为 `%s` , 不区分大小写.
    *   如需在SQL中使用百分号, 请写两个百分号.
    */

    public function commandArgs($command, $more=null)
    {
        $args = func_get_args();
        array_shift($args);

        $sql = $this->parseSQL($command, $args);

        return $this->connect->query($sql);
    }

    public function command($command=null, $more=null)
    {
        return $this->connect->query($command);
    }

    static public function getInquiry()
    {
        return new lpPDODBInquiryDrive;
    }

    static public function rsReadRow($rs)
    {
        if($rs)
            return $rs->fetch(PDO::FETCH_ASSOC);
    }
    
    static public function rsGetNum($rs)
    {
        return $rs->rowCount();
    }
    
    static public function rsSeek($rs, $s)
    {
        return null;
    }

    static public function rsDestroy($rs)
    {
        $rs = null;
    }

    /**
    *	转义要添加到SQL中的参数.
    *
    *	@param string $str  要转义的参数
    *
    *	@return string
    */

    private function escape($str)
    {
        return $this->connect->quote($str);
    }

    /**
    *	解析含有占位符的SQL, 将参数嵌入SQL.
    *
    *	@param string $sql  含有占位符的SQL
    *	@param array  $args 参数列表
    *
    *	@return string 解析后的SQL.
    */

    private function parseSQL($sql, $args)
    {
        $offset = 0;
        foreach($args as $i)
        {
            if(preg_match("/%([Ss])/", $sql, $result, PREG_OFFSET_CAPTURE, $offset))
            {
                $fStr = $result[1][0];
                $pos = $result[1][1];

                $tPos = $pos - 1;
                while($sql[$pos] == "%")
                {
                    $tPos--;
                }

                if(!(($pos - $tPos) % 2))
                    continue;

                $value=$this->escape($i);

                $sql = substr($sql, 0, $pos - 1) . $value . substr($sql, $pos + 1);

                $offset = $pos + 1;
            }
        }

        return str_replace("%%", "%", $sql);
    }
}

/**
*   MySQL数据库查询驱动.
*
*   该类继承了 lpDBInquiryDrive, 实现了访问查询数据库的功能.
*
*   继承的函数请参见基类的注释.
*
*   @type value class
*/

class lpPDODBInquiryDrive extends lpDBInquiryDrive
{
    /** @type string 当前条件的SQL WHERE表示. */
    private $where = "";

    public function andIf($if)
    {
        if(!is_array($if) && get_class($if))
        {
            if(!$this->where)
                $this->where = $if->where;
            else
                $this->where = "({$this->where} AND {$if->where})";
        }
        else
        {
            if(count($if) > 1)
            {
                foreach($if as $k => $v)
                {
                    $this->andIf([$k => $v]);
                }
            }

            $k = array_keys($if)[0];
            $v = array_values($if)[0];

            if(is_array($v))
            {
                $operator = array_keys($v)[0];
                $value = array_values($v)[0];
            }
            else
            {
                $operator = $this::Equal;
                $value = $v;
            }

            $k = $this->escape($k);
            $value = $this->escape($value);

            if(!$this->where)
                $this->where = "(`{$k}` {$operator} '{$value}')";
            else
                $this->where = "({$this->where} AND (`{$k}` {$operator} '{$value}'))";
        }
    }
    
    public function orIf($if)
    {
        if(!is_array($if) && get_class($if))
        {
            if(!$this->where)
                $this->where = $if->where;
            else
                $this->where = "({$this->where} OR {$if->where})";
        }
        else
        {
            if(count($if) > 1)
            {
                foreach($if as $k => $v)
                {
                    $this->orIf([$k => $v]);
                }
            }

            $k = array_keys($if)[0];
            $v = array_values($if)[0];

            if(is_array($v))
            {
                $operator = array_keys($v)[0];
                $value = array_values($v)[0];
            }
            else
            {
                $operator = $this::Equal;
                $value = $v;
            }

            $k = $this->escape($k);
            $value = $this->escape($value);

            if(!$this->where)
                $this->where = "(`{$k}` {$operator} '{$value}')";
            else
                $this->where = "({$this->where} OR (`{$k}` {$operator} '{$value}'))";
        }
    }

    public function notIf()
    {
        if($this->where)
            $this->where = "( NOT {$this->where})";
    }

    /**
    *   根据已有的条件构建SQL WHERE子句.
    *
    *   @return string
    */

    public function buildWhere()
    {
        if($this->where)
            return " WHERE {$this->where}";
        else
            return "";
    }

    /**
    *   转义要添加到SQL中的参数.
    *
    *   @param string $str 要转义的参数
    *
    *   @return string
    */

    private function escape($str)
    {
        return mysql_real_escape_string($str);
    }
}