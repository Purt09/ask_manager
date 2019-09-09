<?php

use yii\helpers\Json;


?>
<div class="page" id="app">
    Конструктор страницы
    {{ page.title }}
    <button type="button" class="btn btn-default"
            @click="page_cog = !page_cog">
        <span
                class="glyphicon glyphicon-cog" title="Настройки страницы"></span> Настройки страницы
    </button>
    <div class="page_cog bg-light p-3"
         v-show="page_cog">
        <h3>Настройки страницы</h3>
        Заголовок
        <input type="text" class="form-control" placeholder="Заголовок"
               v-model="page.title">
        Описание
        <input type="text" class="form-control" placeholder="Описание"
               v-model="page.description">
        Нижняя часть страницы (footer)
        <input type="text" class="form-control" placeholder="Описание"
               v-model="page.footer_html">
        <h3>SEO:</h3>
        Title
        <input type="text" class="form-control" placeholder="Заголовок"
               v-model="page.seo_title">
        Description
        <input type="text" class="form-control" placeholder="Описание"
               v-model="page.seo_desc">
        Keywords
        <input type="text" class="form-control" placeholder="Описание"
               v-model="page.seo_key">
        <h3>Специальные настройки:</h3>
        class (Пользовательский класс)
        <input type="text" class="form-control" placeholder="class"
               v-model="page.class">
        JS
        <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="3"
                  placeholder="Введите свой код!"
                  v-model="page.js"></textarea>
        CSS
        <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="3"
                  placeholder="Введите свой код!"
                  v-model="page.style"></textarea>
        <button type="button" class="btn btn-success"
                @click="page_save()"><span
                    class="glyphicon glyphicon-ok" title="Сохранить"></span> Сохранить страницу
        </button>

    </div>


    <!--    Блоки-->
    <div class="builder_block"
         v-for="block,index in blocks"
         v-if="block.id != 0">
        <div :class="block.class">
            <div class="panel panel-default">
                <div class="panel-heading p-1 pl-3">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4>{{block.title}} </h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default"><span
                                            class="glyphicon glyphicon-arrow-down" title="Вниз"></span></button>
                                <button type="button" class="btn btn-default"><span
                                            class="glyphicon glyphicon-arrow-up" title="Вверх"></span></button>
                                <button type="button" class="btn btn-default"
                                        @click="duplicate_block(block.id)"><span
                                            class="glyphicon glyphicon-copy" title="Дублировать"></span></button>
                                <button type="button" class="btn btn-default"
                                        @click="edit_block_view = block.id"><span
                                            class="glyphicon glyphicon-pencil " title="Редактировать"></span></button>
                                <button type="button" class="btn btn-danger"
                                        @click="delete_block(block.id)"><span
                                            class="glyphicon glyphicon-remove" title="Удалить"></span></button>
                            </div>
                        </div>
                    </div>

                    <!--                    Изменение блока-->
                    <div v-show="edit_block_view == block.id" class="bg-light p-3">
                        Заголовок:
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="Заголовок"
                                       v-model="block.title">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" placeholder="Тег"
                                       v-model="block.title_head">
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Цвет"
                                           v-model="add_block_color">
                                    <span class="input-group-addon"
                                          :style="'background: #' + add_block_color"></span>
                                </div>
                            </div>
                        </div>
                        Class:
                        <input type="text" class="form-control" placeholder="Class"
                               v-model="block.class">
                    </div>
                </div>


                <!--                Если блок html то-->
                <div class="panel-body"
                     v-if="block.builder_table == 'blok_html'">

                    <div v-html="block.builder_id.code"
                         v-if="prev_html != block.id"
                         @click="prev_html = block.id"
                         :class="{html_block_border: block.builder_id.border == 1}"
                    ></div>
                    <div class="form-group" v-else>
                        <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="4" placeholder="Введите свой код!"
                                  v-model="block.builder_id.code"></textarea>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-success"
                                @click="save_block_html(block.id)"><span
                                    class="glyphicon glyphicon-ok" title="Сохранить"></span> Сохранить блок
                        </button>
                    </div>
                </div>
                <!--                -->
            </div>
        </div>
    </div>


    <!--    Новый блок!-->
    <div class="bg-light text-center p-3 bg_add_block"
         @click="add_block()">
        <span class="glyphicon glyphicon-plus"></span>
    </div>
    <div class="add_block mt-2 bg-light shadow-sm p-2"
         v-show="add_block_view">
        <h3 class="text-center">
            Добавление блока!
        </h3>
        <div class="row">
            <div class="col-lg-5">
                <input type="text" class="form-control" placeholder="Заголовок"
                       v-model="add_block_title">
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-1">
                <input type="text" class="form-control" placeholder="Тег(h2)"
                       v-model="add_block_tag">
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Цвет"
                           v-model="add_block_color">
                    <span class="input-group-addon"
                          :style="'background: #' + add_block_color"></span>
                </div>
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-2">
                <input type="text" class="form-control" placeholder="class"
                       v-model="add_block_class">
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
        <div :style="'color: #' + add_block_color">
            <div v-if="add_block_tag == 'h2'">
                <h2> {{add_block_title}} </h2>
            </div>
            <div v-if="add_block_tag == 'h3'">
                <h3> {{add_block_title}} </h3>
            </div>
            <div v-if="add_block_tag == 'h4'">
                <h4> {{add_block_title}} </h4>
            </div>
        </div>
        <div class="text-center">
            Выберите тип блока(В будущем можно и по группно сгрупировать: Призывы действия, списки и т.д.)
        </div>
        <button class="btn btn-default m-2"
                @click="new_block_html()">
            HTML
        </button>
    </div>

<!--    Создание блока HTML-->
    <div class="bg-light mt-3 p-4"
         v-show="html_block_view">
        <div class="form-group">
            <label class="text-center" for="exampleFormControlTextarea1">Добавить html block! </label>
            <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="10"
                      placeholder="Введите свой код!"
                      v-model="html_block_code"></textarea>
        </div>
        <input type="checkbox"
               v-model="html_block_border"> Добавить рамку? <br>
        <button class="btn btn-success"
                @click="html_block_save()">
            Добавить
        </button>

    </div>

</div>

<?php
Yii::$app->view->registerJs("var page = " . Json::encode($page)
    . ";", \yii\web\View::POS_END);
Yii::$app->view->registerJs("var blocks = " . Json::encode($blocks)
    . ";", \yii\web\View::POS_END);

$js = <<<JS

new Vue({
el: '#app',
data:{
  // Сама страница
  page: page,
  page_cog: false,
  //блоки
  blocks: blocks,
  edit_block_view: 0,
  // Добавление блоков
  add_block_view: false,
  add_block_title: '',
  add_block_tag: 'h2',
  add_block_color: '7faf24',
  add_block_class: '',
  //html
    html_block_view: false,
    html_block_code: '',
    html_block_border: 0,
    prev_html: 0,
},
methods: {
  page_save(){
    this.page_cog = false;
    $.ajax({
         url: '/testbuilder/ajax/update-page',
         type: 'GET',
         data: 'id=' + page.id + '&title=' + page.title + '&desc=' + page.description + '&class=' + page.class + '&seo_t=' + page.seo_title + '&seo_d=' + page.seo_desc + '&seo_k=' + page.seo_key + '&foot=' + page.footer_html + '&js=' +  page.js + '&style=' + page.style,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         }
         });
  },
  
  // СОЗДАНИЕ НОВОГО БЛОКА
  add_block(){
    this.add_block_view = true;
  },
  
  // БЛОК HTML
  new_block_html(){
    this.add_block_view = false;
    this.html_block_view = true;
  },
  html_block_save(){
    this.html_block_view = false;
    $.ajax({
         url: '/testbuilder/ajax/add-block-html',
         type: 'GET',
         data: 'page_id=' + this.page.id + '&title=' + this.add_block_title + '&title_head=' + this.add_block_tag + '&title_color=' + this.add_block_color + '&class=' + this.add_block_class + '&code=' + this.html_block_code + '&border=' + this.html_block_border ,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         }
         });
  },
  save_block_html(id) {
    this.save_block(id);
    this.prev_html = 0;
    $.ajax({
         url: '/testbuilder/ajax/save-block-html',
         type: 'GET',
         data: 'id=' + this.blocks[id].builder_id.id + '&code=' + this.blocks[id].builder_id.code + '&border=' + this.blocks[id].builder_id.border,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         }
         });
    },
  // Упраление БЛОКАМИ
  delete_block(id){
    blocks[id].id = 0;
    $.ajax({
         url: '/testbuilder/ajax/delete-block',
         type: 'GET',
         data: 'id=' + id,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         }
         });
  },
  duplicate_block(id){
    $.ajax({
         url: '/testbuilder/ajax/duplicate-block',
         type: 'GET',
         data: 'id=' + id,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         }
         });
    },
    save_block(id){
    
      $.ajax({
         url: '/testbuilder/ajax/save-block',
         type: 'GET',
         data: 'page_id=' + this.page.id + '&title=' + this.blocks[id].title + '&title_head=' + this.blocks[id].title_head + '&title_color=' + this.blocks[id].title_color + '&border=' + id + '&class=' + '&id=' + id + this.blocks[id].class ,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         }
         });
    },
    
  }




})

JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>
<style>
    .bg_add_block {
        border: 5px solid;
        border-color: #999999;
        border-radius: 20px 20px;
    }

    .bg_add_block :hover {
        border: 5px solid;
        background: #494f54;
        color: white;
        border-radius: 20px 20px;
    }
    .html_block_border {
        padding: 45px 50px 20px;
        border: 2px solid #f60;
        margin-top: 2em;
    }
</style>
