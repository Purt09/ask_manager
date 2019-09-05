<?php

namespace app\modules\user\models\chat;

use Yii;

/**
 * This is the model class for table "keys_chat_message".
 *
 * @property int $id
 * @property int $chat_id
 * @property int $user_id
 * @property string $content
 * @property int $created_at
 */
class ChatMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%chat_message}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id', 'user_id', 'content', 'created_at'], 'required'],
            [['chat_id', 'user_id', 'created_at'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_id' => 'Chat ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChat()
    {
        return $this->hasOne(Chat::className(), ['id' => 'chat_id']);
    }

    public function addMessage(Chat $chat, $message, $user_id = 0){
        $mess = new ChatMessage();
        $mess->content = $message;
        $mess->chat_id = $chat->id;
        $mess->user_id = $user_id;
        $mess->created_at = time();
        $mess->save();
    }
    public function deleteMessage($id){
        $message = self::findOne($id);
        $message->delete();
    }
}
