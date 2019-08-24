<?php

namespace app\modules\user\controllers;

use app\modules\user\models\chat\Chat;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class ChatController extends Controller
{
    public function actionAddMessageAjax($content, $chat_id, $user_id){
        if(\Yii::$app->request->isAjax) {
            $chat = Chat::findOne($chat_id);
            $chat->addMessage($content, $user_id);
            }
        else {
            return false;
        }
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chat::findOne($id)) !== null)
            return $model;
        else
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}