<?php


namespace app\modules\task\controllers;

use yii\web\Controller;
use Yii;
use app\modules\task\models\Task;
use yii\web\NotFoundHttpException;
use app\modules\project\models\Project;


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

    public function actionCompleteTask($id){
        if(\Yii::$app->request->isAjax){
            $model = $this->findModel($id);

            if($project = $model->getProject()->one()){
                $chat = $project->getChat()->one();
                $chat->addMessage('Участник: "' . Yii::$app->user->identity->username . '" выполнил задачу: "' . $model->title . '"');
            }

            if($model->status != 0)
                $model->setStatus();
            else
                $model->setStatus(1);

            return Yii::$app->request->post('id');
        } else {
            return $this->redirect(['/task/user/index']);
        }
    }

    /**
     *
     * Создает задачу из данных по AjaxController
     *
     * @param $title
     * @param $project_id
     * @param string $description
     * @param string $updated_at
     * @return \yii\web\Response
     */
    public function actionCreateTask($title, $project_id, $description = 'null', $updated_at = 'null'){
        if(\Yii::$app->request->isAjax){
            $task = new Task();
            $task->title = $title;
            $task->project_id = $project_id;
            if ($description != 'null') $task->description = $description;
            if ($updated_at != 'null') $task->updated_at = $updated_at;

            $project = Project::findOne($project_id);


            $chat = $project->getChat()->one();
            $chat->addMessage('Участник: "' . Yii::$app->user->identity->username . '" создал задачу: "' . $title . '"');


            $task->save();
        } else {
            return $this->redirect(['index']);
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