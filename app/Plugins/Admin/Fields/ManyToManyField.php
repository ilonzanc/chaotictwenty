<?php

include_once('Field.php');

class ManyToManyField extends Field
{
    public function render($key, $value = null, $data = null)
    {
        $model = ucfirst(substr($data, 0, -1));
        $model = new $model();
        $data = $model->find();

        $field = '<ul class="admin--manytomany">';
        foreach ($data as $_value)
        {
            $selected = false;
            if (is_array($_value) && $value != null) {
                $selected = (array_search($_value, $value) !== false);
            }

            $displayField = $_value[$model->displayField];

            $field .= '<li>';
            $field .= '<input type="checkbox" id="' . $key . $displayField .
                      '" name="' . $key . '[]" ' . 
                      'value="' . $_value['id'] . '"' .
                      (($selected) ? 'checked' : '') . '> ';

            $field .=  '<label for="' . $key . $displayField . '">' . $displayField . '</label>';
            $field .= '</li>';         
        }

        $field .= '</ul>';

        return $field;
    }
}
