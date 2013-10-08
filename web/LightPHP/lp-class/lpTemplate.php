<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

/**
*   该文件包含 lpTemplate 的类定义.
*
*   @package LightPHP
*/

class lpTemplate implements ArrayAccess
{
    private $filename;
    private $values = [];

    /* ArrayAccess */
    public function offsetSet($offset, $value)
    {
        if(is_null($offset))
            $this->values[] = $value;
        else
            $this->values[$offset] = $value;
    }

    public function offsetExists($offset)
    {
        return isset($this->values[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->values[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->values[$offset]) ? $this->values[$offset] : null;
    }

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function setValue($k, $v)
    {
        $this->values[$k] = $v;
    }

    public function setValues($arr)
    {
        foreach ($arr as $k => $v)
            $this->setValue($k, $v);
    }

    public function output()
    {
        include($this->filename);
    }

    public function getOutput()
    {
        self::beginBlock();
        include($this->filename);
        return self::endBlock();
    }

    static public function beginBlock()
    {
        ob_start();
    }

    static public function endBlock()
    {
        return ob_get_clean();
    }

    static public function outputFile($file, $values=[])
    {
        $tmp = new lpTemplate($file);
        if($values)
            $tmp->setValues($values);
        $tmp->output();
    }
}