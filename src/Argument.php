<?php

namespace NewWorldOrders\Scaffold;

class Argument
{
    public $name = '';
    public $singular_snake = '';
    public $plural_snake = '';
    public $singular_camel = '';
    public $plural_camel = '';

    public function __construct($name)
    {
        $this->name = strtolower($name);
        $this->singular_snake = $this->name;
        $this->plural_snake = str_plural($this->name);
        $this->singular_camel = self::camelize($this->singular_snake);
        $this->plural_camel = self::camelize($this->plural_snake);
    }

    static public function camelize($str)
    {
        $str = ucwords($str, '_');
        return str_replace('_', '', $str);
    }

    static public function snakize($str)
    {
        $str = preg_replace('/[a-z]+(?=[A-Z])|[A-Z]+(?=[A-Z][a-z])/', '\0_', $str);
        return strtolower($str);
    }
}
