<?php

namespace app\modules\user\controllers;

use yii\web\Controller;
use app\modules\user\models\chat\ChatMessage;
use app\modules\user\models\chat\Chat;
use Yii;

class ChatAjaxController extends Controller
{
    public function actionDeleteMessage($id){
        if(\Yii::$app->request->isAjax){
            $message = new ChatMessage();
            $message->deleteMessage($id);

            return Yii::$app->request->post('id');
        } else {
            return $this->redirect(['/']);
        }
    }

    public function actionAddMessage($content, $chat_id, $user_id){
        if(\Yii::$app->request->isAjax) {
            $chat = Chat::findOne($chat_id);
            $chat->addMessage($content, $user_id);
        }
        else {
            return false;
        }
    }
}