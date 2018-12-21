<?php

/**
*   Get a static string from the database
*   @var string
*/
function __ss($scope, $string)
{
    $_string = Database::SQLselect('SELECT * FROM static_strings WHERE scope = "' . $scope . '" AND string = "' . $string . '";')[0];
    return (($_string && $_string['translation'] != '') ? $_string['translation'] : $string);
}
