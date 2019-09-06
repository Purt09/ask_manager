<?php

namespace app\modules\project\components;

use app\modules\user\models\chat\Chat;
use Yii;
use yii\base\Widget;
use app\modules\project\models\Project;

/**
 * Всплывающее окно для создания проекта
 *
 * Class CreateProjectWidget
 * @package app\modules\project\components
 */
class CreateProjectWidget extends Widget
{
    /**
     * @var array Project Все проекты, для их дальнейшего вывода в форме заполнения
     */
    public $projects = [];

    /**
     * @var Project родитель для удобства быстрого создания проекта
     */
    public $parent;

    /**
     * @var string текст кнопки.
     */
    public $title = 'Созддать проект';

    public function run(){
        // Приводит в нормальный(нужный) вид пришедшие проеты
        if (!empty($this->projects))
            $this->projects = array_column($this->projects, 'title', 'id');
        else $this->projects = array_column(['0' => $this->parent], 'title', 'id');

        $model = new Project();
        if(!empty($this->parent))
            $model->parent_id = $this->parent->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $chat = Chat::findOne($model->chat_id);
            $chat->addMessage('Был создан подпроект: "' . $model->title . '"');

            Yii::$app->response->redirect(['/project/' . $model->parent_id]);
        }
            return $this->render('createProjectWidget', [
                'model' => $model,
                'projects' => $this->projects,
                'title' => $this->title,
            ]);

    }

}