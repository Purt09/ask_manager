<?php

namespace app\modules\task\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property string $title
 * @property string $description
 * @property int $project_id
 * @property int $context_id
 * @property int $user_id
 * @property int $status
 */
class Task extends \yii\db\ActiveRecord
{
    const STATUS_CAR = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'title'], 'required'],
            [['created_at', 'updated_at', 'project_id', 'context_id', 'user_id', 'status'], 'integer'],

            [['title', 'description'], 'string', 'max' => 255],

            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => Yii::t('app', 'TASK_CREATE_AT'),
            'updated_at' => Yii::t('app', 'TASK_UPDATE_AT'),
            'title' => Yii::t('app', 'TASK_TITLE'),
            'description' => Yii::t('app', 'TASK_DESCRIPTION'),
            'status' => Yii::t('app', 'TASK_STATUS'),
        ];
    }

    /**
     * get status name
     *
     * @return mixed
     */
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    /**
     * name status
     *
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_CAR => Yii::t('app', 'TASK_STATUS_CAR'),
            self::STATUS_ACTIVE => Yii::t('app', 'TASK_STATUS_ACTIVE'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * getting id tasks
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
}
