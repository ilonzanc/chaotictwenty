<?php

class Chronicle extends AdminModel
{
    public $overviewFields = array(
        'id',
        'title',
        'media_id',
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
