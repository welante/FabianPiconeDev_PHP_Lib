<?php

function pre_var_dump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function pre_print_r($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';	
}

// Transform Object it into a multidimensional array using recursion
function convertObjectToArray($obj) {
    if(!is_array($obj) && !is_object($obj)) return $obj;
    if(is_object($obj)) $obj = get_object_vars($obj);
    // __FUNCTION__ : Name der aktuellen Funktion.
    return array_map(__FUNCTION__, $obj);
}