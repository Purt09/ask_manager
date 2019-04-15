<?php

namespace app\modules\task\controllers;

use app\modules\task\models\Task;
use yii\web\Controller;
use Yii;

class UserController extends Controller
{
    public function actionIndex(){

        $modelsactive = Task::find()->where(['status' => 1])->all();
        $modelsbad = Task::find()->where(['status' => 2])->all();


        return $this->render('index', [
            'modelsactive' => $modelsactive,
            'modelspros' => $modelsbad
        ]);
    }

    public function actionOverdue(){
        $models = Task::find()->where(['status' => 0])->all();


        return $this->render('overdue', [
            'models' => $models,
        ]);
    }

}