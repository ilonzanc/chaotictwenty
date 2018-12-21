<?php

/*
*
*   Class for everything views related
*
*/
class View
{
    /*
    *
    *   Render a view
    *
    */
    public function render($content, $plugin = null)
    {
        $this->content = $content;
        $this->plugin = $plugin;

        if ($plugin == null) $path = 'Views/Main/main.dng';
        else $path = 'Plugins/' . $plugin . '/Views/main.dng';

        if (!include_once($path))
            include_once('Views/Main/main.dng');
    }

    /*
    *
    *   Render the content
    *
    */
    public function content($content = null, $plugin = null)
    {
        if ($content == null) $content = $this->content;
        if ($plugin == null) $plugin = $this->plugin;

        if ($plugin == null) include_once('Views/' . $content . '.dng');
        else include_once('Plugins/' . $plugin . '/Views/' . $content . '.dng');
    }

    /*
    *
    *   Set variables for the view
    *
    */
    public function set($values)
    {
        foreach ($values as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
    *   Return an element
    *   @return void
    */
    public function element($name, $data = null, $plugin = null)
    {
        $path = 'Views/Elements/' . $name . '.dng';
        if ($plugin != null) $path = 'Plugins/' . $plugin . '/' . $path;
        $path = str_replace('//', '/', $path);

        if (is_array($data))
        {
            foreach ($data as $key => $value)
            {
                ${$key} = $value;
            }
        }

        include($path);
    }
}
