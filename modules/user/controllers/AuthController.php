<?php
/**
 * Created by PhpStorm.
 * User: Purtv
 * Date: 26.06.2019
 * Time: 3:05
 */

namespace app\modules\user\controllers;

use yii\web\Controller;
use app\modules\user\models\AuthVk;
use Yii;
use app\modules\user\Module;

/**
 *
 * Авторизация через соц сети
 *
 * Class AuthController
 * @package app\modules\user\controllers
 */
class AuthController extends Controller
{

    /**
     * Страница через которую происходит перенаправление и авторизация
     * @return string
     */
    public function actionAuthvk(){
        $model = new AuthVk();


        if(!Yii::$app->request->get('code')) {

            $query = "client_id=".AuthVk::AUTH_VK_ID."&scope=offline,email,friends&redirect_uri=".AuthVk::AUTH_VK_REDIRECT_URI."&response+type=code";

            $model->redirect(AuthVk::AUTH_VK_URL_AUTH."?".$query);
        }
        else {
            $model->setCode(Yii::$app->request->get('code'));
            $res = $model->getToken();
            if($res) {
                $model->getUser();
            }
            else {
                exit($_SESSION['error']);
            }

        }

        if(Yii::$app->request->get('error')){
            Yii::$app->user->setFlash('error', Module::t('module', 'ERROR_AUTH_VK'));
            // TODO: Добавить в лог ошибку
        }

        return $this->render('authvk', [
            'model' => $model
        ]);
    }
}