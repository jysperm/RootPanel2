<?php

namespace RootPanel\Core\Core;

use LightPHP\Model\Wrapper\CachedModel;
use LightPHP\Model\Adapter\PDOQuery;

class Model extends CachedModel
{
    /** @var PDOQuery */
    public static $source;
    /** @var string */
    public static $driver = 'LightPHP\Model\Adapter\PDOQuery';
} 