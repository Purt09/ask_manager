<?php

$this->title = Yii::t('app', 'PROJECTS');
$this->params['breadcrumbs'][] = $this->title;

\Yii::$app->view->registerMetaTag([
    'name' => 'title',
    'content' => $page->seo_title,
]);
\Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $page->seo_desc,
]);
\Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => $page->seo_key,
]);

use yii\helpers\Json;


?>

<div class="page" id="app">
    <div class="container">
        <button type="button" class="btn btn-default"
                @click="page_cog = !page_cog">
        <span
                class="glyphicon glyphicon-cog" title="Настройки страницы"></span> Настройки страницы
        </button>
    </div>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li v-for="block in blocks"
                        v-if="block.isLink == 1">
                        <a :href="'#' + block.id">{{block.link_title}}</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>


    <!--    Окно редакттрования страницы-->
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


    <section v-for="block,index in blocks"
             :class="{container: !block.css_isContainer}">
        <a :name="block.id"></a><br><br>
        <div :class="block.class"
             :style="'margin-top: ' + block.style_margin_top + 'px' + '; margin-bottom: ' + block.style_margin_bottom + 'px'">
            <div class="title block"
                 v-if="block_title_edit != index"
                 @click="edit_block_title(index)"
                 :style="'color: #' + block.title_color">
                <div v-if="block.title_head == 'h2'">
                    <h2> {{block.title}}</h2>
                </div>
                <div v-if="block.title_head == 'h3'">
                    <h3> {{block.title}} </h3>
                </div>
                <div v-if="block.title_head == 'h4'">
                    <h4> {{block.title}}</h4>
                </div>
            </div>
            <div class="edit_title row"
                 v-else>
                <div class="col-sm-4 block_no_hover">
                    <input type="text" class="form-control" placeholder="Заголовок"
                           v-model="block.title">
                </div>
                <div class="col-sm-1">
                    <input type="text" class="form-control" placeholder="Тег"
                           v-model="block.title_head">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                            <span class="input-group-addon"
                                  :style="'background: #' + block.title_color"></span>
                        <input type="text" class="form-control" placeholder="Цвет"
                               v-model="block.title_color">
                        <span class="input-group-btn">
                                <button class="btn btn-success" type="button"
                                        @click="save_block_title(index)">Сохранить!</button>

                             </span>
                    </div>
                </div>
                <div class="col-sm-4 text-right">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default"><span
                                    class="glyphicon glyphicon-arrow-down" title="Вниз"></span></button>
                        <button type="button" class="btn btn-default"><span
                                    class="glyphicon glyphicon-arrow-up" title="Вверх"></span></button>
                        <button type="button" class="btn btn-default"
                                @click="block_duplicate(index)"><span
                                    class="glyphicon glyphicon-copy" title="Дублировать"></span></button>
                        <button type="button" class="btn btn-default"
                                @click="block_edit(index)"><span
                                    class="glyphicon glyphicon-pencil " title="Редактировать"></span></button>
                        <button type="button" class="btn btn-danger"
                                @click="block_delete(index)"><span
                                    class="glyphicon glyphicon-remove" title="Удалить"></span> Удалить!
                        </button>
                        <button class="btn btn-warning" type="button"
                                @click="block_title_edit = 999">Закрыть!
                        </button>
                    </div>

                    <!--    Окно редактирования блока-->
                    <modal v-if="(block_edit_modal == index) && (showModal)" @close="showModal = false"
                           class="block_no_hover">
                        <h3 slot="header">Изменить блок</h3>
                        <div slot="body">
                            <div class="add_block mt-2 bg-light shadow-sm p-2">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" placeholder="Заголовок"
                                               v-model="block.title">
                                    </div><!-- /.col-lg-6 -->
                                    <div class="col-lg-1">
                                        <input type="text" class="form-control" placeholder="Тег(h2)"
                                               v-model="block.title_head">
                                    </div><!-- /.col-lg-6 -->
                                    <div class="col-lg-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Цвет"
                                                   v-model="block.title_color">
                                            <span class="input-group-addon"
                                                  :style="'background: #' + block.title_color"></span>
                                        </div>
                                    </div><!-- /.col-lg-6 -->
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" placeholder="class"
                                               v-model="block.class">
                                    </div><!-- /.col-lg-6 -->
                                </div><!-- /.row -->
                                <div :style="'color: #' + block.title_color">
                                    <div v-if="block.title == 'h2'">
                                        <h2> {{block.title}} </h2>
                                    </div>
                                    <div v-if="block.title == 'h3'">
                                        <h3> {{block.title}} </h3>
                                    </div>
                                    <div v-if="block.title == 'h4'">
                                        <h4> {{block.title}} </h4>
                                    </div>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><strong>Отступы:</strong></span>
                                    <input type="text" class="form-control" placeholder="сверху"
                                           v-model="block.style_margin_top">
                                    <span class="input-group-addon">сверху(px)</span>
                                    <input type="text" class="form-control" placeholder="снизу"
                                           v-model="block.style_margin_bottom">
                                    <span class="input-group-addon">снизу(px)</span>
                                    <span class="input-group-addon" style="background: #1d2124"></span>
                                    <span class="input-group-addon"><strong>Видимость(больше будет скрываться):</strong></span>
                                    <input type="text" class="form-control" placeholder="снизу"
                                           v-model="block.style_media">
                                    <span class="input-group-addon">px</span>
                                    <span class="input-group-addon">
                                        <input type="checkbox"
                                               v-model="block.css_isContainer">
                                        <strong>
                                        Полная ширина экрана!
                                            </strong>
                                    </span>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox"
                                               v-model="block.isLink">
                                        <strong>
                                        Ссылка в меню
                                            </strong>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Текст"
                                           v-model="block.link_title"
                                           v-show="block.isLink">
                                </div>
                            </div>

                            <button class="btn btn-success m-2"
                                    @click="block_save_data(index)">
                                Сохранить
                            </button>
                        </div>
                        <div slot="footer">
                            <button class="btn btn-danger"
                                    @click="modal_close_add_block()"> Закрыть
                            </button>
                        </div>
                    </modal>
                </div>
            </div>


            <!--                Если блок HTML!-->
            <div v-if="block.builder_table == 'blok_html'"
                 class="block">
                <div v-html="block.builder_id.code"
                     v-if="prev_html != index"
                     @click="prev_html = index"
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
                    <button type="button" class="btn btn-success text-right"
                            @click="block_html_save(index)"><span
                                class="glyphicon glyphicon-ok" title="Сохранить"></span> Сохранить блок
                    </button>
                </div>

            </div>
        </div>
    </section>

    <!--    Новый блок!-->
    <div class="bg-light text-center p-3 bg_add_block container"
         @click="add_block()">
        <span class="glyphicon glyphicon-plus"></span>
    </div>


    <!--    Окно добавления нового блока-->
    <modal v-if="(showModal) && (block_add_modal)" @close="showModal = false" class="block_no_hover">
        <h3 slot="header">Добавить блок</h3>
        <div slot="body">
            <div class="add_block mt-2 bg-light shadow-sm p-2"
                 v-show="block_add_view">
                <h3 class="text-center">
                    Добавление блока!
                </h3>
                <div class="row">
                    <div class="col-lg-5">
                        <input type="text" class="form-control" placeholder="Заголовок"
                               v-model="block_add_title">
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-1">
                        <input type="text" class="form-control" placeholder="Тег(h2)"
                               v-model="block_add_tag">
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-2">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Цвет"
                                   v-model="block_add_color">
                            <span class="input-group-addon"
                                  :style="'background: #' + block_add_color"></span>
                        </div>
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-2">
                        <input type="text" class="form-control" placeholder="class"
                               v-model="block_add_class">
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
                <div :style="'color: #' + block_add_color">
                    <div v-if="block_add_tag == 'h2'">
                        <h2> {{block_add_title}} </h2>
                    </div>
                    <div v-if="block_add_tag == 'h3'">
                        <h3> {{block_add_title}} </h3>
                    </div>
                    <div v-if="block_add_tag == 'h4'">
                        <h4> {{block_add_title}} </h4>
                    </div>
                </div>
                <button class="btn btn-default m-2"
                        @click="new_block_html()">
                    HTML
                </button>
                <button class="btn btn-default m-2"
                        @click="new_block_command()">
                    Команда
                </button>
            </div>

            <!--    Создание блока HTML-->
            <div class="bg-light mt-3 p-4"
                 v-show="html_block_modal">
                <div class="form-group">
                    <label class="text-center" for="exampleFormControlTextarea1">Добавить html block! </label>
                    <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="10"
                              placeholder="Введите свой код!"
                              v-model="html_block_create_code"></textarea>
                </div>
                <input type="checkbox"
                       v-model="html_block_create_border"> Добавить рамку? <br>
                <button class="btn btn-success"
                        @click="block_html_create()">
                    Добавить
                </button>
            </div>

            <!--    Создание блока COMMANDS-->
            <div class="bg-light mt-3 p-4"
                 v-show="command_block_modal">
                <div class="form-group">
                    <h3>Настройки блока:</h3>
                    <div class="form-group">
                        <label for="sel1">Выберите дизайн:</label>
                        <select class="form-control" id="sel1">
                            <option>Вертикальный</option>
                            <option>Гооризонтальный</option>
                        </select>
                    </div>
                    <h3>Люди:</h3>
                    <input type="text" class="form-control" placeholder="Имя">
                    <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="10"
                              placeholder="Текст"></textarea>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Путь к картинке">
                        <input type="text" class="form-control" placeholder="Высота">
                        <input type="text" class="form-control" placeholder="Ширина">
                        <input type="text" class="form-control" placeholder="border">
                    </div>
                </div>
                <input type="checkbox"
                       v-model="html_block_create_border"> Добавить рамку? <br>
                <button class="btn btn-success"
                        @click="block_command_create()">
                    Добавить
                </button>
            </div>
        </div>
        <div slot="footer">
            <button class="btn btn-danger"
                    @click="modal_close_add_block()"> Закрыть
            </button>
        </div>
    </modal>


</div>


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
  block_title_edit: 999,
  block_edit_modal: 999,
      // добавление блока
      block_add_color: '7faf24',
      block_add_view: false,
      block_add_title: '',
      block_add_tag: 'h2',
      block_add_color: '7faf24',
      block_add_class: '',
      block_add_modal: false,
      
      //БЛОК HTML
      prev_html: 999,
      html_block_modal: false,
      html_block_create_code: '',
      html_block_create_border: 0,
      
      // блок команда
      command_block_modal: false,
      
  showModal: false,
},
methods: {
    edit_block_title(index){
      this.block_title_edit = index;
    },
    save_block_title(index) {
      this.block_title_edit = 999;
      $.ajax({
         url: '/testbuilder/ajax/block-save-title',
         type: 'GET',
         data: 'id=' + blocks[index].id + '&title=' + blocks[index].title + '&title_h=' + blocks[index].title_head + '&title_color=' + blocks[index].title_color,
         success: function(){
           console.log( blocks[index].id + 'success push');
         },
         error: function(){
         }
         });
    },
    block_duplicate(index){
      $.ajax({
         url: '/testbuilder/ajax/block-duplicate',
         type: 'GET',
         data: 'id=' + blocks[index].id,
         success: function(){
           console.log( blocks[index].id + 'success push');
         },
         error: function(){
         }
         });
    },
    block_delete(index){
      $.ajax({
         url: '/testbuilder/ajax/block-delete',
         type: 'GET',
         data: 'id=' + blocks[index].id,
         success: function(){
           console.log( blocks[index].id + 'success push');
         },
         error: function(){
         }
         });
    },
    //
    block_html_save(index){
      this.prev_html = 999;
    $.ajax({
         url: '/testbuilder/ajax/block-html-save',
         type: 'GET',
         data: 'id=' + this.blocks[index].builder_id.id + '&code=' + this.blocks[index].builder_id.code + '&border=' + this.blocks[index].builder_id.border,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         }
         });
    },
    block_edit(index){
      this.showModal = true;
      this.block_edit_modal = index;
    },
    block_save_data(index){
      this.block_title_edit = 999;
      this.modal_close_add_block();
    $.ajax({
         url: '/testbuilder/ajax/save-block',
         type: 'GET',
         data: 'page_id=' + this.page.id + '&title=' + this.blocks[index].title + '&title_head=' + this.blocks[index].title_head + '&title_color=' + this.blocks[index].title_color + '&class=' + this.blocks[index].class + '&id=' + this.blocks[index].id + '&mt=' + this.blocks[index].style_margin_top + '&mb=' + this.blocks[index].style_margin_bottom + '&media=' + this.blocks[index].style_media + '&isCont=' + this.blocks[index].css_isContainer + '&isLink=' + this.blocks[index].isLink + '&link_title=' + this.blocks[index].link_title,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         }
         });
  },
  
  //команда
  new_block_command(){
      this.command_block_modal = true;
      this.block_add_view = false;
  },

    // Дабваление блоков
    add_block(){
      this.block_add_view = true;
      this.showModal = true;
      this.block_add_modal = true;
    },
    new_block_html(){
      this.block_add_view = false;
      this.html_block_modal = true;
    },
    
   
    // МОДАЛЬНОЕ ОКНО
    modal_close_add_block(){
      this.showModal = false;
      this.block_add_modal = false;
      this.block_add_view = false;
    },
    block_html_create(){
      this.html_block_modal = false;
      this.showModal = false;
    $.ajax({
         url: '/testbuilder/ajax/block-html-add',
         type: 'GET',
         data: 'page_id=' + this.page.id + '&title=' + this.block_add_title + '&title_head=' + this.block_add_tag + '&title_color=' + this.block_add_color + '&class=' + this.block_add_class + '&code=' + this.html_block_create_code + '&border=' + this.html_block_create_border,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         }
         });
  },
  
  // СТРАНИЦА
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
    
}
    


})

JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>


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
<style>
    <?= $page->style ?>
</style>
<style>
    .html_block_border {
        padding: 45px 50px 20px;
        border: 2px solid #f60;
        margin-top: 2em;
    }

    .block :hover {
        border: #494f54 1px dotted;
    }

    .block_no_hover :hover {
        border: 0px;
    }

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
</style>
<script>
    <?= $page->js ?>

</script>
