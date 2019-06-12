<?php

namespace app\modules\project\components;

use Yii;
use yii\base\Widget;
use app\modules\project\models\Project;

class CreateProjectWidjet extends Widget
{

    public function run()
    {
        $model = new Project();
        //$model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->response->refresh();
        }
        return $this->render('createProjectWidjet', [
            'model' => $model,
        ]);
    }

}