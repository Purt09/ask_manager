<?php

namespace app\modules\task\models;

use app\modules\task\Module;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

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
    const STATUS_TIME_OUT = 2;

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
            'created_at' => Module::t('module', 'TASK_CREATE_AT'),
            'updated_at' => Module::t('module', 'TASK_UPDATE_AT'),
            'title' => Module::t('module', 'TASK_TITLE'),
            'description' => Module::t('module', 'TASK_DESCRIPTION'),
            'status' => Module::t('module', 'TASK_STATUS'),
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
            self::STATUS_CAR => Module::t('module', 'TASK_STATUS_CAR'),
            self::STATUS_ACTIVE => Module::t('module', 'TASK_STATUS_ACTIVE'),
            self::STATUS_TIME_OUT => Module::t('module', 'TASK_STATUS_TIME_OUT'),
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
