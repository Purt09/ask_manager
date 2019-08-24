<?php

namespace app\modules\user\components;

use app\modules\user\models\chat\ChatMessage;
use app\modules\user\models\User;
use yii\base\Widget;
use app\modules\user\models\chat\Chat;
use app\components\TimeSupport;


class ChatWidget  extends Widget
{

    public $chat_id;

    public $users;

    public $mes_limit = 12;

    public function run()
    {
        $chat = Chat::findOne($this->chat_id);

        $messages = $chat->getMessages()->limit($this->mes_limit)->indexBy('id')->orderBy('id desc')->all();


        $user_auth = User::findOne(\Yii::$app->user->id);


        foreach ($messages as $message)
                $message['created_at'] = TimeSupport::getTimeleft($message['created_at']);


        return $this->render('chatWidget', [
            'messages' => $messages,
            'chat' => $chat,
            'users' => $this->users,
            'user_auth' => $user_auth
        ]);
    }



}