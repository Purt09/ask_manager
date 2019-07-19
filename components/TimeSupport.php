<?php

namespace app\components;

use app\modules\task\models\Task;
use yii\helpers\Html;


class TimeSupport
{

    /**
     * Принимает количесвто секунд
     * Возращает html code вывода времени в читаемом виде
     * @param $seconds
     * @return string
     */
    public static function createtime($seconds)
    {
        if ($seconds < 86400) {
            $class = 'warning';
            $text = 'Осталось: ';

        } elseif ($seconds < 3600) {
            $class = 'danger';
        } else {
            $class = 'success';
            $text = 'Осталось: ';
        }


        $date = Date('Y-m-d     h:m', time() + $seconds);
        $times = array();

        // считать нули в значениях
        $count_zero = false;

        // количество секунд в году не учитывает високосный год
        // поэтому функция считает что в году 365 дней
        // секунд в минуте|часе|сутках|году
        $periods = array(60, 3600, 86400, 31536000);

        for ($i = 3;
             $i >= 0;
             $i--) {
            $period = floor($seconds / $periods[$i]);
            if (($period > 0) || ($period == 0 && $count_zero)) {
                $times[$i + 1] = $period;
                $seconds -= $period * $periods[$i];
                $count_zero = true;
            }
        }

        $times[0] = $seconds;


// значения времени константы
        $times_values = array('сек.', 'минут', 'часов', 'дней', 'год');

        $time = ($times);
// Выводит только 2 значения (мин и сек или часы и мин или дни и часы)
        for ($i = count($time) - 1; $i >= count($time) - 2; $i--)
            $result .= $time[$i] . ' ' . $times_values[$i] . ' ';
        $html = Html::tag('span', Html::encode($text . $result . '   (' . $date . ')'), ['class' => 'label label-' . $class]);
        if($seconds < 0) $html = '';
        return $html;
    }


    /**Присвает статус задаче исходя из ее времени
     * @param $tasks
     */
    public
    static function changeStatus($tasks)
    {
        foreach ($tasks as $t) {
            if ($t['updated_at'] != null && $t['status'] != 0) {
                // Проверка закончилось ли время
                if ($t['updated_at'] - time() < 0) {
                    $t->setStatus(2);
                } else {
                    $t->setStatus(1);
                }
            }
        }
    }
}