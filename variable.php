<?php

class variable
{
    public static $vars = array();

    public function addVariable($name, $value) {
        self::$vars[$name] = $value;
    }

    public function updateValue($name, $value) {
        self::$vars[$name] = $value;
    }

    public function getValue($name) {
        if (isset(self::$vars[$name])) return self::$vars[$name];
        return NULL;
    }
}