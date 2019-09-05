<?php


namespace app\modules\task\controllers;

use yii\web\Controller;
use Yii;
use app\modules\task\models\Task;
use yii\web\NotFoundHttpException;


class AjaxController extends Controller
{
    public function actionSaveTaskTitle($title, $id){
        if(\Yii::$app->request->isAjax){
            $task = $this->findModel($id);
            $task->title = $title;
            $task->save();

            return Yii::$app->request->post('id');
        } else {
            return $this->redirect(['/task/user/index']);
        }
    }

    public function actionSaveTaskTime($time, $id){
        if(\Yii::$app->request->isAjax){
            $task = $this->findModel($id);
            $task->updated_at = Time() + $time;
            $task->save();

            return Yii::$app->request->post('id');
        } else {
            return $this->redirect(['/task/user/index']);
        }
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
}