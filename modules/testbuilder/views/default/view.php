<?php

use yii\helpers\Json;

?>
<div class="page" id="app">
    Конструктор страницы
    {{ page.title }}
    <div class="builder_block"
         v-for="block,index in blocks">
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
                                <button type="button" class="btn btn-default"><span
                                            class="glyphicon glyphicon-copy" title="Дублировать"></span></button>
                                <button type="button" class="btn btn-default"><span
                                            class="glyphicon glyphicon-pencil " title="Редактировать"></span></button>
                                <button type="button" class="btn btn-success"><span
                                            class="glyphicon glyphicon-save" title="Сохранить"></span></button>
                                <button type="button" class="btn btn-danger" ><span
                                            class="glyphicon glyphicon-remove" title="Удалить"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body"
                     v-if="block.builder_table == 'blok_html'">
                    <div class="form-group">
                        <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="4"
                                  placeholder="Введите свой код!"
                                  v-model="block.builder_id.code"></textarea>
                    </div>
                    <div v-html="block.builder_id.code"></div>
                </div>
            </div>
        </div>
    </div>
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
        <div>
            <div v-if="add_block_tag == 'h2'">
                <h2 :style="'color: ' + add_block_color"> {{add_block_title}} </h2>
            </div>
            <div v-if="add_block_tag == 'h3'">
                <h3 :style="'color: ' + add_block_color"> {{add_block_title}} </h3>
            </div>
            <div v-if="add_block_tag == 'h4'">
                <h4 :style="'color: ' + add_block_color"> {{add_block_title}} </h4>
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
  //блоки
  blocks: blocks,
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
},
methods: {
  add_block(){
    this.add_block_view = true;
  },
  new_block_html(){
    this.add_block_view = false;
    this.html_block_view = true;
  },
  html_block_save(){
    this.html_block_view = false;
    $.ajax({
         url: '/testbuilder/ajax/add-block-html',
         type: 'GET',
         data: 'page_id=' + this.page.id + '&title=' + this.add_block_title + '&title_head=' + this.add_block_tag + '&title_color=' + this.add_block_color + '&class=' + this.add_block_class + '&border=' + this.html_block_border + '&code=' + this.html_block_code,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         }
         });
  }
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
</style>
