<?php

namespace app\modules\project\controllers;

use app\modules\project\models\Project;
use app\modules\task\models\Task;
use app\modules\user\models\User;
use yii\web\NotFoundHttpException;
use Yii;
use app\modules\user\models\UserFriend;

class DefaultController extends \yii\web\Controller
{
    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();

        $model->creator_id = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new Project();
        $projects = $model->getProjectByParent_id(null);


        return $this->render('index', [
            'projects' => $projects

        ]);
    }
    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $task = new Task();

        $tasks = $task->getTasks();
        $subprojects = $model->getProjectByParent_id($id);
        $users = Project::find()->where(['id' => $id])->one()->getUsers()->with(['projects'])->all();


        return $this->render('view', [
            'model' => $model,
            'tasks' => $tasks,
            'subprojects' => $subprojects,
            'users' => $users
        ]);
    }

    /**
     * @param bool $id
     */
    public function actionDelete($id)
    {
        if (isset($id)) {
            if (Project::deleteAll(['in', 'id', $id])) {
                Task::deleteAll(['in', 'project_id', $id]);
                $this->redirect(['index']);
            }
        } else {
            $this->redirect(['index']);
        }
    }


    /**
     * @param bool $id
     */
    public function actionFriends($project_id){
        $friend = new UserFriend();
        $user = new User();
        $id = Yii::$app->user->identity->id;

        $friends = $friend->getUserFriends($id);
        $users = $user->getFriends($friends, $id);

        return $this->render('friend', [
            'project_id' => $project_id,
            'users' => $users
        ]);
    }

    /**
     * @param bool $id
     */
    public function actionAddFriend($id, $user_id)
    {
        $user = User::findOne($user_id);
        $project = Project::findOne($id);

        $projects = $project->getSubprojectsByProject($project);
        // Связываем нового пользователя и проекты
        foreach ($projects as $p)
            $p->link('users', $user);

        $tasks = Task::getTasksFromProjects($projects);
        // Связываем нового пользователя и задачи
        foreach ($tasks as $t)
            $t->link('users', $user);

        return $this->redirect('/project/' . $project->id);
    }

    /**
     * @param bool $id
     */
    public function actionDelFriend($id, $user_id)
    {
        $user = User::findOne($user_id);
        $project = Project::findOne($id);

        $projects = $project->getSubprojectsByProject($project);
//        foreach ($projects as $p)
//            $p->link('users', $user);

        $tasks = Task::getTasksFromProjects($projects);
//        foreach ($tasks as $t)
//            $t->link('users', $user);

        return $this->redirect('/project/' . $project->id);
    }

    /**
     * @param bool $id
     */
    public function actionNewLeader($id, $redirect = 'view',  $user_id)
    {
        $project = Project::findOne($id);
        $projects = $project->getSubprojectsByProject($project);
        foreach ($projects as $p) {
            Project::setLeader($user_id, $p);
        }
        return $this->redirect([$redirect]);
    }
    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
