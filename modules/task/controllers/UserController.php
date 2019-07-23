<?php

namespace app\modules\task\controllers;

use app\modules\project\models\Project;
use app\modules\task\models\Task;
use app\modules\user\models\User;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use app\modules\task\forms\CreateForm;

class UserController extends Controller
{
    public function actionIndex(){
        $model = new Task();
        $user = User::findOne(Yii::$app->user->identity->id);

        $models = $model->getTasks($user);
        $projects = Project::find()->all();

        return $this->render('index', [
            'models' => $models,
            'projects' => $projects,
        ]);
    }

    /**
     * Страница выводи все выполненные хадачи пользователем
     *
     * @return string
     */
    public function actionDone(){
        $model = new Task();
        $user = User::findOne(Yii::$app->user->identity->id);

        $models = $model->getTasks($user);

        return $this->render('done', [
            'models' => $models,
        ]);
    }

    /**
     * Страница для редактирования задачи
     *
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
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
            if(($model->updated_at < time()) && ($model->status != 0) && ($model->updated_at != null)) $model->setStatus(Task::STATUS_TIME_OUT); // Проверка на просрочеенность задачи
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($project_id = null)
    {
        $model = new CreateForm();

        $model->project_id = $project_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Удаляет задачу
     *
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

        if(\Yii::$app->request->isAjax){

            $model = $this->findModel($id);

            $model->setStatus();
            return Yii::$app->request->post('id');
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Change status model on uncomplete (Task->uncomplete)
     *
     * @param bool $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUncomplete($id = false){


        if(\Yii::$app->request->isAjax){

            $model = $this->findModel($id);

            $model->setStatus(1);
            return Yii::$app->request->post('id');
        } else {
            return $this->redirect(['index']);
        }


    }


}
