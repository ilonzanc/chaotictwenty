<?php

// Load plugin routes
include_once 'routes.php';

// Load models
Admin::useModel('StaticString', 'Core');
include_once $_SERVER['DOCUMENT_ROOT'] . '/' . PROJECT_ROOT . 'Config/admin.php';
