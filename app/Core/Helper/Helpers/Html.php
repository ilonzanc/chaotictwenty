<?php

class Html extends Helper
{
    /*
    *
    *   Return a URL for a route
    *
    */
    public function link($shorthand, $parameters = array())
    {
        $routes = Route::getAll();
        $path = array_search($shorthand, array_column($routes, 'shorthand'));

        if ($path !== false)
        {
            $route = $routes[$path];
            $_route = $route['path'];

            foreach ($parameters as $key => $value)
            {
                $_route = str_replace(':' . $key, $value, $_route);
            }

            return $_route;
        }
        else
        {
            throw new D20Exception('Route not found');
        }
    }

    /**
    *   Return a <link> tag
    *   @var string
    */
    public function style($name, $plugin = null)
    {
        $path = PROJECT_ROOT . 'webroot/css/' . $name . '.css';
        if ($plugin != null) $path = '/Plugins/' . $plugin . $path;
        $path = str_replace('//', '/', $path);

        return '<link rel="stylesheet" type="text/css" href="' . $path . '">';
    }

    /**
    *   Return a path to an image in the webroot
    *   @var string
    */
    public function image($path)
    {
        $path = PROJECT_ROOT . 'webroot/img/' . $path;
        $path = str_replace('//', '/', $path);
        return $path;
    }

    /**
    *   Return a favicon tag
    *   @var string
    */
    public function favicon($path)
    {
        $path = PROJECT_ROOT . 'webroot/' . $path;
        $path = str_replace('//', '/', $path);
        return '<link rel="icon" href="' . $path . '">';
    }
}
