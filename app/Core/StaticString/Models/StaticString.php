<?php

class StaticString extends AdminModel
{
    public $tablename = 'static_strings';

    public $displayField = 'string';

    public $sortableFields = array(
        'id',
        'scope',
        'string',
        'translation'
    );
}
