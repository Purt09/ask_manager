<?php

namespace app\modules\project\controllers;


use app\modules\project\models\Project;
use app\modules\task\components\TasksListWidget;
use app\modules\task\models\Task;
use app\modules\user\models\User;
use yii\web\NotFoundHttpException;
use Yii;
use app\modules\user\models\UserFriend;
use app\modules\user\models\connections\ProjectUser;
use app\modules\user\models\connections\TaskUser;

class DefaultController extends \yii\web\Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();

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
        $task = new Task();
        $user = User::findOne(Yii::$app->user->identity->id);

        $projects = $model->getProjectsByParent($model, $user);
        $tasks = $task->getTasks($user);


        return $this->render('index', [
            'projects' => $projects,
            'tasks' => $tasks,

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
        $project = $this->findModel($id);
        $user = User::findOne(Yii::$app->user->identity->id);

        $projects = $project->getProjectsByParent($project, $user);

        $users = $project->getUsersFromProject($project);
        $tasks = Task::getTasksFromProjects($projects, $user);


        return $this->render('view', [
            'model' => $project,
            'tasks' => $tasks,
            'projects' => $projects,
            'users' => $users,
            'subtasks' => $tasks,
        ]);
    }

    /**
     * @param bool $id
     */
    public function actionDelete($id)
    {
        $model = Project::findOne($id);
        $subprojects = $model->getSubprojectsByProject($model);
        if (!empty($subprojects)) {
            foreach ($subprojects as $s) {
                Task::deleteAll(['project_id' => $s->id]);
                $s->delete();
            }
        }
        $model->delete();
        Yii::$app->getSession()->setFlash('success', 'Проект успешно удален');

        $this->redirect('/project/default/index');
    }


    /**
     * @param bool $id
     */
    public function actionFriends($project_id)
    {
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
     * @param $id
     * @param $user_id
     * @return \yii\web\Respons
     */
    public function actionAddFriend($id, $user_id)
    {
        $user = User::findOne($user_id);
        $creator = User::findOne(Yii::$app->user->identity->id);
        $project = Project::findOne($id);

        $projects = $project->getSubprojectsByProject($project);
        array_push($projects, $project);
        // Связываем нового пользователя и проекты
        foreach ($projects as $p)
            $p->link('users', $user);

        $tasks = Task::getTasksFromProjects($projects, $creator);
        // Связываем нового пользователя и задачи
        foreach ($tasks as $t)
            $t->link('users', $user);

        return $this->redirect('/project/' . $project->id);
    }

    /**
     * @param bool $id
     */
    public
    function actionDelFriend($id, $user_id)
    {
        $user = User::findOne($user_id);
        $project = Project::findOne($id);

        $projects = $project->getSubprojectsByProject($project);
        foreach ($projects as $p)
            ProjectUser::deleteAll(['project_id' => $p->id, 'user_id' => $user_id]);


        $tasks = Task::getTasksFromProjects($projects);
        foreach ($tasks as $t)
            TaskUser::deleteAll(['task_id' => $t->id, 'user_id' => $user_id]);

        return $this->redirect('/project/' . $project->id);
    }

    /**
     * @param bool $id
     */
    public
    function actionNewLeader($id, $redirect = 'view', $user_id)
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
    protected
    function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public
    function actionComplete($id)
    {
        $task = new Task();
        $user = User::findOne(Yii::$app->user->identity->id);

        $tasks = $task->getTasks($user);

        return $this->render('complete', [
            'tasks' => $tasks,
        ]);
    }

    public function actionTest()
    {
        $id = ['0' => 3,
            '1' => 14];
    }

}
