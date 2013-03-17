<?php

/**
 * 该类提供了简易的国际化功能.
 */

class lpLocale
{
    static private $instance;
    private $localeRoot;

    static public function i()
    {
        return self::$instance;
    }

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

    public function load($files)
    {
        global $lpCfg;

        if(!is_array($files))
            $files = [$files];

        foreach($files as $file)
            require_once("{$this->localeRoot}/{$lpCfg["lang"]}/{$file}");
    }

    public function file($file, $locale = null)
    {
        global $lpCfg;

        if(!$locale)
            $locale = $lpCfg["lang"];

        return "{$this->localeRoot}/{$locale}/{$file}";
    }
}