<?php

session_start();

/*
*
*   Core class for DTWENTY, called D20 for easier use
*
*/
class DTWENTY
{
    /*
    *
    *   List of loaded plugins
    *
    */
    protected static $_plugins = array();

    /*
    *
    *   Initializing
    *
    */
    public function __construct()
    {
        $this->Plugins = new stdClass();

        $this->load(
            array(
                'Configure',
                'Route',
                'Database',
                'DTWENTY' => 'D20Exception',
                'Debug',
                'Controller',
                'Model',
                'View',
                'Helper',
                'Middleware',
                'Plugin',
                'StaticString',
            )
        );

        $this->loadPlugins();

        Database::connect();
    }

    /*
    *
    *   Initialize DTWENTY
    *
    */
    public function init()
    {
        // Find the current route and render it
        $route = Route::find();
        if ($route)
        {
            // Check Middlewares
            $this->middlewareCheck($route);

            // Render page
            $this->controllerAction($route);
        }
        else
        {
            throw new D20Exception('Route not found');
        }
    }

    /*
    *
    *   Load a Core file
    *
    */
    public function load($files)
    {
        foreach ($files as $key => $value)
        {
            if (gettype($key) == 'integer')
                $path = 'Core/' . $value . '/' . $value . '.php';
            else
                $path = 'Core/' . $key . '/' . $value . '.php';

            require_once $path;
        }
    }

    /*
    *
    *   Add plugin to the list to load
    *
    */
    static function addPlugin($name)
    {
        self::$_plugins[] = $name;
    }

    /*
    *
    *   Load Plugins
    *
    */
    public function loadPlugins()
    {
        foreach (self::$_plugins as $value)
        {
            $path = 'Plugins/' . $value . '/index.php';
            require_once $path;
            $this->Plugins->{$value} = new $value();
        }
    }

    /*
    *
    *   Activate a controllers action
    *
    */
    public function controllerAction($route)
    {
        include_once('Controllers/AppController.php');

        if (isset($route['route']['plugin']))
            $plugin = 'Plugins/' . $route['route']['plugin'] . '/';
        else $plugin = '';

        include_once($plugin . 'Controllers/' . $route['route']['controller'] . '.php');
        $this->Controller = new $route['route']['controller']();

        call_user_func_array(array($this->Controller, $route['route']['action']), $route['parameters']);
    }

    /**
    *   Check the middleware
    */
    protected function middlewareCheck($route)
    {
        if (isset($route['route']['middleware']))
        {
            foreach ($route['route']['middleware'] as $middleware)
            {
                if (isset($middleware['plugin'])) $plugin = 'Plugins/' . $middleware['plugin'] . '/';
                else $plugin = '';
                include_once($plugin . 'Controllers/Middleware/' . $middleware['middleware'] . '.php');

                $_middleware = new $middleware['middleware']();
                if (!$_middleware->{$middleware['action']}())
                {
                    $redirect = $_middleware->redirect;
                    if (isset($middleware['redirect']))
                        $redirect = $middleware['redirect'];

                    $this->redirect($redirect);
                }
            }
        }
    }

    /**
    *   Redirect to a different page
    */
    static function redirect($path)
    {
        $path = PROJECT_ROOT . $path;
        $path = str_replace('//', '/', $path);
        header('Location: ' . $path);
        die();
    }

    /*
    *
    *   Throw error message
    *
    */
    static function throwError($message = 'Something went from with DTWENTY', $code = 500)
    {
        throw new D20Exception($message);
    }
}
