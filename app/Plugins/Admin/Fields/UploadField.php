<?php

include_once('Field.php');

class UploadField extends Field
{
    public function render($key, $value = null, $data = null)
    {
        return '<input type="file" id="' . $key . '" name="' . $key . '">';
    }
}
