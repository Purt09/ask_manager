<?php

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "keys_user_friends".
 *
 * @property int $id
 * @property int $user_id_1
 * @property int $user_id_2
 *
 * @property User $userId1
 * @property User $userId2
 */
class UserFriend extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keys_user_friends';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id_1', 'user_id_2'], 'required'],
            [['user_id_1', 'user_id_2'], 'integer'],
            [['user_id_1'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id_1' => 'id']],
            [['user_id_2'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id_2' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id_1' => 'User Id 1',
            'user_id_2' => 'User Id 2',
        ];
    }

    public function createFriend($id){
        $request = new UserRequestFriend();
        $friend = new UserFriend();

        if($friend->checkFriend($id)) return false;

       if($request->deleteRequest($id)) return false;

        $this->user_id_1 = Yii::$app->user->identity->id;
        $this->user_id_2 = $id;
        return $this->save();
    }

    public function checkFriend($id){
        $friend = UserFriend::find()->where(['user_id_1' => Yii::$app->user->identity->id, 'user_id_2' => $id])->orWhere(['user_id_2' => Yii::$app->user->identity->id, 'user_id_1' => $id])->exists();

        if (empty($friend)) return false;
            else    return true;

    }

    public function deleteFriend($id){
        if (isset($id)) {
            $friends = UserFriend::find()->where(['user_id_1' => Yii::$app->user->identity->id, 'user_id_2' => $id])->orWhere(['user_id_2' => Yii::$app->user->identity->id, 'user_id_1' => $id])->all();
            if(empty($friends)) return false;
            foreach ($friends as $friend){
                $friend->delete();
            }
            if(!empty($friends)) return false;
            return true;
        }
        return false;

    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserId1()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserId2()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id_2']);
    }
}
