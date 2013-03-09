<?php

/**
*   该文件包含 lpDBDrive 的类定义.
*
*   @package LightPHP
*/

/**
*   数据库驱动基类.
*
*   抽象了数据库的底层操作, lpDBQuery 和 lpDBResult 使用该类进行底层操作.
*   通过继承该类可以让LightPHP支持更多的数据库. 继承该类的同时还必须继承并实现 lpDBInquiryDrive 类.
*
*	#术语
*	* 数据库, 一组服务器主机, 用户名, 密码, 数据库名等所指定的特定数据库.
*	* 数据表, 数据库包含若干数据表, 数据表包含若干行, 在其他的数据库上, 数据表还可能被成为集合, 文档.
*	* 行, 数据的最基础的单位.
*	* 数据库原生指令, 对SQL数据库来说就是SQL.
*
*   @type abstract resource class
*/

abstract class lpDBDrive
{
    /**
    *   连接到数据库.
    *
    *   @param array $config 连接选项 [选项 => 值]
    */

    abstract public function __construct($config=null);

    /**
    *   从数据库断开连接.
    */

    abstract public function __destruct();

    /**
    *   向数据表插入一行.
    *
    *   @param string $table 表名
    *   @param array  $row   要插入的数据 [列名 => 值]
    */

    abstract public function insert($table, $row);

    /**
    *   从数据表查询数据.
    *
    *   @param string $table  表名
    *   @param lpDBInquiryDrive  $if   查询的条件
    *   @param array  $config 查询选项 [选项 => 值]
    */

    abstract public function select($table, $if=null, $config=null);

    /**
    *   从数据表修改数据.
    *
    *   @param string $table  表名
    *   @param lpDBInquiryDrive  $if   修改的条件
    *   @param array  $new    新数据 [列名 => 值]
    *
    *   @return mixed 结果集资源句柄
    */

    abstract public function update($table, $if, $new);

    /**
    *   从数据表删除数据.
    *
    *   @param string $table  表名
    *   @param lpDBInquiryDrive  $if     删除的条件
    */

    abstract public function delete($table, $if);

    /**
    *   获得该数据库下的数据表列表.
    *
    *   @return array
    */

    abstract public function tableList();

    /**
    *   执行数据库原生的操作.
    *
    *	这将是数据库相关的, 不推荐.
    *
    *   @param string $name  操作名
    *   @param string $args  参数
    *
    *   @return mixed
    */

    abstract public function operator($name, $args=null);

    /**
    *   运行数据库原生指令.
    *
    *	这将是数据库相关的, 不推荐.
    *
    *   @param string $command  指令
    *   @param mixed  $more...  更多指令(取决于数据库)
    *
    *   @return mixed 结果集资源句柄
    */

    abstract public function command($command=null, $more=null);

    /**
    *   获取当前驱动对应的查询器实例.
    *
    *   @return lpDBInquiryDrive
    */

    static public function getInquiry()
    {
        return null;
    }

    /**
    *   从结果集中读取一行.
    *
    *   若已到最后一行, 则返回 null .
    *
    *   @param mixed $rs 结果集资源句柄
    *
    *   @return array|null
    */

    static public function rsReadRow($rs)
    {
        return null;
    }

    /**
    *   获取结果集的行数.
    *
    *   @param mixed $rs  结果集资源句柄
    *
    *   @return int
    */
    
    static public function rsGetNum($rs)
    {
        return null;
    }

    /**
    *   移动结果集中的指针.
    *
    *   @param mixed $rs  结果集资源句柄
    *   @param int   $s   移动的目标位置
    *
    *   @return int
    */
    
    static public function rsSeek($rs, $s)
    {
        return null;
    }

    /**
    *   销毁结果集.
    *
    *   @param mixed $rs  结果集资源句柄
    */
    
    static public function rsDestroy($rs)
    {
        return null;
    }
}

/**
*   数据库查询基类.
*
*   抽象了数据库的查询条件, 该类的每个实例表示一组数据库查询条件.
*   通过继承该类可以让LightPHP支持更多的数据库.
*
*   @type abstract value class
*/

abstract class lpDBInquiryDrive
{
    /** @type enum(Operator)  等于 */
    const Equal = "=";
    /** @type enum(Operator)  不等于 */
    const NotEqual = "<>";
    /** @type enum(Operator)  大于 */
    const Greater = ">";
    /** @type enum(Operator)  小于 */
    const Less = "<";
    /** @type enum(Operator)  大于等于 */
    const GreaterEqual = ">=";
    /** @type enum(Operator)  小于等于 */
    const LessEqual = "<=";

    /**
    *   查询交集.
    *
    *   @param array|lpDBInquiryDrive $if   查询条件
    */

    abstract public function andIf($if);

    /**
    *   查询并集.
    *
    *   @param array|lpDBInquiryDrive $if   查询条件
    */
    
    abstract public function orIf($if);

    /**
    *   查询补集.
    *
    *   会对已有的所有条件取反.
    */
    
    abstract public function notIf();
}
