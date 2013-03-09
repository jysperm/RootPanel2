<?php

require_once("lp-load.php");

class lpLockTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        lpLoader("lpFileLock");
        lpLoader("lpMySQLLock");
        lpLoader("lpMutex");
    }
}