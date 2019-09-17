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
             :class="{container: !block.css_isContainer,hideBlock: block.isHide, mobile: !block.isMobile, tablet: !block.isTablet, desktop: !block.isDesktop}">
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

            <!--                Если блок ТЕКСТ!-->
            <div v-if="block.builder_table == 'block_text'"
                 class="block">
                <div :class="{html_block_border: block.builder_id.border == 1}">
                    {{block.builder_id.code}}
                </div>
            </div>
            <!--                Если блок COMMAND!-->
            <div v-if="block.builder_table == 'blok_command'"
                 class="block">
                <div class="row">
                    <div v-for="people in block.description">
                        <div :class="'col-sm-' + block.builder_id.col">
                            <!--                        Вертикальный дизайн-->
                            <div class="text-center"
                                 v-if="block.builder_id.design == 1">
                                <img :src="people.image" :alt="people.name"
                                     :style="'height: ' + people.image_h + 'px; width: ' + people.image_w + 'px; border-radius: ' + people.image_border">
                                <br>
                                <div class="people_name">
                                    {{people.name}}
                                </div>
                                <div class="people_content">
                                    {{people.content}}
                                </div>
                            </div>
                            <!--                        Горизонтальный-->
                            <div v-else>
                                <div class="col-sm-4 people_name_img">
                                    <img :src="people.image" :alt="people.name">
                                    <br>
                                    {{people.name}}
                                </div>
                                <div class="col-sm-8 people_content">
                                    {{people.content}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!--Если hr-->
            <div v-if="block.builder_table == 'hr'"
                 class="block">
                <button class="btn btn-default btn-xs"
                        @click="block_title_edit = index">
                    Настроить заголовк
                </button>
                <hr>
            </div>

            <!--            Если СПИСОК-->
            <div v-if="block.builder_table == 'block_list'"
                 class="block">
                <div class="row">
                    <div v-if="block.builder_id.design == 'С нумерацией'">
                        <ol :class="{list: block.builder_id.col == 2}">
                            <li v-for="item in block.description">
                                <label for="list"> {{item.title}}</label><br v-show="item.title != ''">
                                <span v-html="item.content"></span>
                            </li>
                        </ol>
                    </div>
                    <div v-if="block.builder_id.design == 'С точками'">
                        <ul :class="{list: block.builder_id.col == 2}">
                            <li v-for="item in block.description" v-html="item.content"></li>
                        </ul>
                    </div>
                    <div v-if="block.builder_id.design == 'С картинкой'">
                        <ul class="section-4__list ul-reset"
                            :class="{list: block.builder_id.col == 2}">
                            <li class="list__item"
                                v-for="item,indexI in block.description">
                                <div class="list__img-wrap"><img class="list__img" :src="item.image" :alt="item.title"
                                                                 loading="lazy"></div>
                                <span class="list__text" v-html="item.content"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div v-if="block.builder_table == 'block_list_table'"
                 class="block"">
                <div class="row"
                     v-if="block.builder_id.design == '4 столбца'">
                    <div class="col-sm-3 text-center">
                        <img :src="block.builder_id.image1" :alt="block.builder_id.text1">
                        <br>
                        {{block.builder_id.text1}}
                    </div>
                    <div class="col-sm-3 text-center">
                        <img :src="block.builder_id.image2" :alt="block.builder_id.text2">
                        <br>
                        {{block.builder_id.text2}}
                    </div>
                    <div class="col-sm-3 text-center">
                        <img :src="block.builder_id.image3" :alt="block.builder_id.text3">
                        <br>
                        {{block.builder_id.text3}}
                    </div>
                    <div class="col-sm-3 text-center">
                        <img :src="block.builder_id.image4" :alt="block.builder_id.text4">
                        <br>
                        {{block.builder_id.text4}}
                    </div>
                </div>
                <div class="row text-center"
                     v-if="block.builder_id.design == '5 столбцов'">
                    <div class="col-sm-five">
                        <img :src="block.builder_id.image1" :alt="block.builder_id.text1">
                        <br>
                        {{block.builder_id.text1}}
                    </div>
                    <div class="col-sm-five">
                        <img :src="block.builder_id.image2" :alt="block.builder_id.text2">
                        <br>
                        {{block.builder_id.text2}}
                    </div>
                    <div class="col-sm-five">
                        <img :src="block.builder_id.image3" :alt="block.builder_id.text3">
                        <br>
                        {{block.builder_id.text3}}
                    </div>
                    <div class="col-sm-five">
                        <img :src="block.builder_id.image4" :alt="block.builder_id.text4">
                        <br>
                        {{block.builder_id.text4}}
                    </div>
                    <div class="col-sm-five">
                        <img :src="block.builder_id.image5" :alt="block.builder_id.text5">
                        <br>
                        {{block.builder_id.text5}}
                    </div>
                </div>
                <div class="row text-center"
                     v-if="block.builder_id.design == '6 столбцов'">
                    <div class="col-sm-2">
                        <img :src="block.builder_id.image1" :alt="block.builder_id.text1">
                        <br>
                        {{block.builder_id.text1}}
                    </div>
                    <div class="col-sm-2">
                        <img :src="block.builder_id.image2" :alt="block.builder_id.text2">
                        <br>
                        {{block.builder_id.text2}}
                    </div>
                    <div class="col-sm-2">
                        <img :src="block.builder_id.image3" :alt="block.builder_id.text3">
                        <br>
                        {{block.builder_id.text3}}
                    </div>
                    <div class="col-sm-2">
                        <img :src="block.builder_id.image4" :alt="block.builder_id.text4">
                        <br>
                        {{block.builder_id.text4}}
                    </div>
                    <div class="col-sm-2">
                        <img :src="block.builder_id.image5" :alt="block.builder_id.text5">
                        <br>
                        {{block.builder_id.text5}}
                    </div>
                    <div class="col-sm-2">
                        <img :src="block.builder_id.image6" :alt="block.builder_id.text6">
                        <br>
                        {{block.builder_id.text6}}
                    </div>
                </div>
                <div class="row text-center"
                     v-if="block.builder_id.design == '6 блоков'">
                    <ul class="tiles ul-reset">
                        <li class="tiles__item tile">
                            <div class="tile__wrap">
                                <div class="tile__text">
                                    <div class="tile__title">{{block.builder_id.text1}}</div>
                                    <div class="tile__descr" v-html="block.builder_id.desc1"></div>
                                    <img class="tile__img" :src="block.builder_id.image1" :alt="block.builder_id.text1"
                                         loading="lazy"></div>
                        </li>
                        <li class="tiles__item tile">
                            <div class="tile__wrap">
                                <div class="tile__text">
                                    <div class="tile__title">{{block.builder_id.text2}}</div>
                                    <div class="tile__descr" v-html="block.builder_id.desc2"></div>
                                    <img class="tile__img" :src="block.builder_id.image2" :alt="block.builder_id.text2"
                                         loading="lazy"></div>
                        </li>
                        <li class="tiles__item tile">
                            <div class="tile__wrap">
                                <div class="tile__text">
                                    <div class="tile__title">{{block.builder_id.text3}}</div>
                                    <div class="tile__descr" v-html="block.builder_id.desc3"></div>
                                    <img class="tile__img" :src="block.builder_id.image3" :alt="block.builder_id.text3"
                                         loading="lazy"></div>
                        </li>
                        <li class="tiles__item tile">
                            <div class="tile__wrap">
                                <div class="tile__text">
                                    <div class="tile__title">block.builder_id.text4</div>
                                    <div class="tile__descr" v-html="block.builder_id.desc4"></div>
                                    <img class="tile__img" :src="block.builder_id.image4" :alt="block.builder_id.text4"
                                         loading="lazy"></div>
                        </li>
                        <li class="tiles__item tile">
                            <div class="tile__wrap">
                                <div class="tile__text">
                                    <div class="tile__title">{{block.builder_id.text5}}</div>
                                    <div class="tile__descr" v-html="block.builder_id.desc5"></div>
                                    <img class="tile__img" :src="block.builder_id.image5" :alt="block.builder_id.text5"
                                         loading="lazy"></div>
                        </li>
                        <li class="tiles__item tile">
                            <div class="tile__wrap">
                                <div class="tile__text">
                                    <div class="tile__title">{{block.builder_id.text6}}</div>
                                    <div class="tile__descr" v-html="block.builder_id.desc6"></div>
                                    <img class="tile__img" :src="block.builder_id.image6" :alt="block.builder_id.text6"
                                         loading="lazy"></div>
                        </li>
                    </ul>
                </div>
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
    @media (max-width: 480px) {
        .mobile {
            display: none;
        }
    }

    @media (min-width: 481px) and (max-width: 1024px) {
        .tablet {
            display: none;
        }
    }

    @media (min-width: 1025px) {
        .desktop {
            display: none;
        }
    }

    .hideBlock {
        display: none;
    }

    .html_block_border {
        padding: 45px 50px 20px;
        border: 2px solid #f60;
        margin-top: 2em;
    }
</style>
<script>
    <?= $page->js ?>

</script>