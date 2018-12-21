<?php

class AdminModel extends Model
{
    /**
    *   Special fields that use a Field
    *   @var array
    */
    public $adminFields;

    /**
    *   Paginate the model in the admin
    *   @var array
    */
    public $adminPaginate = array(
        'perPage' => 10
    );

    /**
    *   Field to use in the admin
    *   @var string
    */
    public $displayField = 'id';

    /**
    *   Field that can be sorted on 
    *   @var string
    */
    public $sortableFields = array('id');

    /**
    *   Fields to show in the overview view
    *   @var array
    */
    public $overviewFields;

    /**
    *   Fields that have an image
    *   @var array
    */
    public $imageFields = array();

    /**
    *   Construct
    */
    public function __construct()
    {
        if (!$this->name) {
            $this->name = get_called_class();
        }

        if (!$this->tablename) {
            $this->tablename = strtolower(get_called_class() . 's');
        }

        $_fields = Database::fields($this->tablename);
        foreach ($_fields as $field) {
            $this->fields[$field['COLUMN_NAME']] = array(
                'columnType' => $field['DATA_TYPE'],
                'human' => ucwords(str_replace('_', ' ', $field['COLUMN_NAME']))
            );
        }

        // Relation fields
        if (isset($this->relations['manyToMany'])) {
            foreach ($this->relations['manyToMany'] as $key => $value) {
                $this->fields[$key . 's'] = array(
                    'columnType' => 'manyToMany',
                    'human' => ucwords(str_replace('_', ' ', $key . 's'))
                );
            }
        }

        $this->labels = array(
            'name' => $this->name,
            'namePlural' => $this->name . 's',
            'machineName' => strtolower($this->name),
            'machineNamePlural' => strtolower($this->name) . 's',
        );

        // Pagination
        if (isset($this->adminPaginate) && isset($this->adminPaginate['perPage'])) {
            $this->adminPaginate['pageAmount'] = ceil($this->_getAmount() / $this->adminPaginate['perPage']);
        }
    }
}
