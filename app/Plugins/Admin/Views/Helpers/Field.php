<?php

class FieldHelper extends Helper
{
    /**
    *   Create a field using the helper
    *   @return string
    */
    public function field($model, $key, $value = null, $data = null)
    {
        $Form = new Form();

        if (isset($model->adminFields[strtolower($key)]))
        {
            $adminField = $model->adminFields[strtolower($key)]['type'] . 'Field';

            $path = 'Fields/' . $adminField . '.php';
            if (!is_file($path)) $path = 'Plugins/Admin/Fields/' . $adminField . '.php';
            include_once($path);

            $field = new $adminField();
            return $field->render($key, $value, $data);
        }

        // Default
        $field = $Form->input($key, $value);
        return $field;
    }
}
