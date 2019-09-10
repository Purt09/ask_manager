<?php

use yii\helpers\Json;

?>
<div class="page" id="app">

    <button type="button" class="btn btn-default"
            @click="page_cog = !page_cog">
        <span
                class="glyphicon glyphicon-cog" title="Настройки страницы"></span> Настройки страницы
    </button>


    <!--    Блоки-->
    <section v-if="block.id != 0"
             v-for="block,index in blocks">
        <div :class="block.class"
             class="builder_block">
            <div class="row"
                 v-if="edit_block_title_ != index">
                <div class="col-sm-6">
                    <div class="block_title"
                         @click="edit_block_title(index)">
                        <div v-if="block.title_head == 'h2'"
                             :style="'color: #' + block.title_color">
                            <h2> {{block.title}}</h2>
                        </div>
                        <div v-if="block.title_head == 'h3'">
                            <h3> {{block.title}} </h3>
                        </div>
                        <div v-if="block.title_head == 'h4'">
                            <h4> {{block.title}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"
                 v-else>


            </div>
            <div v-html="block.builder_id.code"
                 :class="{html_block_border: block.builder_id.border == 1}"></div>
        </div>
</div>

<!--                    Изменение блока-->
<div v-show="edit_block_view == block.id" class="bg-light p-3">
    Заголовок:
    <div class="row">

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
                        <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="4"
                                  placeholder="Введите свой код!"
                                  v-model="block.builder_id.code"></textarea>
        <button class="btn btn-default"
                @click="block.builder_id.border = 1"> Добавить рамку
        </button>
        <button class="btn btn-default"
                @click="block.builder_id.border = 0"> Удалить рамку
        </button>
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
</section>


<!--    Новый блок!-->
<div class="bg-light text-center p-3 bg_add_block"
     @click="add_block()">
    <span class="glyphicon glyphicon-plus"></span>
</div>


<!--    Окно добавления нового блока-->
<modal v-if="showModal" @close="showModal = false">
    <h3 slot="header">Добавить блок</h3>
    <div slot="body">
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
    <div slot="footer">
        <button class="btn btn-danger"
                @click="close_modal_add_block()"> Закрыть
        </button>
    </div>
</modal>

<!--    Окно добавления нового блока-->
<modal v-if="page_cog" @close="showModal = false">
    <h3 slot="header">Настройки страницы</h3>
    <div slot="body">
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
    </div>
    <div slot="footer">
        <button class="btn btn-danger"
                @click="page_cog = false"> Закрыть
        </button>
    </div>
</modal>
</div>


<script type="text/x-template" id="modal-template">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="modal-header">
                        <slot name="header">
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                        </slot>
                    </div>
                </div>
            </div>
        </div>

    </transition>
</script>
<?php
Yii::$app->view->registerJs("var page = " . Json::encode($page)
    . ";", \yii\web\View::POS_END);
Yii::$app->view->registerJs("var blocks = " . Json::encode($blocks)
    . ";", \yii\web\View::POS_END);

$js = <<<JS

Vue.component('modal', {
  template: '#modal-template'
})

new Vue({
el: '#app',
data:{
  // Сама страница
  page: page,
  page_cog: false,
  //блоки
  blocks: blocks,
  edit_block_view: 0,
  edit_block_title_: 0,
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
    
    showModal: false,
},
methods: {
  close_modal_add_block() {
    this.showModal = false;
    this.html_block_view = false;
  },
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
    this.showModal = true;
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
    save_block_new(index){
      $.ajax({
         url: '/testbuilder/ajax/save-block',
         type: 'GET',
         data: 'page_id=' + this.page.id + '&title=' + this.blocks[index].title + '&title_head=' + this.blocks[index].title_head + '&title_color=' + this.blocks[index].title_color + '&class=' + '&id=' + id + this.blocks[id].class ,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         }
         });
    },
    edit_block_title(index) {
      this.edit_block_title_ = index;
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

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        overflow: scroll;
        width: 80%;
        height: 400px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    }

    /*
     * The following styles are auto-applied to elements with
     * transition="modal" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the modal transition by editing
     * these styles.
     */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }

    .builder_block :hover {
        border: #494f54 1px dotted;
    }
</style>
