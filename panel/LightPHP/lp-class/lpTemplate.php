<?php

/**
*   该文件包含 lpTemplate 的类定义.
*
*   @package LightPHP
*/

class lpTemplate implements ArrayAccess
{
    private $filename;
    private $values = [];
    private $isFlush = false;

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

    public static function beginBlock()
    {
        ob_start();
    }

    public static function endBlock()
    {
        return ob_get_clean();
    }

    public static function esc($str)
    {
        return htmlspecialchars($str);
    }

    public static function outputFile($file)
    {
        $tmp = new lpTemplate($file);
        $tmp->output();
    }

    public function __construct($filename)
    {
        ob_start();

        if(!file_exists($filename))
            trigger_error("file not exists");

        $this->filename = $filename;
    }

    public function __destruct()
    {
        if(!$this->isFlush)
            ob_end_flush();
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
        echo $this->getOutput();
    }

    public function getOutput()
    {
        $this->isFlush = true;
        $lpContents = ob_get_clean();

        lpTemplate::beginBlock();

        $temp = function($lpFilename_, $lpContents, $lpVars_)
        {
            if(!defined("lpInTemplate"))
                define("lpInTemplate", true);

            foreach ($lpVars_ as $key => $value)
                $$key = $value;

            include($lpFilename_);
        };

        $temp($this->filename, $lpContents, $this->values);

        return lpTemplate::endBlock();
    }
}