<?php

/**
 * Class lpFactory
 *
 * 一个简易的对象生成器，模拟工厂模式。
 */

class lpFactory
{
    /**
     * @var array 对象数组
     */
    static private $data;
    /**
     * @var array 对象构造器数组
     */
    static private $creator;

    /**
     * 注册一个对象构造器
     *
     * @param $name         类名
     * @param $creator      构造器
     */
    static public function register($name, $creator)
    {
        self::$creator[$name] = $creator;
    }

    /**
     * 取出或构造一个新对象
     *
     * @param $name     类名
     * @param null $tag 额外信息
     *
     * @return mixed    对象
     */
    static public function get($name, $tag = null)
    {
        if(empty(self::$data[$name][$tag]))
        {
            $creator = self::$creator[$name];
            self::$data[$name][$tag] = $creator($tag);
        }

        return self::$data[$name][$tag];
    }
}