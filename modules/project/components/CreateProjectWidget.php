<?php

namespace app\modules\project\components;

use Yii;
use yii\base\Widget;
use app\modules\project\models\Project;

class CreateProjectWidget extends Widget
{
    public $projects;

    public $parent_id;

    public function run()
    {
        $this->projects = array_column($this->projects, 'title', 'id');

        $model = new Project();
        $model->parent_id = $this->parent_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->response->redirect(['/project/' . $this->parent_id]);
        }
        return $this->render('createProjectWidget', [
            'model' => $model,
            'projects' => $this->projects
        ]);
    }

}