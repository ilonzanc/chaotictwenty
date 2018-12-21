<?php

class Form extends Helper
{
    /**
    *   Start a form
    *   @var string
    */
    public function start($options = array())
    {
        $input = '<form ' . $this->_parseOptions($options) . ' enctype="multipart/form-data">';
        return $input;
    }

    /**
    *   End a form
    *   @var string
    */
    public function end()
    {
        $input = '</form>';
        return $input;
    }

    /**
    *   Create a freeform field
    *   @var string
    */
    public function field($options)
    {
        $input = '<input ' . $this->_parseOptions($options) . ' >';
        return $input;
    }

    /**
    *   Create a label
    *   @var string
    */
    public function label($name, $text)
    {
        $text = ucwords(str_replace('_', ' ', $text));
        $input = '<label for="' . $name . '">' . $text . '</label>';
        return $input;
    }

    /**
    *   Create an input field
    *   @var string
    */
    public function input($name, $value = '')
    {
        if ($value == '' && isset($_POST[$name])) $value = $_POST[$name];

        return '<input type="text" ' .
                'id="' . $name . '" ' .
                'name="' . $name . '" ' .
                'placeholder="' . ucfirst($name) . '" ' .
                'value="' . $value . '" ' .
                '>';
    }

    /**
    *   Create a password field
    *   @var string
    */
    public function password($name = 'password')
    {
        $value = (isset($_POST['username']) ? $_POST['username'] : '');

        return '<input type="password" ' .
                'id="' . $name . '" ' .
                'name="' . $name . '" ' .
                'placeholder="' . ucfirst($name) . '" ' .
                'value="' . $value . '" ' .
                '>';

    }

    /**
    *   Create a submit button
    *   @var string
    */
    public function submit()
    {
        return '<input type="submit">';
    }

    /**
    *   Parse $options
    *   @var string
    */
    public function _parseOptions($options)
    {
        $_return = '';
        foreach ($options as $key => $value)
            $_return .= ' ' . $key . '="' . $value . '" ';
        return $_return;
    }
}
