<?php

namespace app\modules\task\forms;

use app\modules\task\models\Task;
use app\modules\task\Module;

class CreateForm extends \yii\base\Model
{

    public $title;
    public $description;
    public $updated_at;
    public $project_id;

    public function rules()
    {
        return [

            ['title', 'required'],
            ['title', 'string', 'min' => 3, 'max' => 60, 'message' => 'Слишком короткое'],

            [['created_at', 'project_id', 'context_id', 'user_id', 'status', 'updated_at'], 'integer'],


            ['description', 'string', 'max' => 255],

            ['status', 'default', 'value' => Task::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(Task::getStatusesArray())],

            ['updated_at', 'integer', 'min' => time() - 86400, 'tooSmall' => Module::t('module', 'TASK_VALID_TIME_SMALL') ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => Module::t('module', 'TASK_CREATE_AT'),
            'updated_at' => Module::t('module', 'TASK_UPDATE_AT'),
            'title' => Module::t('module', 'TASK_TITLE'),
            'description' => Module::t('module', 'TASK_DESCRIPTION'),
            'status' => Module::t('module', 'TASK_STATUS'),
            'project_id' => Module::t('module', 'PROJECT'),
        ];
    }

    public function save(){
        $task = new Task();

        $task->title = $this->title;
        $task->description = $this->description;
        $task->updated_at = $this->updated_at;
        $task->project_id = $this->project_id;

        return $task->save();
    }

}