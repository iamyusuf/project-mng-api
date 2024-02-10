<?php

namespace App\Classes;

class Registry
{

    protected array $_items = array();

    public function __set($key, $value)
    {
        $this->_items[$key] = $value;
    }

    public function __get($key)
    {
        return $this->_items[$key] ?? null;
    }

    public function getArray(string $key): array
    {
        return $this->_items[$key] ?? [];
    }

    public function __isset($key)
    {
        if (isset($this->_items[$key])) {
            return (false === empty($this->_items[$key]));
        } else {
            return null;
        }
    }
}
