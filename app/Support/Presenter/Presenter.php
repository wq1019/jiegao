<?php

namespace App\Support\Presenter;

class Presenter
{
    protected $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function __get($var)
    {
        return $this->object->$var;
    }

    public function __call($method, $arguments)
    {
        return $this->object->$method(...$arguments);
    }

    public function __isset($name)
    {
        return isset($this->object->$name);
    }

    public function __unset($name)
    {
        unset($this->object->$name);
    }
}
