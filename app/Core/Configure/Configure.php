<?php

class Configure
{
    /*
    *
    *   Variable where the config goes
    *
    */
    protected static $_instances = array();

    /*
    *
    *   Write configure data
    *
    */
    static function write($name, $data)
    {
        self::$_instances[$name] = $data;
    }

    /*
    *
    *   Read configure data
    *
    */
    static function read($name)
    {
        if (isset(self::$_instances[$name]))
            return self::$_instances[$name];

        throw new D20Exception('Configure::read(' . $name . '): not found');
    }
}
