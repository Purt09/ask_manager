<?php

use yii\helpers\Html;
use yii\helpers\Json;

?>
<div id="app">
    <div class="row bg-light p-3 shadow-sm mb-3"
         v-for="user in users">
        <div class="col-md-1 text-center">
            <img class="rounded-circle shadow"
                 :src="user.photo"
                 :alt="user.username">
        </div>
        <div class="col-md-6 ml-5 text-center">
            <b>
                <a class="text-dark"
                   href="'/user/profile?id=' + user.id">
                    {{ user.username }}
                </a>
            </b>
            <hr>
            <div class="text-secondary">
                {{ user.firstname }}
                {{ user.lastname }}
            </div>

        </div>
        <div class="col-md-4">
            <a class="btn btn-primary mt-1"
               :href="/user/profile?id=' + user.id"
               v-if="button_link_profile">
                Посотреть профиль
            </a>

        </div>
    </div>
</div>
<?php
Yii::$app->view->registerJs("var users = " . Json::encode($users)
    . ";", \yii\web\View::POS_END);
Yii::$app->view->registerJs("var buttons = " . Json::encode($buttons)
    . ";", \yii\web\View::POS_END);

$js = <<<JS

    new Vue({
    el: '#app',
    data:{
    //Пользователи
    users: users,
    //Кнопки действий с пользователем
    buttons: buttons,
    },
    methods: {
    
    }
    })
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>
