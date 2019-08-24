<?php

use yii\helpers\Json;

?>
<div id="project">
    <!--    Проекты-->
    <div class="col-sm-3">
        <div class="list-group">
            <a class="list-group-item"
               v-for="(project, id) in projects"
               v-on:click="selectProject(project.id)"
               :class="{'active': selectProjectIndex === project.id}">
                <span v-if="project.parent_id == null"><i class="glyphicon glyphicon-star"></i></span>
                <span v-else><i class="glyphicon glyphicon-minus"></i>  </span>
                {{ project.title }}
            </a>
        </div>
    </div>
    <!--    Конец проектов-->
    <div class="col-sm-9">
        <div class="p-3 mb-3 bg-info text-white row shadow ">
            Задачи: <b>({{project.title}})</b>
        </div>
        <div id="tasks">
            <!--            Форма добавления задачи-->
            <div class="bg-light row shadow mb-4"
                 v-show="add_task_form">
                <div class="input-group pb-3 p-2">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-tasks"></span></span>
                    <input type="text" class="form-control" placeholder="Добавить задачу"
                           v-model="text_task">
                    <span class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-cog"></span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a @click="timer = true" href="#">Таймер</a>
                            <a @click="desc = true" href="#">Описание</a>
                        </li>
                    </ul>
                </span>
                    <span class="input-group-btn">
                    <button class="btn btn-success " type="button"
                            @click="addTask(project.id, text_task, description, time)">
                        Добавить!
                    </button>
                 </span>
                </div>
                <div class="p-2"
                     v-show="desc">
                    <div class="input-group pb-3">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                        <input type="text" class="form-control" placeholder="Описание"
                               v-model="description">
                        <span class="input-group-btn">
                            <button class="btn btn-danger" type="button"
                                    @click="desc = false">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="p-2 pb-2"
                     v-show="timer">
                    Добавить ограничение по времени: <strong> {{message_time}} </strong>
                    <br>
                    <div class="btn-group center-block pb-5">
                        <button @click="time = 28800; message_time='8 часов'" type="button" class="btn btn-default">8
                            часов
                        </button>
                        <button @click="time = 43200; message_time='12 часов'" type="button" class="btn btn-default">12
                            часов
                        </button>
                        <button @click="time = 86400; message_time='Сутки'" type="button" class="btn btn-default">
                            Сутки
                        </button>
                        <button @click="time = 259200; message_time='3 суток'" type="button" class="btn btn-default">3
                            суток
                        </button>
                        <button @click="time = 432000; message_time='5 дней'" type="button" class="btn btn-default">5
                            дней
                        </button>
                        <button @click="time = 604800; message_time='Неделя'" type="button" class="btn btn-default">
                            Неделя
                        </button>
                        <button @click="time = 2592000; message_time='Месяц'" type="button" class="btn btn-default">
                            Месяц
                        </button>
                        <button class="btn btn-danger" type="button" @click="timer = false">
                            <span class="glyphicon glyphicon-remove"></span></button>
                    </div>
                </div>
            </div>
            <!--            Конец формы задачи-->
            <!--            Добавленые задачи-->
            <div class="bg-light  p-1 pb-0 shadow-sm mb-4 row"
                 v-for="(task_add, index) in tasks_add"
                 v-bind:id="'del' + task_add.id">
                <div class="col-xs-1 pl-1 pt-2">
                    <button id="taskcomplete" type="button" class="btn btn-danger btn-sm">NEW</button>
                </div>
                <div class="col-xs-8">
                    {{ task_add.title }}
                </div>
                <div class="col-xs-3 text-right">
                </div>
            </div>
            <!--      Конец добавленного      -->
            <!--            Текущие задачи-->
            <div class="bg-light  p-1 pb-0 shadow-sm mb-4 row"
                 v-for="(task, index) in tasks"
                 v-if="(
                        ((project.id == task.project_id) || (project.id == 0))&& (task.status != 0)
                        ||
                        ((project.id == 1) && (task.status == 0))
                        ||
                        ((project.id == 2) && (task.status == 2))
                        ||
                        ((project.id == 3) && (task.status != 0) && (task.user_id == userAuth))
                        )"
                 v-bind:id="'del' + task.id">
                <div class="col-xs-1 pl-1 pt-2">
                    <button id="taskcomplete" type="button" class="btn"
                            v-on:click="CompleteTask(task.id)"
                            v-bind:class="'btn-' + colortasks[task.id]">
                        <i class="glyphicon glyphicon-ok"> </i>
                    </button>
                </div>
                <div class="col-xs-8">
                    <a class="text-dark"
                       v-bind:href="'/task/user/' + task.id + '/update'">
                        {{ task.title }}
                        <div v-if="(task.status == 2) && (task.user_id != null)">
                            Задача просрочена пользователем
                        </div>
                        <div class="text-secondary">
                            {{ task. description }}
                        </div>
                    </a>
                    <span class="label label-danger"
                          v-if="task.updated_at !=  null">
                        {{task.updated_at}}
                    </span>
                </div>
                <!--                    Кнопки справа-->
                <div class="col-xs-3 text-right"
                     v-show="user_show">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <!--                            Задача кому-то поручена-->
                            <div v-if="task.user_id != null">
                                <li role="presentation" class="dropdown-header">Задача поручена пользователю</li>
                                <strong>
                                    <li role="presentation" class="dropdown-header text-center"
                                        v-for="(user, index) in users"
                                        v-if="user.id == task.user_id">
                                        {{user.username}}
                                    </li>
                                </strong>
                            </div>
                            <!--                            Задача кому-то поручена-->
                            <li>
                                <a href="#" data-toggle="modal" data-target="#AddUserTask">
                                    <span class="glyphicon glyphicon-user"></span>Поручить пользователю
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--                    Конец кнопок справа-->

                <div class="modal fade" id="AddUserTask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="myModalLabel">Поручить задачу пользователю:</h4>
                                <button @click="addPersonalTask(task.id, null)" type="button" class="btn btn-success"
                                        data-dismiss="modal">Открепить
                                </button>
                            </div>
                            <div class="alert alert-success"
                                 v-show="flash">
                                Задача поручена!
                            </div>
                            <ul class="list-group" @click="flash = true">
                                <a @click="addPersonalTask(task.id, user.id)" v-for="user in users" href="#"
                                   class="text-dark list-group-item">{{user.username}}</a>

                            </ul>
                            <div class="modal-footer text-secondary">
                                Выберите пользователя, которму необходимо поручить задачу
                                <strong>{{task.title}}</strong>
                                <br>
                                После поручения, задача станет для него личной.
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!--            Конец задачи-->
    </div>
</div>

<?php
$projects += array('0' => ['title' =>  'Все', 'id' =>  0]);
$projects += array('1' => ['title' =>  'Выполненные', 'id' =>  1, 'parent_id' => 0]);
$projects += array('2' => ['title' =>  'Просроченные', 'id' =>  2, 'parent_id' => 0]);
$projects += array('3' => ['title' =>  'Личные', 'id' =>  3, 'parent_id' => 0]);

Yii::$app->view->registerJs("var projects = " . Json::encode($projects)
    . ";", \yii\web\View::POS_END);
Yii::$app->view->registerJs("var project = " . Json::encode($project)
    . ";", \yii\web\View::POS_END);
Yii::$app->view->registerJs("var tasks = " . Json::encode($tasks)
    . ";", \yii\web\View::POS_END);
Yii::$app->view->registerJs("var colortasks = " . Json::encode($colortasks)
    . ";", \yii\web\View::POS_END);
Yii::$app->view->registerJs("var users = " . Json::encode($users)
    . ";", \yii\web\View::POS_END);
Yii::$app->view->registerJs("var time_now = " . Json::encode($time)
    . ";", \yii\web\View::POS_END);
Yii::$app->view->registerJs("var userAuth = " . Json::encode(Yii::$app->user->id)
    . ";", \yii\web\View::POS_END);


$js = <<<JS
if((users.length > 0) && (userAuth == project.creator_id))
  user_show = true;
else
  user_show = false;

new Vue({
el: '#project',
data:{
    //Проект
    projects: projects,
    project: project,
    selectProjectIndex: project,
    // Задачи
    tasks: tasks,
    colortasks: colortasks,
    tasks_add: [],
    time: null,
    description: null,
    message_time: '',
    // Плагинация task
    // Пользователи
    users: users,
    userAuth: userAuth, // Кто авторизован? id
    // Hidden block
    desc: false,
    timer: false,
    flash: false,
    add_task_form: true,
    user_show: user_show,
},
methods: {
    selectProject: function(index) {
      this.project = projects[index];
      this.selectProjectIndex = index
      if((index == 0) || (index == 1) || (index == 2) || (index == 3)){
        this.add_task_form = false;
      } else this.add_task_form = true;
    },
    CompleteTask: function(id) {
          $.ajax({
         url: '/task/user/complete',
         type: 'GET',
         data: "id=" + id,
         success: function(){
           console.log( id + 'success push');
           setTimeout(function(){ $('#del' + id).remove();}, 120);
         },
         error: function(){
         alert('Error!');
         }
         });
     },
     addTask(project_id, title, description, time) {
          if (time != null) time += time_now;
          if(title == null) {
            title = 'Ошибка! Заголовок не может быть пустым';
          }
          this.tasks_add.push({
          id: 0,
          title: title,
          project_id: project_id,
          description: description,
          time: time
          });
          if(title == 'Ошибка! Заголовк не может быть пустым') return false ;
           $.ajax({
         url: '/task/user/create-task-ajax',
         type: 'GET',
         data: "title=" + title + '&project_id=' + project_id + '&description=' + description + '&updated_at=' + time,
         success: function(){
           console.log( title + ' success push ' + project_id);
         },
         error: function(){
         alert('Error!');
         }
         });
         return false;
    },
    addPersonalTask(task_id, user_id) {
         $.ajax({
         url: '/task/user/add-personal-task',
         type: 'GET',
         data: "user_id=" + user_id + '&task_id=' + task_id,
         success: function(){
           console.log( user_id + ' success push ' + task_id);
         },
         error: function(){
         alert('Error!');
         }
         });
         return false;
    },
}



})

JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>

