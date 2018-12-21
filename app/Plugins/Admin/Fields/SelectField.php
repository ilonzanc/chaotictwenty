<?php

include_once('Field.php');

class SelectField extends Field
{
    public function render($key, $value = null, $data = null)
    {
        if (strpos($data,'_id'))
        {
            $data = str_replace('_id', ' ', $data);
            $data = str_replace('_', ' ', $data);
            $data = ucwords($data);
            $model = str_replace(' ', '', $data);

            if (class_exists($model))
            {
                $model = new $model();
                $data = $model->find();
            }
        }

        $field = '';
        $field .= '<select id="' . $key . '" name="' . $key . '">';
        $field .= '<option value="null">- No selection -</option>';

        foreach ($data as $_value)
        {
            $field .= '<option value="' . $_value[$model->valueField] . '" ' . (($_value['id'] == $value) ? 'selected="selected"' : '') . '>' . '(' . $_value['id'] . ') ' . $_value[$model->displayField] . '</option>';
        }

        $field .= '</select>';

        return $field;
    }
}
