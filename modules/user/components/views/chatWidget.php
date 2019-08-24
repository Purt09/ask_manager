<?php

use yii\helpers\Json;

?>
    <div class="panel panel-primary" id="chat">
        <div class="panel-heading chat">
            <h3 class="panel-title">Чат:</h3>
        </div>
        <div class="panel-body">
            <!--       Сообщения загруженные     -->
            <div class="pt-2"
                 v-for="message in messages">
                <div v-for="user in users"
                     v-if="user.id == message.user_id">
                    <span class="chat-img pull-left mr-2">
                        <img v-bind:src="user.photo" alt="User Avatar" class="img-circle"/>
                    </span>
                    <div class="clearfix">
                        <div class="header">
                            <strong class="primary-font text-secondary">
                                {{user.username}}
                            </strong>
                            <small class="pull-right text-muted">
                                <span class="glyphicon glyphicon-time"></span> {{message.created_at}}
                            </small>
                        </div>
                        <p>
                            {{message.content}}
                        </p>
                    </div>
                </div>
                <div class="text-center text-secondary"
                     v-if="message.user_id == 0">
                    {{message.content}}
                </div>
            </div>
            <!----Конец сообщений>-->
            <!--Добавленные сообщения-->
            <div v-for="add_message in add_messages">
                 <span class="chat-img pull-left mr-2">
                        <img v-bind:src="userAuth.photo" alt="User Avatar" class="img-circle"/>
                    </span>
                <div class="clearfix">
                    <div class="header">
                        <strong class="primary-font text-secondary">
                            {{userAuth.username}}
                        </strong>
                        <small class="pull-right text-muted">
                            <span class="glyphicon glyphicon-time"></span>только что
                        </small>
                    </div>
                    <p>
                        {{add_message.content}}
                    </p>
                </div>
            </div>
            <!--    Конец добавленных сообщений        -->

        </div>
        <div class="panel-footer">
            <div class="input-group">
                <input id="btn-input" type="text" class="form-control input-sm"
                       placeholder="Введите ссобщение"
                       v-model="content"/>
                <span class="input-group-btn">
                    <button class="btn btn-warning btn-sm" id="btn-chat"
                            @click="AddMessage(content)">
                        Отправить:</button>
                                    </span>
            </div>
        </div>

    </div>

<?php
Yii::$app->view->registerJs("var messages = " . Json::encode($messages)
    . ";", \yii\web\View::POS_END);
Yii::$app->view->registerJs("var userAuth = " . Json::encode($user_auth)
    . ";", \yii\web\View::POS_END);
Yii::$app->view->registerJs("var chat = " . Json::encode($chat)
    . ";", \yii\web\View::POS_END);
Yii::$app->view->registerJs("var users = " . Json::encode($users)
    . ";", \yii\web\View::POS_END);


$js = <<<JS

$('body').scrollspy({ target: '.chat' });

    new Vue({
    el: '#chat',
    data:{
      messages: messages,
      add_messages: [],
      content: '',
      
      //user
      userAuth: userAuth,
      users: users,
    },
    methods: {
      AddMessage(content){
        this.add_messages.push({
          content: content,
          });
        $.ajax({
         url: '/user/chat/add-message-ajax',
         type: 'GET',
         data: "content=" + content + "&chat_id=" + chat.id + "&user_id=" + userAuth.id,
         success: function(){
           console.log( id + 'success push');
           setTimeout(function(){ $('#del' + id).remove();}, 120);
         },
         error: function(){
         alert('Error!');
         }
         });
         return false;
      }
      
    }}
    )
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>