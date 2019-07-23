<?php

namespace app\modules\project\components;

use app\modules\admin\models\User;
use Yii;
use yii\base\Widget;
use app\modules\project\models\Project;

class CreateProjectWidget extends Widget
{
    /**
     * @var array Project Все проекты, для их дальнейшего вывода в форме заполнения
     */
    public $projects;

    /**
     * @var int родитель для удобства быстрого создания проета
     */
    public $parent_id;

    public function run(){
        // Приводит в нормальный(нужный) вид пришедшие проеты
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