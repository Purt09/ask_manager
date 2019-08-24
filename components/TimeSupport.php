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
    public function createtime($time)
    {
        $seconds = $time - time();
        if ($seconds < 0) {
            $text = 'Просрочено на: ';
        } elseif ($seconds < 86400) {
            $text = 'Осталось: ';

        } else {
            $text = 'Осталось: ';
        }

        $seconds = abs($seconds);
        $date = Date('Y-m-d', $time);
        $times = array();

        // считать нули в значениях
        $count_zero = false;

        // количество секунд в году не учитывает високосный год
        // поэтому функция считает что в году 365 дней
        // секунд в минуте|часе|сутках|году
        $periods = array(60, 3600, 86400, 31536000);

        for ($i = 3; $i >= 0; $i--) {
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
//        $html = Html::tag('span', Html::encode($text . $result . '   (' . $date . ')'), ['class' => 'label label-' . $class]);
        if ($seconds < 0) $html = '';
        return $text . $result . '   (' . $date . ')';
    }


    /**Присвает статус задаче исходя из ее времени
     * @param $tasks
     */
    public static function changeStatus($tasks)
    {
        $time = time();
        foreach ($tasks as $t) {
            if ($t['updated_at'] != null && $t['status'] != 0) {
                // Проверка закончилось ли время
                if ($t['updated_at'] - $time < 0) {
                    $t->setStatus(2);
                } else {
                    $t->setStatus(1);
                }
            }
        }
    }

    public static function getTimeleft($seconds)
    {
        $seconds = time() - $seconds;

        $text = ' назад';

        $seconds = abs($seconds);
        $times = array();

        // считать нули в значениях
        $count_zero = false;

        // количество секунд в году не учитывает високосный год
        // поэтому функция считает что в году 365 дней
        // секунд в минуте|часе|сутках|году
        $periods = array(60, 3600, 86400, 31536000);

        for ($i = 3; $i >= 0; $i--) {
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
        if ($seconds < 0) $html = '';
        return $result . $text;
    }
}