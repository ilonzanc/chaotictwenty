<?php

$loginMiddleware = array(
    'middleware' => 'LoginMiddleware',
    'action' => 'loggedIn',
    'plugin' => 'Admin'
);

Route::add(
    array(
        'path' => '/admin/:tablename/:id/delete',
        'controller' => 'AdminController',
        'action' => 'delete',
        'plugin' => 'Admin',
        'middleware' => array($loginMiddleware)
    )
);

Route::add(
    array(
        'path' => '/admin/:tablename/:id/edit',
        'controller' => 'AdminController',
        'action' => 'edit',
        'plugin' => 'Admin',
        'middleware' => array($loginMiddleware)
    )
);

Route::add(
    array(
        'path' => '/admin/:tablename/:id',
        'controller' => 'AdminController',
        'action' => 'single',
        'plugin' => 'Admin',
        'middleware' => array($loginMiddleware)
    )
);

Route::add(
    array(
        'path' => '/admin/:tablename/create',
        'controller' => 'AdminController',
        'action' => 'create',
        'plugin' => 'Admin',
        'middleware' => array($loginMiddleware)
    )
);

Route::add(
    array(
        'path' => '/admin/:tablename',
        'controller' => 'AdminController',
        'action' => 'overview',
        'plugin' => 'Admin',
        'middleware' => array($loginMiddleware)
    )
);

Route::add(
    array(
        'path' => '/admin',
        'controller' => 'AdminController',
        'action' => 'dashboard',
        'plugin' => 'Admin',
        'middleware' => array($loginMiddleware)
    )
);

Route::add(
    array(
        'path' => '/admin/logout',
        'controller' => 'AdminController',
        'action' => 'logout',
        'plugin' => 'Admin'
    )
);

Route::add(
    array(
        'path' => '/admin/login',
        'controller' => 'AdminController',
        'action' => 'login',
        'plugin' => 'Admin'
    )
);
