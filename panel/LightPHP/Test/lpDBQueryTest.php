<?php

require_once("lp-load.php");

class lpDBQueryTest extends PHPUnit_Framework_TestCase
{
    private $xxoo = null;

    public function testMySQL()
    {
        $this->xxoo = new lpDBQuery(new lpMySQLDBDrive(["user" => "root","passwd" => ""]));

        $this->xxoo->drive()->commandArgs("DROP TABLE `%s`", "test");

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

        $this->xxoo->drive()->command($sql);

        $this->main();
    }

    public function testMongo()
    {
        $this->xxoo = new lpDBQuery(new lpMongoDBDrive);

        $this->xxoo->drive()->command()->selectCollection("test")->remove([]);

        $this->main();
    }

    public function main()
    {
        $xxoo = $this->xxoo;

        // -- 插入数据

        $jybox = ["time" => time(), "name" => "jybox", "age" => 17, "info" => ""];

        $xxoo("test")->insert($jybox);
        $xxoo("test")->insert(["time" => time(), "name" => "abreto", "age" => 16, "info" => ""]);
        $xxoo("test")->insert(["time" => time() + 3600, "name" => "Parthas", "age" => 19, "info" => ""]);
        $xxoo("test")->insert(["time" => time(), "name" => "whtsky", "age" => 16]);
        $xxoo("test")->insert(["time" => time(), "name" => "土豆", "age" => 15]);

        // -- 更新数据

        $xxoo("test")->where(["name" => "jybox"])->update(["info" => "正在编写LightPHP"]);
        $xxoo("test")->where(["age" => ["<" => 18]])->update(["info" => "未成年"]);
        $xxoo("test")->where(["name" => "whtsky"])->whereOr(["name" => "土豆"])->update(["info" => "富二代"]);

        // -- 查询数据

        $this->assertEquals(5, $xxoo("test")->select()->num());
        $this->assertEquals(4, $xxoo("test")->where(["age" => ["<" => 18]])->select()->num());
        $this->assertEquals("土豆", $xxoo("test")->sort("age")->top()["name"]);
        $this->assertEquals(2, $xxoo("test")->limit(2)->select()->num());

        $rs = $xxoo("test")->where(["info" => "富二代"])->select();

        $this->assertEquals(2, $rs->num());
        $this->assertEquals(true, $rs->read());

        $this->assertEquals("whtsky", $rs->toArray()["name"]);

        $arr = $rs->readToArray();

        $this->assertEquals(1, count($arr));
        $this->assertEquals("土豆", $arr[0]["name"]);

        // -- 删除数据

        $xxoo("test")->where(["name" => "abreto"])->delete();

        $this->assertEquals(4, $xxoo("test")->select()->num());

        $xxoo("test")->delete();

        $this->assertEquals(0, $xxoo("test")->select()->num());
    }
}