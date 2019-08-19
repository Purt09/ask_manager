<?php

namespace app\modules\user\models\chat;

use Yii;

/**
 * This is the model class for table "keys_chat_chat".
 *
 * @property int $id
 * @property int $created_at
 * @property string $name
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keys_chat_chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'name'], 'required'],
            [['created_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'name' => 'Name',
        ];
    }
}
