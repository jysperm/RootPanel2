<?php

require_once("lp-load.php");

class lpDBDriveTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        lpLoader("lpDBDrive");
        lpLoader("lpDBInquiryDrive");
    }
}