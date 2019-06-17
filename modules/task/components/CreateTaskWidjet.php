<?php

namespace app\modules\task\components;

use Yii;
use yii\base\Widget;
use app\modules\task\models\Task;
use app\modules\task\forms\CreateForm;

class CreateTaskWidjet extends Widget
{

    /**
     * @var integer определяет к какому проекту относится задача
     */
    public $project_id;


    public function run()
    {
        $model = new CreateForm();
        //$model = new ContactForm();
        $model->project_id = $this->project_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->response->refresh();
        }
        return $this->render('createTaskWidjet',            [
            'model' => $model,
            'project_id' => $this->project_id,
             ]);
    }


}