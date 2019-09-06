<?php

use yii\helpers\Json;

?>

<div id="project">
    <div class="alert alert-success"
         v-show="flash">
        Задача поручена!
    </div>
    <!--    Проекты-->
    <div class="col-sm-3">
        <div class="list-group">
            <a class="list-group-item"
               v-for="(project, id) in projects"
               v-on:click="selectProject(project.id)"
               :class="{'active': selectProjectIndex === project.id}">
                <span v-if="project.parent_id == null"><i class="glyphicon glyphicon-star"></i></span>
                <span v-else>
                    <i class="glyphicon glyphicon-minus"></i>
                </span>
                {{ project.title }}
                <span class="badge badge-primary badge-pill"
                      v-if="(project.id >= 4) && (project.parent_id != null) && (project.creator_id == userAuth)"
                      @click="deleteProject(project.id)">
                    <i class="glyphicon glyphicon-remove"></i>
                </span>

            </a>
        </div>
    </div>
    <!--    Конец проектов-->
    <div class="col-sm-9">
        <div class="p-3 mb-3 bg-info text-white row shadow ">
            Задачи: <b>({{project.title}})</b>
        </div>
        {{ project.description }}
        <h4>
            <span class="label label-danger">{{ project.time_at }}</span>
        </h4>

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
                 :id="'del' + task_add.id"
                 v-if="task_add.project_id == project.id">
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
                    <div class="text-dark"
                         :class="{ hidden : edit_task == task.id }"
                         :id="'title_task' + task.id"
                         @click="editTask(task.id)">
                        {{ task.title }}
                        <div class="text-secondary">
                            {{ task. description }}
                        </div>
                    </div>
                    <div class="input-group"
                         :class="{ hidden : edit_task != task.id }"
                         :id="'input_task' + task.id">
                        <input type="text" class="form-control"
                               v-model="task.title">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button"
                                    @click="saveTask(task.id, task.title)">
                                <span class="glyphicon glyphicon-floppy-disk"></span>
                            </button>
                            <button class="btn btn-success" type="button"
                                    @click="editTimeTask(task.id)">
                                <span class="glyphicon glyphicon-time"></span>
                            </button>
                        </span>
                    </div><!-- /input-group -->
                    <div class="p-2 pb-2"
                         :class="{ hidden : edit_task_time != task.id }">
                        <br>
                        Добавить ограничение по времени: <strong> {{message_time}} </strong>

                        <div class="btn-group center-block pb-5">
                            <button @click="time = 28800; message_time='8 часов'" type="button" class="btn btn-default">
                                8
                                часов
                            </button>
                            <button @click="time = 43200; message_time='12 часов'" type="button"
                                    class="btn btn-default">12
                                часов
                            </button>
                            <button @click="time = 86400; message_time='Сутки'" type="button" class="btn btn-default">
                                Сутки
                            </button>
                            <button @click="time = 259200; message_time='3 суток'" type="button"
                                    class="btn btn-default">3
                                суток
                            </button>
                            <button @click="time = 432000; message_time='5 дней'" type="button" class="btn btn-default">
                                5
                                дней
                            </button>
                            <button @click="time = 604800; message_time='Неделя'" type="button" class="btn btn-default">
                                Неделя
                            </button>
                            <button @click="time = 2592000; message_time='Месяц'" type="button"
                                    class="btn btn-default">
                                Месяц
                            </button>
                            <button class="btn btn-success" type="button"
                                    @click="saveTimeTask(task.id, time)">
                                <span class="glyphicon glyphicon-ok"></span></button>
                        </div>
                    </div>
                    <div class="label label-warning"
                         :class="{ hidden : help_time_set != task.id }">
                        Выберите ограничение по времени!
                    </div>
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
                            <li v-if="task.user_id != null">
                                <a href="#"
                                   @click="addPersonalTask(task.id, null)">
                                    <span class="glyphicon glyphicon-remove-circle"></span>
                                    Открепить
                                </a>
                                <hr>
                            </li>

                            <!--                            Поручить задачу-->
                            <li role="presentation" class="dropdown-header">Поручить задачу пользователю:</li>
                            <li v-for="user in users">
                                <a href="#"
                                   @click="addPersonalTask(task.id, user.id)">
                                    {{user.username}}

                                </a>
                            </li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-search"></span><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right">

                        <li role="presentation" class="dropdown-header">Задача создана пользователем:</li>
                        <li role="presentation" class="dropdown-header text-center"
                            v-for="user in users"
                            v-if="user.id == task.context_id">
                            {{user.username}}
                        </li>
                        <hr>
                        <li role="presentation" class="dropdown-header">{{task.created_at}}</li>
                    </ul>
                    </ul>
                </div>
                <!--                    Конец кнопок справа-->


            </div>
        </div>
        <!--            Конец задачи-->
    </div>
</div>

<?php
$projects += array('0' => ['title' => 'Все', 'id' => 0]);
$projects += array('1' => ['title' => 'Выполненные', 'id' => 1, 'parent_id' => 0]);
$projects += array('2' => ['title' => 'Просроченные', 'id' => 2, 'parent_id' => 0]);
$projects += array('3' => ['title' => 'Личные', 'id' => 3, 'parent_id' => 0]);

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
    // Изменить опред задачу
    edit_task: 0,
    edit_task_time: 0,
    help_time_set: 0,
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
         url: '/task/ajax/complete-task',
         type: 'GET',
         data: "id=" + id,
         success: function(){
           console.log( id + 'success push');
           $('#del' + id).remove();
         },
         error: function(){
         alert('Error!');
         }
         });
     },
     addTask(project_id, title, description, time) {
          this.text_task = '';
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
         url: '/task/ajax/create-task',
         type: 'GET',
         data: "title=" + title + '&project_id=' + project_id + '&description=' + description + '&updated_at=' + time,
         success: function(){
           console.log( title + ' success push ' + project_id);
         },
         error: function(){
         alert('Error!');
         }
         });
    },
    addPersonalTask(task_id, user_id) {
      this.flash = true;
         $.ajax({
         url: '/task/user/add-personal-task-ajax',
         type: 'GET',
         data: "user_id=" + user_id + '&task_id=' + task_id,
         success: function(){
           console.log( user_id + ' success push ' + task_id);
           this.flash = false;
         },
         error: function(){
         alert('Error!');
         }
         });
    },
    deleteProject(project_id){
      this.selectProjectIndex.id = 0;
      projects[project_id].description = 'Подпроект был ЗАКРЫТ! Обновите страницу!'
      $.ajax({
         url: '/project/ajax/delete-project',
         type: 'GET',
         data: "project_id=" + project_id,
         success: function(){
           console.log( user_id + ' success push ' + task_id);
           this.flash = false;
         },
         error: function(){
         alert('Error!');
         }
         });
    },
    editTask(id){
      this.edit_task = id;
      this.time = null;
      this.edit_task_time = 0;
      this.help_time_set = 0;
    },
    saveTask(id, title){
      $.ajax({
         url: '/task/ajax/save-task-title',
         type: 'GET',
         data: "title=" + title + "&id=" + id,
         success: function(){
           console.log( id + 'success push');
           this.tasks[id].title = title;
         },
         error: function(){
         alert('Error!');
         }
         });
      this.edit_task = 0;
      this.help_time_set = 0;
      this.edit_task_time = 0;
      this.time = null;
      
    },
    editTimeTask(id){
      this.edit_task_time = id;
      this.time = null;
      },
      saveTimeTask(id, time){
        this.help_time_set = 0;
       if(time != null){
         this.edit_task_time = 0;
       $.ajax({
         url: '/task/ajax/save-task-time',
         type: 'GET',
         data: "time=" + time + "&id=" + id,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         alert('Error!');
         }
         });
       } else {
         this.help_time_set = id;
       }
      }
}



})

JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>

</div>