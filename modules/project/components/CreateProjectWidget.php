<?php

namespace app\modules\project\components;


use Yii;
use yii\base\Widget;
use app\modules\main\models\ContactForm;

class CreateProjectWidget extends Widget
{

    public function run()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
        }
        return $this->render('createProjectWidget', [
            'model' => $model,
        ]);
    }

}