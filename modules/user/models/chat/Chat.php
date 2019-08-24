<?php

namespace app\modules\user\models\chat;

use app\modules\project\models\Project;
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
        return '{{%chat_chat}}';
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

    public function addMessage($message, $user_id = 0){
        $mess = new ChatMessage();
        $mess->addMessage($this, $message, $user_id);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(ChatMessage::className(), ['chat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasMany(Project::className(), ['chat_id' => 'id']);
    }
}
