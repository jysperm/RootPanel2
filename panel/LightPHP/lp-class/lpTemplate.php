<?php

/**
*   该文件包含 lpTemplate 的类定义.
*
*   @package LightPHP
*/

class lpTemplate
{
    private $filename;
    private $values = [];
    private $isFlush = false;

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

    public function __set($k, $v)
    {
        $this->setValue($k, $v);
    }

    public function __get($k)
    {
        return $this->values[$k];
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