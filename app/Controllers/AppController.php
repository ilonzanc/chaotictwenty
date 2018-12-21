<?php

class AppController extends Controller
{
    public $helpers = array(
        'Html',
        'Form'
    );

    protected function _getMenu($name)
    {
        $menu = $this->MenuItem->find();

        $menuItems = array();
        foreach ($menu as $item)
        {
            if ($item['Menu'][0]['name'] == $name)
            {
                $menuItems[] = $item;
            }
        }

        return $menuItems;
    }
}
