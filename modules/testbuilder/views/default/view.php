<?php

use yii\helpers\Json;

?>
<div class="page" id="app">
    <br> <br> <br>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li v-for="block in blocks">
                        <a :href="'#' + block.id"
                            v-if="block.isLink">{{block.link_title}}</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
    </nav>

    <section v-for="block,index in blocks"
             :class="{container: !block.css_isContainer}">
        <a :name="block.id"></a><br><br>
        <div :class="block.class"
             :style="'margin-top: ' + block.style_margin_top + 'px' + '; margin-bottom: ' + block.style_margin_bottom + 'px'">
            <div class="title block"
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

            <!--                Если блок HTML!-->
            <div class="block"
                 v-if="block.builder_table = 'html code'">
                <div v-html="block.builder_id.code"
                     :class="{html_block_border: block.builder_id.border == 1}"></div>

            </div>
        </div>
    </section>
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
  
},
});

JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>
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