<?php

function vardump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function debug($arr){
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

function random_html_color()
{
    return sprintf( '%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) );
}

function sortPlus($key){
    return function($a, $b) use ($key){
        return $a[$key] > $b[$key] ? 1 : -1;
    };
}
