<?php

/**
 * 该类提供了简易的国际化功能.
 */

class lpLocale
{
    /**
     * @var lpLocale    唯一实例
     * 该类通常只有一个实例, 虽然你可以创建多个, 但该变量只会记住最后一个创建的实例.
     * 可通过 i() 来获取该唯一实例.
     */
    static private $instance;

    /**
     * @var string  本地化文件根目录
     */
    private $localeRoot;


    /**
     * @return lpLocale 获取唯一实例
     * @see $instance
     */
    static public function i()
    {
        return self::$instance;
    }

    /**
     * @param string $localeRoot    本地化文件根目录
     * @param string $default       默认语言
     */
    public function __construct($localeRoot, $default = "zh_CN")
    {
        global $lpCfg;

        $this->localeRoot = $localeRoot;

        $lang = isset($_COOKIE["language"]) ? $_COOKIE["language"] : $default;
        if(!$lang || !preg_match("/^[_A-Za-z]+$/", $lang) || !is_dir("{$localeRoot}/{$lang}"))
            $lang = $default;

        $lpCfg["lang"] = $lang;
        self::$instance = $this;
    }

    public function load($files, $ext = ".php")
    {
        global $lpCfg;

        if(!is_array($files))
            $files = [$files];

        foreach($files as $file)
            require_once("{$this->localeRoot}/{$lpCfg["lang"]}/{$file}{$ext}");
    }

    public function file($file, $locale = null)
    {
        global $lpCfg;

        if(!$locale)
            $locale = $lpCfg["lang"];

        return "{$this->localeRoot}/{$locale}/{$file}";
    }
}