<?php

class LinkPickerField extends Field
{
    /**
    *   Render a select field with
    *   @return string
    */
    public function render($key, $value = null, $data = null)
    {
        $return = '';
        $routes = Route::getAll(false);

        $return .= '<select type="text" id="' . $key . '">';
        $return .= '<option value="" parameters="">- No selection -</option>';

        foreach ($routes as $route)
        {
            $parameters = array();
            $_parameters = explode('/', $route['path']);
            foreach ($_parameters as $param) {
                if (strpos($param, ':') > -1) {
                    $parameters[] = $param;
                }
            }
            $parameters = implode(',', $parameters);

            $return .= '<option value="' . $route['shorthand'] . '" parameters="' . $parameters . '" path="' . $route['path'] . '">' . $route['shorthand'] . '</option>';

        }

        $return .= '</select><br>';
        $return .= '<input placeholder="Path" id="' . $key . '_final" type="text" value="' . $value . '" name="' . $key . '">';

        $return .= '<script type="text/javascript">
            (() => {
                var hidden = document.getElementById("' . $key . '_final");
                document.getElementById("'.$key.'").addEventListener("change", function() {
                    var item = document.querySelector("option[value=\'"+this.value+"\']");
                    var parameters = item.getAttribute("parameters").split(",");
                    var path = item.getAttribute("path");
                    hidden.value = path;
                });
            })();
        </script>';

        return $return;
    }
}
