<?php

class lpFactory
{
    static private $data;
    static private $creator;

    static public function register($name, $creator, $tag = null)
    {
        self::$creator[$name][$tag] = $creator;
    }

    static public function get($name, $tag = null)
    {
        if(empty(self::$data[$name][$tag]))
        {
            $creator = self::$creator[$name][$tag];
            self::$data[$name][$tag] = $creator();
        }

        return self::$data[$name][$tag];
    }
}