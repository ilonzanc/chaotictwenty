<?php

include_once('Field.php');

class CheckboxField extends Field
{
    /**
    *   Render a checkbox (tinyint)
    *   @return string
    */
    public function render($key, $value = null, $data = null)
    {
        $string = '<input type="hidden" ' .
                  'id="' . $key . '" ' .
                  'name="' . $key . '" ' . 
                  'value="off">';

        $string .= '<input type="checkbox" ' .
                   'id="' . $key . '" ' .
                   'name="' . $key . '" ';

        if ($value == 1) $string .= ' checked ';

        $string .= '>';

        return $string;
    }
}
