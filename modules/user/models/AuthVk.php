<?php

namespace app\modules\user\models;

use app\modules\user\models\User;

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

    public function setCode($code){
        $this->code = $code;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setToken($token){
        $this->token = $token;
    }

    public function setUid($uid){
        $this->uid = $uid;
    }

    public function redirect($url) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location:".$url);
        exit();
    }

    public function getToken(){
        if(!$this->code) {
            exit("Error, not right code");
        }

        //  Используя библиотеку curl отправляет данные на стороний сайт
        $ku = curl_init();
        $query = "client_id=".self::AUTH_VK_ID."&client_secret=".\Yii::$app->params['AUTH_VK_SECRET_KEY']."&code=".$this->code."&redirect_uri=".self::AUTH_VK_REDIRECT_URI;

        curl_setopt($ku, CURLOPT_URL, self::AUTH_VK_URL_ACCESS_TOKEN."?".$query);
        curl_setopt($ku, CURLOPT_RETURNTRANSFER,TRUE);
        $result = curl_exec($ku);


        curl_close($ku);

        $ob = json_decode($result);
        if($ob->access_token) {
            $this->setToken($ob->access_token);
            $this->setUid($ob->user_id);
            $this->setEmail($ob->email);
            return true;
        }
        elseif ($ob->error)
        {
            //TODO: Добавить в лог
            $_SESSION['error'] = "Error vk auth";
            return FALSE;
        }
    }

    public function getUser(){
        if(!$this->token) {
            exit('Wrong code');
        }
        if(!$this->uid) {
            exit('Wrong code');
        }

        $query = "uids=".$this->uid."&fields=first_name,last_name,nickname,screen_name,sex,bdate,city, country,timezone,photo,photo_medium,photo_big,has_mobile,rate,contacts, education,online,counters&access_token=".$this->token;
//echo $query;

        $kur = curl_init();

        curl_setopt($kur, CURLOPT_URL, self::URL_GET_USER."?".$query);

        curl_setopt($kur, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($kur, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($kur,CURLOPT_RETURNTRANSFER,TRUE);



        $result2 = curl_exec($kur);

        curl_close($kur);

        $result = json_decode($result2);
        $result = $result->response[0];

        $user = User::findByEmail($result->email);

//        if($user) {
//            $user = new User();
//            $user->email = $result->email;
//            $user->username = $result->uid;
//            $user->photo = $result->photo;
//            $user->photo_big = $result->photo_big;
//            $user->photo_medium = $result->photo_medium;
//            $user->first_name = $result->first_name;
//            $user->last_name = $result->last_name;
//            $user->save();
//        } else {
//            $user = User::findByEmail($result->email);
//            $user->login();
//        }

        $this->redirect("http://task.md-help.ru");
        //TODO: Сделать нормальные пути
    }
}