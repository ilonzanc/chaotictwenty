<?php

/*
*
*   Class for debugging
*
*/
class Debug
{
    /*
    *
    *   Pretty var_dump
    *
    */
    static function dump($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}
