<?php

include_once('SelectField.php');

class MediaField extends SelectField
{
    public function render($key, $value = null, $data = null)
    {
        if (strpos($data,'_id'))
        {
            $model = ucfirst(str_replace('_id', '', $data));
            $model = new $model();
            $data = $model->find();
        }

        $field = '';
        $field .= '<select id="' . $key . '" name="' . $key . '">';
        $field .= '<option value="null">- No selection -</option>';

        foreach ($data as $_value)
        {
            $path = str_replace('//', '/', PROJECT_ROOT . 'webroot/img/uploads/' . $_value['image_url']);
            $field .= '<option class="js-option--' . $_value[$model->valueField] . '" value="' . $_value[$model->valueField] . '" style="background-image:url(' . $path . ');" ' . (($value == $_value[$model->valueField]) ? 'selected="selected"' : '') . '>' . '(' . $_value['id'] . ') ' . $_value[$model->displayField] . '</option>';
        }

        $field .= '</select>';
        $field .= '<div class="js-image--preview" id="js-image--preview--'.$key.'"></div>';
        $field .= '<script type="text/javascript">
                    (() => {
                        var style = document.querySelector("select#'.$key.' option.js-option--'.$value.'").style.backgroundImage;
                        document.getElementById("js-image--preview--'.$key.'").style.backgroundImage = style;
                        document.getElementById("'.$key.'").addEventListener("change", function() {
                            var style = document.querySelector("select#'.$key.' option.js-option--"+this.value).style.backgroundImage;
                            document.getElementById("js-image--preview--'.$key.'").style.backgroundImage = style;
                        });
                    })();
                   </script>';

        return $field;
    }
}
?>
