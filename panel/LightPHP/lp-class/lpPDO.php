<?php

class lpPDO
{
    private $dbh;

    public function __construct($config, $user, $passwd)
    {
        $this->dbh = new PDO($config, $user, $passwd);
    }

    public function query($sql)
    {
        return $this->dbh->query($sql);
    }

    public function select($table, $querys=null, $orderBy=NULL, $start=-1, $num=-1, $isASC=true)
    {
        $table=$this->escape($table);
        $orderBy=$this->escape($orderBy);
        $start=(int)$start;
        $num=(int)$num;

        $sql="SELECT * FROM `{$table}` " . $this->buildWhere($querys);

        if($orderBy!="")
            $sql .=" ORDER BY `{$orderBy}` ";

        if(!$isASC)
            $sql .= " DESC ";

        if($num>-1 && $start>-1)
            $sql .= " LIMIT {$start},{$num} ";
        if($num>-1 && !($start>-1))
            $sql .= " LIMIT {$num} ";

        return $this->exec($sql);
    }

}
