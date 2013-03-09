<?php

require_once("lp-load.php");

class lpMySQLDBDriveTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        // -- 建立实例

        $xxoo = new lpMySQLDBDrive(["user" => "root","passwd" => ""]);

        // -- 建立测试表

        $xxoo->command("DROP TABLE `test`");

        $sql = <<<EOF

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(10) unsigned NOT NULL,
  `name` text NOT NULL,
  `age` int(11) NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 

EOF;

        $xxoo->command($sql);

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

        $jybox["id"] = 1;
        $jybox["info"] = "正在编写LightPHP";

        $this->assertEquals($jybox ,$r);

        //已经到达数据集的末尾
        $this->assertEquals(false, $xxoo->rsReadRow($rs));

        // -- 删除数据

        $if->orIf(["age" => 16]);

        $xxoo->delete("test", $if);

        $rs = $xxoo->select("test");
        $this->assertEquals(0, $xxoo->rsGetNum($rs));
    }
}