<?php

namespace app\components;


class Vardump
{
    function vardump($var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}