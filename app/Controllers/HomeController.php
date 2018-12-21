<?php

class HomeController extends AppController
{
    public $models = array('MenuItem');

    public function home()
    {
        $this->View->set(array(
            'menu' => $this->_getMenu('home')
        ));

        $this->View->render('Home/home');
    }
}
