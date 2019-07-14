<?php

namespace app\modules\user\forms;

use yii\base\Model;
use yii\db\ActiveQuery;
use Yii;
use app\modules\user\models\User;


class ProfileUpdateForm extends Model
{
    public $email;
    public $first_name;
    public $last_name;
    public $phone;

    /**
     * @var User
     */
    private $_user;

    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->last_name = $user->last_name;
        $this->first_name = $user->first_name;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => User::className(),
                'messages' => Yii::t('app', 'ERROR_EMAIL_EXISTS'),
                'filter' => ['<>', 'id', $this->_user->id],
            ],
            ['email', 'string', 'max' => 255],
        ];
    }

    public function update()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->email = $this->email;
            $user->first_name = $this->first_name;
            $user->phone = $this->phone;
            $user->last_name = $this->last_name;
            return $user->save();
        } else {
            return false;
        }
    }
}