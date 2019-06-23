<?php

namespace app\modules\user\models\connections;

use Yii;
use app\modules\task\models\Task;
use app\modules\user\models\User;

/**
 * This is the model class for table "{{%user_task}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $task_id
 *
 * @property Task $task
 * @property User $user
 */
class UserTask extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_task}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id'], 'required'],
            [['user_id', 'task_id'], 'integer'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return UserTaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserTaskQuery(get_called_class());
    }
}
