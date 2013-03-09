<?php

/**
*   该文件包含 lpMongoDBDrive 和 lpDBMongoInquiryDrive 的类定义.
*
*   @package LightPHP
*/

/**
*   Mongo数据库驱动.
*
*   该类继承了 lpDBDrive, 实现了访问Mongo数据库的驱动.
*
*   继承的函数请参见基类的注释.
*
*   @type resource class
*/

class lpMongoDBDrive extends lpDBDrive
{
    /** @type MongoClient 到Mongo的连接. */
    private $connect = null;

    /** @type MongoDB 数据库对象. */
    private $db = null;

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
    *   该类会从 /lp-main-config.php 中的 `Default.lpMongoDrive` 段读取默认连接选项, 可用的选项请参见 /lp-main-config.php .
    */

    public function __construct($config=[])
    {
        global $lpCfg;

        $config = array_merge($lpCfg["Default.lpMongoDBDrive"], $config);

        $this->config = $config;

        $addressAuth = "";
        if($config["user"])
        {
            $addressAuth = $config["user"];
            if($config["passwd"])
                $addressAuth .= ":{$config['passwd']}";
            $addressAuth .= "@";
        }

        $address = "mongodb://{$addressAuth}{$config['host']}";

        $this->connect = new MongoClient($address);

        $this->db = $this->connect->selectDB($config["dbname"]);
    }

    public function __destruct()
    {
        
    }

    public function insert($table, $row)
    {
        $this->db->selectCollection($table)->insert($row);
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

        $if = $if->buildWhere();

        file_put_contents("filename6", print_r($if ,true));

        $rs = $this->db->selectCollection($table)->find($if);

        if(isset($config[$this::OrderBy]))
            $rs = $rs->sort([$config[$this::OrderBy] => ($config[$this::IsAsc] ? 1 : -1)]);

        $start = isset($config[$this::Start]) ? $config[$this::Start] : -1;
        $limit = isset($config[$this::Limit]) ? $config[$this::Limit] : -1;

        if($start > -1)
            $rs = $rs->skip($start);

        if($limit > -1)
            $rs = $rs->limit($limit);

        return $rs;
    }

    public function update($table, $if, $new)
    {
        $if = $if->buildWhere();

        file_put_contents("filename0", print_r($if,true));

        $rs = $this->db->selectCollection($table)->update($if, ['$set' => $new], ["multiple" => true]);

        return $rs;
    }

    public function delete($table, $if)
    {
        $if = $if->buildWhere();

        $rs = $this->db->selectCollection($table)->remove($if);
        
        return $rs;
    }

    public function tableList()
    {
        return $this->db->listCollections();
    }

    public function operator($name, $args=null)
    {
        switch($name)
        {
            
        }
    }

    public function command($command=null, $more=null)
    {
        return $this->db;
    }

    static public function getInquiry()
    {
        return new lpMongoDBInquiryDrive;
    }

    static public function rsReadRow($rs)
    {
        if($rs->hasNext())
            return $rs->getNext();
        else
            return false;
    }
    
    static public function rsGetNum($rs)
    {
        return $rs->count(true);
    }
    
    static public function rsSeek($rs, $s)
    {
        $rs->rewind();
        $rs->skip($s);
    }

    static public function rsDestroy($rs)
    {

    }
}

/**
*   Mongo数据库查询驱动.
*
*   该类继承了 lpDBInquiryDrive, 实现了访问查询数据库的功能.
*
*   不支持嵌套的And和Or. 不支持Not.
*
*   继承的函数请参见基类的注释.
*
*   @type value class
*/

class lpMongoDBInquiryDrive extends lpDBInquiryDrive
{
    /** @type string 当前条件. */
    private $where = [];

    /** @type bool 该查询是否是And查询 */ 
    private $isAnd = true;

    public function andIf($if)
    {
        $this->isAnd = true;

        if(!is_array($if) && get_class($if))
        {
            $this->where = array_merge($this->where, $if->where);
        }
        else
        {
            if(count($if) > 1)
            {
                foreach($if as $k => $v)
                {
                    $this->orC([$k => $v]);
                }
            }

            $k = array_keys($if)[0];
            $v = array_values($if)[0];

            if(is_array($v))
            {
                $operator = $this->replaceOperator(array_keys($v)[0]);
                $v = [$operator => array_values($v)[0]];
            }

            $this->where[]= [$k => $v];
        }
    }
    
    public function orIf($if)
    {
        $this->isAnd = false;

        if(!is_array($if) && get_class($if))
        {
            $this->where = array_merge($this->where, $if->where);
        }
        else
        {
            if(count($if) > 1)
            {
                foreach($if as $k => $v)
                {
                    $this->orC([$k => $v]);
                }
            }

            $k = array_keys($if)[0];
            $v = array_values($if)[0];

            if(is_array($v))
            {
                $operator = $this->replaceOperator(array_keys($v)[0]);
                $v = [$operator => array_values($v)[0]];
            }

            $this->where[]= [$k => $v];
        }
    }

    public function notIf()
    {
        
    }

    /**
    *   根据已有的条件构建SQL WHERE子句.
    *
    *   @return string
    */

    public function buildWhere()
    {
        if($this->isAnd)
        {
            $r = [];
            foreach($this->where as $k => $v)
            {
                $r[array_keys($v)[0]] = array_values($v)[0];
            }
                
            return $r;
        }
        else
            return ['$or' => $this->where];
            
    }

    static private function replaceOperator($o)
    {
        $map = [
            self::Equal => null,
            self::NotEqual => '$ne',
            self::Greater => '$gt',
            self::Less => '$lt',
            self::GreaterEqual => '$gte',
            self::LessEqual => '$lte'
        ];

        return $map[$o];
    }
}