<?php

namespace app\modules\user\models\chat;

use Yii;

/**
 * This is the model class for table "keys_chat_message_status".
 *
 * @property int $message_id
 * @property int $user_id
 * @property int $is_read
 */
class ChatMessageStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%chat_message_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message_id', 'user_id'], 'required'],
            [['message_id', 'user_id', 'is_read'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'message_id' => 'Message ID',
            'user_id' => 'User ID',
            'is_read' => 'Is Read',
        ];
    }
}
