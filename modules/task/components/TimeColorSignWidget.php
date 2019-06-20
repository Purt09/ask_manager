<?php


namespace app\modules\task\components;


use yii\base\Widget;

class TimeColorSignWidget extends Widget
{

    public $seconds;

    public $id;


    public function run(){
        if ($this->seconds === null) {
            return false;
        }

        $seconds = $this->seconds - time();
        $id = $this->id;

        $time = createtime($seconds);

        if($seconds < 86400){
            $class = 'warning';
            if ($seconds < 0) $class = 'danger';
        } else $class = 'success';

        return $this->render('timeColorSignWidget',            [
            'class' => $class,
            'id' => $id,
            'time' => $time,
        ]);
    }
}