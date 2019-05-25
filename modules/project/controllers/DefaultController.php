<?php

namespace app\modules\project\controllers;

use app\modules\project\models\Project;
use app\modules\task\models\Task;
use yii\web\NotFoundHttpException;
use Yii;

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
        $projects = $model->getProjectByParent_id();
        $tasks = $model->getTasksByProjects($projects);


        return $this->render('index', [
            'projects' => $projects,
            'tasks' => $tasks

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
        $taskscomplete = $model->getTasksByProject($model, 0);
        $tasksactive = $model->getTasksByProject($model);
        $tasksoverdue = $model->getTasksByProject($model, 2);


        return $this->render('view', [
            'model' => $model,
            'tasksactive' => $tasksactive,
            'tasksoverdue' => $tasksoverdue,
            'taskscomplete' => $taskscomplete

        ]);
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
