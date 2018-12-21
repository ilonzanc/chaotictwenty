<?php

/*
*
*   Plugin class
*
*/
class Plugin
{
    /*
    *
    *   Plugin folder
    *
    */
    public $folder;

    /*
    *
    *   Contruct the class
    *
    */
    public function __construct()
    {
        $this->folder = get_called_class();
    }
}
