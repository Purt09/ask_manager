<?php

namespace app\modules\task\controllers;

use app\modules\project\models\Project;
use app\modules\task\models\Task;
use app\modules\user\models\chat\Chat;
use app\modules\user\models\User;
use phpDocumentor\Reflection\Types\Integer;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use app\modules\task\forms\CreateForm;

class UserController extends Controller
{
    /**
     * Главная страница выводит все задачи определенного пользователя
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex(){
        $task = new Task();
        $user = User::findOne(Yii::$app->user->identity->id);

        $projects = $user->getProjects()->indexBy('id')->all();
        $tasks = $task->getTasksFromProjects($projects, $user);

        return $this->render('index', [
            'project' => $user->getProjects()->one(),
            'tasks' => $tasks,
            'projects' => $projects,
            'users' => array('0' => $user),
        ]);
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
     * Страница выводи все выполненные задачи пользователем
     *
     * @return string
     */
    public function actionDone(){
        $user = User::findOne(Yii::$app->user->identity->id);

        $models = $user->getTasks()->all();

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
    public function actionComplete($idF){
        $model = $this->findModel($id);

        if($model->status != 0)
            $model->setStatus();
        else
            $model->setStatus(1);

        return $this->redirect(['/project/default']);
    }



    /**
     * Создает личную задачу для определенного пользователя
     *
     * @param $user_id
     * @param $task_id
     * @return array|mixed|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAddPersonalTaskAjax($user_id, $task_id){ // TODO AJAX
        if($user_id == 'null') $user_id = null;
        if(\Yii::$app->request->isAjax){
            $task = $this->findModel($task_id);
            $task->user_id = $user_id;
            $task->save();

            $project = $task->getProject()->one();
            $chat = $project->getChat()->one();
            if($user_id != null) {
                $user = User::findOne($user_id);
                $chat->addMessage('Задача: "' . $task->title . '" была поручена пользователю: "' . $user->username . '"');
            }
            else $chat->addMessage('Задача: "' . $task->title . '" была откреплена');







            return Yii::$app->request->post('id');
        } else {
            return $this->redirect(['index']);
        }
    }

    public function actionSetExecutor($user_id, $task_id, $project_id){ //TODO AJAX
        if(\Yii::$app->request->isAjax){
            $task = $this->findModel($task_id);
            $task->user_id = $user_id;
            $task->save();
            return Yii::$app->request->post('id');
        } else {
            return $this->redirect('/project/' . $project_id);
        }

    }

    public function actionDelExecutor($task_id, $project_id){ //TODO AJAX
        $task = $this->findModel($task_id);
        $task->user_id = null;
        $task->save();
        return $this->redirect('/project/' . $project_id);
    }


}
