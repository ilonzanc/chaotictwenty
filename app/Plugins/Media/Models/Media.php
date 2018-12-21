<?php

class Media extends AdminModel
{
    public $displayField = 'title';

    public $adminFields = array(
        'image_url' => array('type' => 'Upload'),
    );

    public $imageFields = array(
        'image_url',
    );
}
