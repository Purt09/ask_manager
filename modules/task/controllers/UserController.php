<?php

namespace app\modules\task\controllers;

use app\modules\task\models\Task;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

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

    public function actionDone(){
        $models = Task::find()->where(['status' => 0])->all();


        return $this->render('done', [
            'models' => $models,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        $model->updated_at=1755016400;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param bool $id
     */
    public function actionDelete($id = false)
    {
        if (isset($id)) {
            if (Task::deleteAll(['in', 'id', $id])) {
                $this->redirect(['index']);
            }
        } else {
            $this->redirect(['index']);
        }
    }

    /**
     * Change status model on complete (Task->complete)
     *
     * @param bool $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionComplete($id = false){


        $model = $this->findModel($id);

        $model->setStatusComplete($id);

        return $this->redirect(['index']);
    }

    public function actionUncomplete($id = false){


        $model = $this->findModel($id);

        $model->setStatusActive($id);

        return $this->redirect(['index']);
    }


}