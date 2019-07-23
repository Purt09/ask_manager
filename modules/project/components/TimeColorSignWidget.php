<?php


namespace app\modules\project\components;

use yii\base\Widget;

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