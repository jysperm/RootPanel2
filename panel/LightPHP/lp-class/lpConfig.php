<?php

/**
 * Class lpConfig
 *
 * 该类提供了一个配置信息管理类,
 * 配置信息原则上是只读的，但你可以通过载入新的配置文件来覆盖旧的设置.
 */

class lpConfig implements ArrayAccess
{
    private $data = [];

    public function load($file)
    {
        if(is_array($file))
        {
            foreach($file as $i)
                $this->load($i);
            return;
        }

        $newConfig = include($file);

        $this->data = array_merge($this->data, $newConfig);
    }

    public function data()
    {
        return $this->data;
    }

    public function get($key)
    {
        return $this->data[$key];
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
}