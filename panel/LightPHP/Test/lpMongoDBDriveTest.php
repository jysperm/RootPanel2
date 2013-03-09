<?php

require_once("lp-load.php");

class lpMongoDBDriveTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
       // -- 建立实例

        $xxoo = new lpMongoDBDrive();

        // -- 建立测试表

        $xxoo->command()->selectCollection("test")->remove([]);

        // -- 插入数据

        $jybox = ["time" => time(), "name" => "jybox", "age" => 17, "info" => ""];

        $xxoo->insert("test", $jybox);
        $xxoo->insert("test", ["time" => time(), "name" => "abreto", "age" => 16, "info" => ""]);

        // -- 更新数据

        $if = $xxoo->getInquiry();
        $if->andIf(["name" => "jybox"]);

        $xxoo->update("test", $if, ["info" => "正在编写LightPHP"]);

        // -- 查询数据

        $rs = $xxoo->select("test", $if);

        //数据集行数
        $this->assertEquals(1, $xxoo->rsGetNum($rs));

        // -- 断言查询到数据
        $r = $xxoo->rsReadRow($rs);

        $jybox["info"] = "正在编写LightPHP";

        $this->assertEquals($jybox ,$r);

        //已经到达数据集的末尾
        $this->assertEquals(false, $xxoo->rsReadRow($rs));

        // -- 删除数据

        $if->orIf(["age" => 16]);

        file_put_contents("filename", print_r($if->buildWhere(),true));

        $xxoo->delete("test", $if);

        $rs = $xxoo->select("test");
        $this->assertEquals(0, $xxoo->rsGetNum($rs));
    }
}