<?php

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "keys_user_request_for_friend".
 *
 * @property int $id
 * @property int $sender
 * @property int $taker
 * @property int $accept
 */
class UserRequestFriend extends \yii\db\ActiveRecord
{
    const STATUS_ACCEPT = 1;
    const STATUS_WAIT = 2;
    const STATUS_REJECT = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_request_for_friend}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender', 'taker'], 'required'],
            [['sender', 'taker', 'accept'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender' => 'Sender',
            'taker' => 'Taker',
            'accept' => 'Accept',
        ];
    }

    public function createRequest($id){
        $request = new UserRequestFriend();

        if($request->checkRequest($id)) return false;

        $this->sender = Yii::$app->user->identity->id;
        $this->taker = $id;
        $this->accept = self::STATUS_WAIT;
        return $this->save();
    }

    public function checkRequest($id){
        $request =  UserRequestFriend::find()->where(['sender' => Yii::$app->user->identity->id, 'taker' => $id])->exists();

        if(empty($request)) return false;
            else return true;
    }

    public function getRequests($count = false){
        if($count) return UserRequestFriend::find()->select('sender')->where(['taker' => Yii::$app->user->identity->id])->asArray()->count();
            return UserRequestFriend::find()->select('sender')->where(['taker' => Yii::$app->user->identity->id])->asArray()->all();
    }

    public function deleteRequest($id){
            $request = UserRequestFriend::find()->where(['sender' => Yii::$app->user->identity->id, 'taker' => $id])->orWhere(['taker' => Yii::$app->user->identity->id, 'sender' => $id])->one();
            if(empty($request)) return false;

            $request->delete();

            if(!empty($request)) return false;
            return true;
    }
}
