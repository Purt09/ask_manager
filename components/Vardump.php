<?php

namespace app\components;


class Vardump
{
    public static function vardump($var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}