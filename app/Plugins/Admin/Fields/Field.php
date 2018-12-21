<?php

class Field
{
    /**
    *   Render a normal field
    *   @return string
    */
    public function render($key, $value = null, $data = null)
    {
        return '<input type="text" ' .
                'id="' . $key . '" ' .
                'name="' . $key . '" ' .
                'placeholder="' . ucfirst($key) . '" ' .
                'value="' . $value . '" ' .
                '>';
    }
}
