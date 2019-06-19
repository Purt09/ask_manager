<?php

function vardump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function debug($arr){
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

use yii\helpers\Html;
function createtime($seconds)
{

    if($seconds < 86400){
        $class = 'warning';
        if ($seconds < 3600) $class = 'danger';
    } else $class = 'success';

    $times = array();

    // считать нули в значениях
    $count_zero = false;

    // количество секунд в году не учитывает високосный год
    // поэтому функция считает что в году 365 дней
    // секунд в минуте|часе|сутках|году
    $periods = array(60, 3600, 86400, 31536000);

    for ($i = 3; $i >= 0; $i--)
    {
        $period = floor($seconds/$periods[$i]);
        if (($period > 0) || ($period == 0 && $count_zero))
        {
            $times[$i+1] = $period;
            $seconds -= $period * $periods[$i];

            $count_zero = true;
        }
    }

    $times[0] = $seconds;


    // значения времени
    $times_values = array('сек.','мин.','час.','д.','г.');

    $time = ($times);
    for ($i = count($time)-1; $i >= 0; $i--)
    {
        $result .= $time[$i] . ' ' . $times_values[$i] . ' ';
    }


    $html = Html::tag('span', Html::encode('Осталось:  ' . $result), ['class' => 'label label-' . $class]);
    return $html;
}