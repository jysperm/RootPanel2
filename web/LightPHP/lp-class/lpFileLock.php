<?php

/**
*   该文件包含 lpFileLock, lpMySQLLock, lpMutex 的类定义.
*
*   @package LightPHP
*/

/**
*   文件锁类.
*
*   @type resource class
*/

class lpFileLock
{
    /** @type resource 文件句柄 */
    private $file = null;

    /** @type string 文件名 */
    private $fileName;

    /** @type bool 当前是否加锁 */
    private $isLocked = false;

    /**
    *   构造一个文件锁实例.
    *
    *   @param string $name 锁的名字
    *   @param string $path 锁的路径
    */

    public function __construct($name, $path=".")
    {
        $this->fileName = $path . "/" . $name . "." . substr(md5($name),6) . ".lock";
    }

    /**
    *   加锁.
    *
    *   @param enum $type 锁的类型
    *   @param bool $waitForLock 是否阻塞直到获得锁
    *
    *   @return 是否获得了锁.
    */

    public function lock($type=LOCK_EX, $waitForLock=true)
    {
        if(!$this->file)
            $this->file = fopen($this->fileName, "w+");

        if($this->isLocked)
            return false;

        if($waitForLock)
        {
            if(flock($this->file, $type | LOCK_NB))
            {
                $this->isLocked = true;
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            while(!flock($this->file, $type));
            $this->isLocked = true;
        }
    }

    /**
    *   解锁.
    */

    public function unLock()
    {
        if($this->isLocked)
        {
            flock($this->file, LOCK_UN);
            fclose($this->file);
            $this->isLocked=false;
        }
    }

    /**
    *   @return bool 是否处于加锁状态.
    */

    public function isLock()
    {
        return $this->isLocked;
    }

    public function __destruct()
    {
        $this->unLock();
    }
}

/**
*   互斥锁类.
*
*   构造该类即进入互斥区, 销毁该类即离开互斥区.
*
*   @type resource class
*/

class lpMutex
{
    /** @type lpFileLock 锁 */
    private $lock;

    public function __construct()
    {
        $this->lock = new lpFileLock(md5($_SERVER["SCRIPT_FILENAME"]));
        $this->lock->lock();
    }

    public function __destruct()
    {
        $this->lock->unLock();
    }
}