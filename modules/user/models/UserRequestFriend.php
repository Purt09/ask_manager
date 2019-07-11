<?php

namespace app\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;

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
        return 'keys_user_request_for_friend';
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
        $this->sender = Yii::$app->user->identity->id;
        $this->taker = $id;
        $this->accept = self::STATUS_WAIT;
        $this->save();
    }

    public function checkRequest(){
        $request = UserRequestFriend::find()->where(['taker' => Yii::$app->user->identity->id])->one();
        if(empty($request))
            return null;
        else return UserRequestFriend::find()->where(['taker' => Yii::$app->user->identity->id])->count();
    }

    public function getRequests(){
        return $requests = UserRequestFriend::find()->select('sender')->where(['taker' => Yii::$app->user->identity->id])->asArray()->all();
    }

    public function deleteRequest(){

    }
}
