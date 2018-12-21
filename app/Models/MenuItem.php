<?php

class MenuItem extends AdminModel
{
    public $tablename = 'menu_items';

    public $relations = array(
        'hasOne' => array(
            'Menu' => array(
                'foreignKey' => 'menu_id',
                'targetForeignKey' => 'id',
                'displayField' => 'name',
            ),
            'StaticString' => array(
                'className' => 'StaticString',
                'foreignKey' => 'static_string_id',
                'targetForeignKey' => 'id',
                'displayField' => 'string',
            ),
        )
    );

    public $adminFields = array(
        'menu_id' => array('type' => 'Select'),
        'static_string_id' => array('type' => 'Select'),
        'link' => array('type' => 'LinkPicker'),
    );
}
