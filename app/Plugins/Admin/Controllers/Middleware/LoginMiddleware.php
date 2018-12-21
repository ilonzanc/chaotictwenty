<?php

class LoginMiddleware extends Middleware
{
    public $redirect = '/admin/login';

    /**
    *   Check if the user is logged in
    *   @var bool
    */
    public function loggedIn()
    {
        if (isset($_SESSION['DTWENTY']))
            return true;
        return false;
    }
}
