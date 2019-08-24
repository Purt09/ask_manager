<?php


namespace app\modules\project\components;

use yii\base\Widget;

/**
 * Виджет просто рисует часики возле задачи
 *
 * Class TimeColorSignWidget
 * @package app\modules\project\components
 */
class TimeColorSignWidget extends Widget
{

    /**
     * @var int время в секундах до заверешения задачи или проекта
     */
    public $seconds;

    public function run(){
        if ($this->seconds === null) {
            return false;
        }

        $seconds = $this->seconds - time();

        if($seconds < 86400){
            $class = 'warning';
            if ($seconds < 0) $class = 'danger';
        } else $class = 'success';

        return $this->render('timeColorSignWidget',            [
            'class' => $class,
        ]);
    }
}