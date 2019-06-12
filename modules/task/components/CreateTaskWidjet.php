<?php

namespace app\modules\task\components;

use Yii;
use yii\base\Widget;
use app\modules\task\models\Task;

class CreateTaskWidjet extends Widget
{

    public function run()
    {
        $model = new Task();
        //$model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->response->refresh();
        }
        return $this->render('createTaskWidjet', [
            'model' => $model,
        ]);
    }

}