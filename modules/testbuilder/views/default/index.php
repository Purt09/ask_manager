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
            <div v-html="block.builder_id.code"
                 :class="{html_block_border: block.builder_id.border == 1}"></div>
        </div>
    </div>
</div>
<style>
    <?= $page->style ?>
</style>
    <style>
        .html_block_border {
            padding: 45px 50px 20px;
            border: 2px solid #f60;
            margin-top: 2em;
        }
    </style>
    <script>
        <?= $page->js ?>

    </script>

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