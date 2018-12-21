<?php

/*
*
*   Route file for all the routes
*   Example:
*
*   Route::add(
*       array(
*           'path' => '/',
*           'controller' => 'HomeController',
*           'action' => 'home',
*       )
*   );
*/

Route::add(
    array(
        'path' => '/',
        'controller' => 'HomeController',
        'action' => 'home'
    )
);

Route::add(
    array(
        'path' => '/:slug',
        'controller' => 'PageController',
        'action' => 'single'
    )
);
