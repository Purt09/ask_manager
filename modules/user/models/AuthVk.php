<?php

namespace app\modules\user\models;


class AuthVk
{

    const AUTH_VK_ID = '7033941';
    const AUTH_VK_URL_ACCESS_TOKEN = 'https://oauth.vk.com/access_token';
    const AUTH_VK_URL_AUTH = 'https://oauth.vk.com/authorize';
    const AUTH_VK_REDIRECT_URI = 'http://task.md-help.ru/user/auth/authvk';

    private $code;
    private $token;
    private $uid;

    public function setCode($code){
        $this->code = $code;
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

        var_dump($result); // Должны прийти в формате json
    }
}