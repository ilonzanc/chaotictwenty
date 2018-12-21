<?php

include_once('Field.php');

class TextareaField extends Field
{
    /**
    *   Render a normal field
    *   @return string
    */
    public function render($key, $value = null, $data = null)
    {
        return '<textarea type="text" ' .
                'id="' . $key . '" ' .
                'name="' . $key . '" ' .
                'placeholder="' . ucfirst($key) . '"
                >' . $value . '</textarea>';
    }
}
