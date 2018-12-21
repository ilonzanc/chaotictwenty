<?php

Admin::useModel('Menu');
Admin::useModel('MenuItem');
Admin::useModel('Page');
Admin::useModel('User');
Admin::useModel('Chronicle');

Admin::navigation(array(
    'Website' => array(
        'User',
        'Media',
        'Page',
    ),
    'Menus' => array(
        'Menu',
        'MenuItem',
    ),
    'Chronicles' => array(
        'Chronicle',
    )
));
