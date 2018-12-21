<?php

include_once('Plugins/Admin/Models/AdminModel.php');

class Admin extends Plugin
{
    /**
    *   Array of loaded models
    *   @var Array
    */
    protected static $_models = array();

    /**
    *   The navigation for the CMS
    *   @var Array
    */
    protected static $_nav = array();

    /**
    *   Add a model to use in the plugin
    */
    static function useModel($modelName, $type = null)
    {
        if ($type == null)
        {
            $path = 'Models/' . $modelName . '.php';
        }
        else if ($type == 'Core')
        {
            // Core file
            $path = 'Core/' . $modelName . '/Models/' . $modelName . '.php';
        }
        else
        {
            // Plugin
            $path = 'Plugins/' . $type . '/Models/' . $modelName . '.php';
        }

        include_once($path);
        self::$_models[$modelName] = new $modelName();
    }

    /**
    *   Get all the models used in the Admin
    *   @var array
    */
    static function getModels()
    {
        return self::$_models;
    }

    /**
    *   Set the navigation to be used in the CMS
    *   @param Array - the navigation
    *   @return void
    */
    static function navigation($nav)
    {
        self::$_nav = $nav;
    }

    /**
    *   Get the navigation to be used in the CMS
    *   @return Array
    */
    static function getNavigation()
    {
        return self::$_nav;
    }
}
