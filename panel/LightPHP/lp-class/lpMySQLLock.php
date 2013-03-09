<?php

/**
*   该文件包含 lpFileLock, lpMySQLLock, lpMutex 的类定义.
*
*   @package LightPHP
*/

/**
*   MySQL锁类.
*
*   @type resource class
*/

class lpMySQLLock
{
    /** @type string 锁的名字 */
    private $name = null;

    /** @type lpMySQLDBDrive 数据库连接 */
    private $conn;

    /**
    *   构造一个MySQL锁实例.
    *
    *   @param string $name 锁的名字
    *   @param lpMySQLDBDrive $conn 数据库连接
    */

    public function __construct($name="lpLock", $conn=null)
    {
        $this->name = $name;

        if(!$conn)
            $this->conn = new lpMySQLDBDrive;
        else
            $this->conn = $conn;
    }

    /**
    *   加锁.
    *
    *   @param int $timeout 等待超时的时间
    *
    *   @return 是否获得了锁.
    */

    public function lock($timeout=999)
    {
        $timeout = (int)$timeout;

        $rs = $this->conn->commandArgs("SELECT GET_LOCK('%s',{$timeout} );", $this->name);

        $result = $this->conn->rsReadRow($rs);
        return (bool)$result[0];
    }

    /**
    *   解锁.
    */

    public function unLock()
    {
        $rs = $this->conn->commandArgs("SELECT RELEASE_LOCK('%s');", $this->name);

        $result = $this->conn->rsReadRow($rs);
        return (bool)$result[0];
    }

    /**
    *   @return bool 是否处于加锁状态.
    */

    public function isLock()
    {
        $rs = $this->conn->commandArgs("SELECT IS_USED_LOCK('%s');", $this->name);

        $result = $this->conn->rsReadRow($rs);
        return (bool)$result[0];
    }

    public function __destruct()
    {
        $this->unLock();
    }
}