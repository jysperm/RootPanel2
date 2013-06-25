<?php

/**
 * 该类提供了简易的国际化功能.
 */

class lpLocale implements ArrayAccess
{
    /**
     * @var string  本地化文件根目录
     */
    private $localeRoot;
    /**
     * @var string 语言
     */
    private $language;
    /**
     * @var array 数据
     */
    private $data = [];
    private $exitsData = [];

    /**
     * 构造一个实例
     *
     * @param string $localeRoot 本地化文件根目录
     * @param string $language    语言
     */
    public function __construct($localeRoot, $language)
    {
        $this->localeRoot = $localeRoot;
        $this->language = $language;
    }

    public function load($files, $ext = ".php")
    {
        if(!is_array($files))
            $files = [$files];

        foreach($files as $file)
        {
            $filename = "{$file}{$ext}";

            if(in_array($filename, $this->exitsData))
                return $this->data;
            else
                $this->exitsData[]= $filename;

            $this->data = array_merge($this->data, include("{$this->localeRoot}/{$this->language}/{$filename}"));
        }

        return $this->data;
    }

    public function file($file, $locale = null)
    {
        if(!$locale)
            $locale = $this->language;

        return "{$this->localeRoot}/{$locale}/{$file}";
    }

    public function language()
    {
        return $this->language;
    }

    public function get($key)
    {
        return $this->data[$key];
    }

    public function data()
    {
        return $this->data;
    }

    /* ArrayAccess */
    public function offsetSet($offset, $value)
    {

    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetUnset($offset)
    {

    }

    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * 判断客户端语言
     *
     * * 首先根据 Cookie
     * * 然后根据 HTTP Accept-Language
     * * 最后私用默认语言
     *
     * @param $localeRoot           本地化文件根目录
     * @param $defaultLanguage      默认语言
     * @param string $cookieName    储存语言的Cookie
     * @return string
     */
    static public function judegeLanguage($localeRoot, $defaultLanguage, $cookieName="language")
    {
        $lang = isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : "";
        if($lang && !preg_match("/^[_A-Za-z]+$/", $lang) && is_dir("{$localeRoot}/{$lang}"))
            return $_COOKIE[$cookieName];

        if($_SERVER["HTTP_ACCEPT_LANGUAGE"])
        {
            $languages = explode(",", str_replace("-", "_", $_SERVER["HTTP_ACCEPT_LANGUAGE"]));

            foreach($languages as $i)
                if(preg_match("/^[_A-Za-z]+$/", $i) && is_dir("{$localeRoot}/{$lang}"))
                    return $i;
        }

        return $defaultLanguage;
    }
}
