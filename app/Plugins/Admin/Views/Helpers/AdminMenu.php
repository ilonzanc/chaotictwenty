<?php

class AdminMenu extends Helper
{
    /**
    *   Create a list of menu items
    *   @var array
    */
    public function getMenu()
    {
        $_menu = array();
        $adminNav = Admin::getNavigation();
        $adminModels = Admin::getModels();

        foreach ($adminNav as $key => $value)
        {
            if (gettype($value) == 'array') {
                foreach ($value as $model) {
                    $_menu[$key][] = array(
                        'tablename' => $adminModels[$model]->tablename,
                        'name' => $adminModels[$model]->labels['namePlural'],
                    );
                }
            } else {
                $_menu[] = array(
                    'tablename' => $adminModels[$value]->tablename,
                    'name' => $adminModels[$value]->labels['namePlural'],
                );
            }
        }

        return $_menu;
    }
}
