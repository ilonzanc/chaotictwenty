<?php

    define('PROJECT_ROOT', implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/');
    
    // Load the core file
    include_once('Core/DTWENTY/DTWENTY.php');

    // Initialize a new instance
    $D20 = new DTWENTY();

    // Start DTWENTY
    $D20->init();
