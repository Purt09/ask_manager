<?php

namespace app\modules\user\models\chat;

use Yii;

/**
 * This is the model class for table "keys_chat_users".
 *
 * @property int $chat_id
 * @property int $user_id
 */
class ChatUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keys_chat_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id', 'user_id'], 'required'],
            [['chat_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'chat_id' => 'Chat ID',
            'user_id' => 'User ID',
        ];
    }
}
