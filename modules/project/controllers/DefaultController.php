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
     * Страница выводи все проекты пользователя
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Project();
        $user = User::findOne(Yii::$app->user->identity->id);

        $projects = $model->getSubprojectsByProject($model);
        $tasks = $user->getTasks()->indexBy('id')->all();


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

        // Можно смотреть только родительский проект!
        if($project->parent_id != NULL){
            $this->redirect(['/project/' . $project->parent_id]);
        }
        $user = User::findOne(Yii::$app->user->identity->id);

        $projects = $project->getSubprojectsByProject($project);
        $projects += array(
            $project['id'] => $project,
        );

        $users = $project->getUsers()->all();
        $tasks = Task::getTasksFromProjects($projects, $user);


        return $this->render('view', [
            'model' => $project,
            'tasks' => $tasks,
            'projects' => $projects,
            'users' => $users,
        ]);
    }

    /**
     * Страница для редактирования проекта
     *
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            return $this->redirect(['/project/' . $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Выводит все выполненные задачи.
     *
     * @param $id
     * @return string
     */
    public function actionComplete($id)
    {
        $task = new Task();
        $project = $this->findModel($id);
        $user = User::findOne(Yii::$app->user->identity->id);

        $projects = $project->getSubprojectsByProject($project);
        $projects += array(
            $project['id'] => $project,
        );

        $tasks = $task->getTasksFromProjects($projects, $user);

        return $this->render('complete', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Удаляет проект, а также все его подпроекты.
     *
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
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

        if ($model->delete())
            Yii::$app->getSession()->setFlash('success', 'Проект успешно закрыт');
        else
            Yii::$app->getSession()->setFlash('error', 'Ошибка что-то пошло не так!');

        return $this->redirect('/project/default/index');
    }


    /**
     * Выводит всех друзей, которых пользователь может добавить в проект
     *
     * @param $project_id
     * @return string
     */
    public function actionFriends($project_id) //TODO модальным окном сделать
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
     * Добавляет пользователя в проект
     *
     * @param $id
     * @param $user_id
     * @return \yii\web\Response
     */
    public function actionAddFriend($id, $user_id) // TODO AJAX
    {
        $user = User::findOne($user_id);
        $project = Project::findOne($id);

        $project->setUserInProjects($user, $project);

        return $this->redirect('/project/' . $project->id);
    }



    /**
     * Добавляет нового лидера в проект и во всех СабПроектах меняет лидера
     *
     * @param $id
     * @param string $redirect
     * @param $user_id
     * @return \yii\web\Response
     */
    public function actionNewLeader($id, $redirect = 'view', $user_id)  // TODO AJAX
    {
        $model = $this->findModel($id);
        $user = User::findOne($user_id);

        $model->setLeader($user, $model);

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
