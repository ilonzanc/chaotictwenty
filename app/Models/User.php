<?php

class User extends AdminModel
{
    public $displayField = 'username';

    public $overviewFields = array(
        'id',
        'media_id',
        'username',
        'email',
        'admin',
    );

    public $imageFields = array(
        'media_id',
    );

    public $adminFields = array(
        'media_id' => array('type' => 'Media'),
    );

    public $relations = array(
        'hasOne' => array(
            'Media' => array(
                'foreignKey' => 'media_id',
                'targetForeignKey' => 'id',
            ),
        )
    );
}
