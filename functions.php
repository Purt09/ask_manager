<?php

function vardump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function debug($arr){
    echo '<pre>' . print_r($arr, true) . '</pre>';
}
