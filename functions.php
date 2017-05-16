<?php

class functions
{
    public static $func = array();

    public function setFunc($funcname, $func) {
        self::$func[$funcname] = $func;
    }

    public function getFunc($funcname) {
        if (isset(self::$func[$funcname])) return self::$func[$funcname];
        return NULL;
    }
}