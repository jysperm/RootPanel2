<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class lpAPCCache implements ArrayAccess
{
    private $config = [
        "ttl" => 0
    ];

    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
    }

    public function set($k, $v, $ttl = -1)
    {
        apc_store($k, $v, $ttl >= 0 ? $ttl : $this->config["ttl"]);
    }

    public function get($k)
    {
        $r = apc_fetch($k, $s);
        if($s)
            return $r;
        return null;
    }

    public function check($k, $seter, $ttl = -1)
    {
        if(apc_exists($k))
            return $this->get($k);

        $v = $seter();
        $this->set($k, $v, $ttl);
        return $v;
    }

    public function delete($k)
    {
        return apc_delete($k);
    }

    /* ArrayAccess */
    public function offsetSet($offset, $value)
    {
        apc_store($offset, $value, $this->config["ttl"]);
    }

    public function offsetExists($offset)
    {
        return apc_exists($offset);
    }

    public function offsetUnset($offset)
    {
        return apc_delete($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
}