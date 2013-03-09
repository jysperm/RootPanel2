<?php

/**
*   该文件包含 lpDBResult 的类定义.
*
*   @package LightPHP
*/

/**
*   数据库结果集类.
*
*   @type resource class
*/

class lpDBResult implements ArrayAccess, Iterator
{
    /** @type resource 结果集资源句柄. */
    private $rsh = null;

    /** @type lpDBDrive 数据库驱动 */
    private $dbd = null;

    /** @type array 当前数据行 */
    private $curData = null;

    /* ----- 构造和析构 ----- */

    /**
     *   构建一个结果集实例.
     *
     * @param resource $rsh 结果集资源句柄
     * @param $dbh
     */

    public function __construct($rsh ,$dbh)
    {
        $this->rsh = $rsh;
        $this->dbd = $dbh;
    }

    public function __destruct()
    {
        $this->dbd->rsDestroy($this->rsh);
    }

    /**
    *   从结果集中读取一行.
    *
    *   返回是否读取成功.
    *
    *   @return bool
    */

    public function read()
    {
        $this->curData = $this->dbd->rsReadRow($this->rsh);

        return (bool)$this->curData;
    }

    /**
    *   将当前数据行转换为数组.
    *
    *   @return array
    */

    public function toArray()
    {
        return $this->curData;
    }

    /**
    *   读取新行并转换为数组.
    *
    *   @param int $num 转换结果集的前 $num 行, 默认转换全部.
    *
    *   @return array
    */

    public function readToArray($num=-1)
    {
        $result = [];
        while($this->read() && $num--!=0)
            $result[] = $this->curData;
        return $result;
    }

    /**
    *   获取结果集的行数.
    *
    *   @internal param mixed $rs 结果集资源句柄
    *
    *   @return int
    */
    
    public function num()
    {
        return $this->dbd->rsGetNum($this->rsh);
    }

    /**
    *   移动结果集中的指针.
    *
    *   @param int   $s   移动的目标位置
    *
    *   @return int
    */
    
    public function seek($s)
    {
        return $this->dbd->rsSeek($this->rsh ,$s);
    }

    public function offsetSet($offset, $value)
    {
        if(is_null($offset))
            $this->curData[] = $value;
        else 
            $this->curData[$offset] = $value;
    }

    public function offsetExists($offset)
    {
        return isset($this->curData[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->curData[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->curData[$offset]) ? $this->curData[$offset] : null;
    }

    public function rewind()
    {
        $this->seek(0);
    }

    public function current()
    {
        return $this->curData;
    }

    public function key()
    {
        return null;
    }

    public function next()
    {
        $this->read();
    }

    public function valid()
    {
        return (bool)$this->curData;
    }
}