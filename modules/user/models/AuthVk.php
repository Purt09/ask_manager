<?php

namespace app\modules\user\models;

use Yii;
use yii\helpers\Url;

class AuthVk
{

    const AUTH_VK_ID = '7033941';
    const AUTH_VK_URL_ACCESS_TOKEN = 'https://oauth.vk.com/access_token';
    const AUTH_VK_URL_AUTH = 'https://oauth.vk.com/authorize';
    const AUTH_VK_REDIRECT_URI = 'http://task.md-help.ru/user/auth/authvk';
    const URL_GET_USER = 'https://api.vk.com/method/users.get';


    private $code;
    private $token;
    private $email;
    private $uid;

    /**
     * @param $code Код который возвращает вк
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     *
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param $token - токен пользователя
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @param $uid это также принадлежит определенному пользователю
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @param $url Вроде велосипед
     */
    public function redirect($url)
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location:" . $url);
        exit();
    }

    /**Получаем токен, может быть возвано, только тогда, когда уже получили код
     * @return bool
     */
    public function getToken()
    {
        if (!$this->code) {
            exit("Error, not right code");
        }

        //  Используя библиотеку curl отправляет данные на стороний сайт
        $ku = curl_init();
        $query = "client_id=" . self::AUTH_VK_ID . "&client_secret=" . \Yii::$app->params['AUTH_VK_SECRET_KEY'] . "&code=" . $this->code . "&redirect_uri=" . self::AUTH_VK_REDIRECT_URI;

        curl_setopt($ku, CURLOPT_URL, self::AUTH_VK_URL_ACCESS_TOKEN . "?" . $query);
        curl_setopt($ku, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ku);


        curl_close($ku);

        $ob = json_decode($result);
        if ($ob->access_token) {
            $this->setToken($ob->access_token);
            $this->setUid($ob->user_id);
            $this->setEmail($ob->email);
            return true;
        } elseif ($ob->error) {
            //TODO: Добавить в лог
            $_SESSION['error'] = "Error vk auth";
            return FALSE;
        }
    }


    /**
     * Имея токен и его uid мы можем получить остальные данные
     * Сохраняем или авторизируем пользователя
     * Перенаправляем на страницу
     */
    public function getUser()
    {
        if (!$this->token) {
            exit('Wrong code');
        }

        if (!$this->uid) {
            exit('Wrong code');
        }

        $query = "user_ids=" . $this->uid . "&fields=first_name,last_name,nickname,photo,photo_medium,photo_big,email&access_token=" . $this->token . "&v=5.95";
//echo $query;

        $kur = curl_init();

        curl_setopt($kur, CURLOPT_URL, self::URL_GET_USER . "?" . $query);

        curl_setopt($kur, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($kur, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($kur, CURLOPT_RETURNTRANSFER, TRUE);

        $result2 = curl_exec($kur);

        curl_close($kur);

        $result = json_decode($result2)->response[0];
        $user = User::findByEmail($this->email);

        if ($user === null) {
            $user = new User();
            $user->email = $this->email;
            $user->generateAuthKey();
            $user->username = explode('@', $this->email)[0];
            $user->status = User::STATUS_ACTIVE;
            $user->photo = $result->photo;
            $user->photo_big = $result->photo_big;
            $user->photo_medium = $result->photo_medium;
            $user->first_name = $result->first_name;
            $user->last_name = $result->last_name;
            if ($user->save() && Yii::$app->user->login($user, 60 * 60 * 24 * 365)) {
                Yii::$app->session->setFlash('success', "Авторизация прошла успещно");
            }
        } else {
            if (Yii::$app->user->login($user, 60 * 60 * 24 * 365))
                Yii::$app->session->setFlash('success', "Авторизация прошла успещно");
        }

        $this->redirect(Url::to('/task/user/index'));
    }

}
