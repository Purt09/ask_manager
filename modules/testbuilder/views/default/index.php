<?php

$this->title = Yii::t('app', 'PROJECTS');
$this->params['breadcrumbs'][] = $this->title;
use yii\helpers\Json;
?>

<div class="page" id="app">
    <div v-for="block in blocks">
        <div class="block">
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
            <div v-html="block.builder_id.code"></div>
        </div>
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
},
methods: {
    
  }




})

JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>