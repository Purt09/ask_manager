<?php

namespace app\modules\project\components;

use Yii;
use yii\base\Widget;
use app\modules\project\models\Project;

class CreateProjectWidget extends Widget
{

    public $parent_id;

    public function run()
    {
        $model = new Project();
        $model->parent_id = $this->parent_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->response->refresh();
        }
        return $this->render('createProjectWidget', [
            'model' => $model,
        ]);
    }

}