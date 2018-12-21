<?php

Admin::useModel('Menu');
Admin::useModel('MenuItem');
Admin::useModel('Page');
Admin::useModel('User');

Admin::navigation(array(
    'Website' => array(
        'User',
        'Page',
    ),
    'Menus' => array(
        'Menu',
        'MenuItem',
    ),
    'Media',
));
