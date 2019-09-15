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
                    <li v-for="block,index in blocks"
                        v-if="block.isLink == 1">
                        <a :href="'#' + block.id"
                           v-if="menu_title_edit != index"
                           @click="menu_title_edit = index">
                            {{block.link_title}}
                        </a>
                        <div class="input-group col-sm-2 input-group-sm"
                             v-if="menu_title_edit == index">
                            <span class="input-group-btn">
                                <button class="btn btn-success"
                                        @click="menu_link_title_edit(index)">
                                    <span class="glyphicon glyphicon-ok " title="Сохранить"></span>
                                </button>
                             </span>
                            <input type="text" v-model="block.link_title" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-danger"
                                        @click="menu_title_edit = 999">
                                    <span class="glyphicon glyphicon-remove " title="Удалить"></span>
                                </button>
                            </span>
                        </div>

                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>


    <!--    Окно редакттрования страницы-->
    <modal class="modal"
           v-if="page_cog" @close="showModal = false">
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
             :class="{container: !block.css_isContainer,hideBlock: block.isHide}"
             :style="'background-color: #' + block.css_background">
        <a :name="block.id"></a><br><br>
        <div :class="block.class"
             :style="'margin-top: ' + block.style_margin_top + 'px' + '; margin-bottom: ' + block.style_margin_bottom + 'px'">
            <button class="btn btn-default btn-xs"
                    @click="block_title_edit = index"
                    v-if="block.title == ''">
                Настроить заголовк
            </button>
            <div class="title block"
                 v-if="block_title_edit != index"
                 @click="block_block_block_edit_title(index)"
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
                 v-if="block_title_edit == index">
                <div class="col-sm-2 block_no_hover">
                    <input type="text" class="form-control" placeholder="Заголовок"
                           v-model="block.title">
                </div>
                <div class="col-sm-1">
                    <input type="text" class="form-control" placeholder="Тег"
                           v-model="block.title_head">
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                            <span class="input-group-addon"
                                  :style="'background: #' + block.title_color"></span>
                        <input type="text" class="form-control" placeholder="Цвет"
                               v-model="block.title_color">
                        <span class="input-group-addon">
                                <input type="checkbox" v-model="block.isMobile">
                                <span class="glyphicon glyphicon-earphone" title="Мобильный"></span>
                            </span>
                        <span class="input-group-addon">
                                <input type="checkbox" v-model="block.isTablet">
                                <span class="glyphicon glyphicon-phone" title="Планшет"></span>
                            </span>
                        <span class="input-group-addon">
                                <input type="checkbox" v-model="block.isDesktop">
                                <span class="glyphicon glyphicon-hdd" title="Компьютер"></span>
                            </span>
                        <span class="input-group-addon">
                                <input type="checkbox" v-model="block.isHide">
                                <span class="glyphicon glyphicon-search" title="Спрятать блок?"></span>
                            </span>
                    </div>
                </div>
                <div class="col-sm-5 text-right">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default"
                                @click="block_position_down(index)"
                                v-if="index != blocks.length - 1"><span
                                    class="glyphicon glyphicon-arrow-down" title="Вниз"></span></button>
                        <button type="button" class="btn btn-default"
                                @click="block_position_up(index)"
                                v-if="index != 0"><span
                                    class="glyphicon glyphicon-arrow-up" title="Вверх"></span></button>
                        <button type="button" class="btn btn-default"
                                @click="block_block_duplicate(index)"><span
                                    class="glyphicon glyphicon-file" title="Дублировать"></span></button>
                        <button type="button" class="btn btn-default"
                                @click="block_block_edit(index)"><span
                                    class="glyphicon glyphicon-pencil " title="Редактировать"></span></button>
                        <button type="button" class="btn btn-danger"
                                @click="block_block_delete(index)"><span
                                    class="glyphicon glyphicon-remove" title="Удалить"></span>
                        </button>
                        <button class="btn btn-success" type="button"
                                @click="block_block_save_title(index)"><span class="glyphicon glyphicon-ok"
                                                                             title="Сохранить"></span> Сохранить
                        </button>
                        <button class="btn btn-warning" type="button"
                                @click="block_title_edit = 999"><span
                                    class="glyphicon glyphicon-remove" title="Закрыть"></span> Закрыть
                        </button>
                    </div>

                    <!--    Окно редактирования блока-->
                    <modal v-if="(block_block_edit_modal == index) && (showModal)" @close="showModal = false"
                           class="modal">
                        <h3 slot="header">Изменить блок</h3>
                        <div slot="body">
                            <div class="block_new_add mt-2 bg-light shadow-sm p-2">
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
                                    <span class="input-group-addon">
                                        <input type="checkbox"
                                               v-model="block.isHide">
                                        Спрятать блок
                                    </span>
                                    <span class="input-group-addon">
                                        <input type="checkbox"
                                               v-model="block.isDesktop">
                                        Компьюторы
                                    </span>
                                    <span class="input-group-addon">
                                        <input type="checkbox"
                                               v-model="block.isTablet">
                                        Планшеты
                                    </span>
                                    <span class="input-group-addon">
                                        <input type="checkbox"
                                               v-model="block.isMobile">
                                        Смартфоны
                                    </span>
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
                                    <div class="input-group">
                                        <span class="input-group-addon"> Цвет фона:</span>
                                        <input type="text" class="form-control" placeholder="Цвет фона"
                                               v-model="block.css_background">
                                        <span class="input-group-addon"
                                              :style="'background: #' + block.css_background"></span>
                                    </div>
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
                                    @click="block_block_save_data(index)">
                                Сохранить
                            </button>
                        </div>
                        <div slot="footer">
                            <button class="btn btn-danger"
                                    @click="modal_close()"> Закрыть
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
                <button class="btn btn-default btn-xs"
                        @click="prev_html = index"
                        v-show="block.builder_id.code == ''">
                    Редактировать html блок
                </button>
                <div class="form-group" v-if="prev_html == index">
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
            <!--                Если блок ТЕКСТ!-->
            <div v-if="block.builder_table == 'block_text'"
                 class="block">
                <div v-if="prev_html != index"
                     @click="prev_html = index"
                     :class="{html_block_border: block.builder_id.border == 1}">
                    {{block.builder_id.code}}
                </div>
                <button class="btn btn-default btn-xs"
                        @click="prev_html = index"
                        v-show="block.builder_id.code == ''">
                    Редактировать текстовый блок
                </button>
                <div class="form-group" v-if="prev_html == index">
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

            <!--                Если блок COMMAND!-->
            <button class="btn btn-default btn-xs"
                    @click="block_command_edit(index)"
                    v-show="((block.builder_table == 'block_command') && (block.description == ''))">
                Редактировать команду блок
            </button>
            <div v-if="block.builder_table == 'block_command'"
                 class="block"
                 @click="block_command_edit(index)">
                <div class="row">
                    <div v-for="people in block.description"
                         v-show="people.commands_id == block.builder_id.id">
                        <div :class="'col-sm-' + block.builder_id.col">
                            <!--                        Вертикальный дизайн-->
                            <div class="text-center"
                                 v-if="block.builder_id.design == 1">
                                <img :src="people.image" :alt="people.name"
                                     :style="'height: ' + people.image_h + 'px; width: ' + people.image_w + 'px; border-radius: ' + people.image_border">
                                <br>
                                <div class="people_name text-center">
                                    {{people.name}}
                                </div>
                                <div class="people_content" v-html="people.content">
                                </div>
                            </div>
                            <!--                        Горизонтальный-->
                            <div v-else>
                                <div class="people_name_img text-center"
                                     :class="'col-sm-' + block.builder_id.gor_col_image">
                                    <div class="people_name">
                                        <img :src="people.image" :alt="people.name"
                                             :style="'height: ' + people.image_h + 'px; width: ' + people.image_w + 'px; border-radius: ' + people.image_border">
                                        <br>
                                        {{people.name}}
                                    </div>
                                </div>
                                <div class=" people_content"
                                     :class="'col-sm-' + block.builder_id.gor_col_content"
                                     v-html="people.content">
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

            <!--    Окно редактирования COMMAND-->
            <modal v-if="modal_command_people == index"
                   class="modal"
                   @close="modal_command_people = false">
                <h3 slot="header">Изменение команды и добавление участника</h3>
                <div slot="body">
                    <div class="panel panel-default">
                        <div class="panel-heading">Настройки команды:</div>
                        <div class="panel-body">
                            <label for="sel1">Выберите дизайн: </label>
                            <select class="form-control"
                                    v-model="block.builder_id.design">
                                <option>Вертикальный</option>
                                <option>Горизонтальный</option>
                            </select>
                            <label for="sel1">Количество столбцов: </label>
                            <select class="form-control"
                                    v-model="block.builder_id.col">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>6</option>
                            </select>
                            <div class="input-group"
                                 v-if="block.builder_id.design == 'Горизонтальный'">
                                <span class="input-group-addon"><strong>Соотношение картинки к тексту:</strong></span>
                                <input type="text" class="form-control" placeholder="сверху"
                                       v-model="block.builder_id.gor_col_image">
                                <span class="input-group-addon"> к </span>
                                <input type="text" class="form-control" placeholder="сверху"
                                       v-model="block.builder_id.gor_col_content">
                                <span class="input-group-addon"> (сумма должна быть 12) </span>
                            </div>
                            <button class="btn btn-success m-2"
                                    @click="block_command_data_save(index)">
                                Сохранить
                            </button>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Редактирование:</div>
                        <div class="panel-body">
                            <div class="panel panel-default"
                                 v-for="people,indexP in block.description"
                                 v-show="people.commands_id == block.builder_id.id">
                                <div class="panel-heading">
                                    <div class="row p-1">
                                        <div class="col-sm-11">
                                            {{people.name}}:
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="text-right">
                                                <button class="btn btn-danger btn-xs"
                                                        @click="block_command_delete_people(indexP, index)">
                                                    <span class="glyphicon glyphicon-remove " title="Удалить"></span>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" placeholder="Имя"
                                               v-model="people.name"><br>
                                    </div>
                                    <div class="col-sm-6">
                                        <textarea class="form-control rounded-0" id="exampleFormControlTextarea1"
                                                  rows="4"
                                                  placeholder="Текст"
                                                  v-model="people.content">
                                        </textarea>
                                    </div>
                                    <div class="input-group col-sm-12 p-2">
                                        <span class="input-group-addon"><strong>Картинка:</strong></span>
                                        <input type="text" class="form-control" placeholder="Путь к картинке"
                                               v-model="people.image">
                                        <span class="input-group-addon">Высота:</span>
                                        <input type="text" class="form-control" placeholder="Высота"
                                               v-model="people.image_h">
                                        <span class="input-group-addon">Ширина:</span>
                                        <input type="text" class="form-control" placeholder="Ширина"
                                               v-model="people.image_w">
                                        <span class="input-group-addon">Округление:</span>
                                        <input type="text" class="form-control" placeholder="border"
                                               v-model="people.image_border">
                                    </div>
                                    <button class="btn btn-success m-2"
                                            @click="block_command_people_save(indexP,index)">
                                        Сохранить!
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Добавить пользователя:</div>
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" placeholder="Имя"
                                               v-model="command_add_name"><br>
                                    </div>
                                    <div class="col-sm-6">
                                    <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="4"
                                              placeholder="Текст"
                                              v-model="command_add_content">
                                    </textarea>
                                    </div>
                                    <div class="input-group col-sm-12">
                                        <span class="input-group-addon"><strong>Картинка:</strong></span>
                                        <input type="text" class="form-control" placeholder="Путь к картинке"
                                               v-model="command_add_image">
                                        <span class="input-group-addon">Высота:</span>
                                        <input type="text" class="form-control" placeholder="Высота"
                                               v-model="command_add_image_h">
                                        <span class="input-group-addon">Ширина:</span>
                                        <input type="text" class="form-control" placeholder="Ширина"
                                               v-model="command_add_image_w">
                                        <span class="input-group-addon">Округление:</span>
                                        <input type="text" class="form-control" placeholder="border"
                                               v-model="command_add_image_border">
                                    </div>
                                    <button class="btn btn-success m-2"
                                            @click="block_people_add_in_command(block.builder_id.id)">
                                        Добавить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div slot="footer">
                    <button class="btn btn-danger"
                            @click="modal_close()"> Закрыть
                    </button>
                </div>
            </modal>

            <!--            Если СПИСОК-->
            <div v-if="block.builder_table == 'block_list'"
                 class="block"
                 @click="block_command_edit(index)">
                <div class="row">
                    <div v-if="block.builder_id.design == 'С нумерацией'"
                         @click="modal_list = index">
                        <ol :class="{list: block.builder_id.col == 2}">
                            <li v-for="item in block.description">
                                <label for="list"> {{item.title}}</label><br v-show="item.title != ''">
                                <span v-html="item.content"></span>
                            </li>
                        </ol>
                    </div>
                    <div v-if="block.builder_id.design == 'С точками'"
                         @click="modal_list = index">
                        <ul :class="{list: block.builder_id.col == 2}">
                            <li v-for="item in block.description" v-html="item.content"></li>
                        </ul>
                    </div>
                    <div v-if="block.builder_id.design == 'С картинкой'"
                         @click="modal_list = index">
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
                    <button class="btn btn-default btn-xs"
                            @click="modal_list = index"
                            v-if="block.description == ''">
                        Добавить пункт
                    </button>
                </div>
            </div>
            <!--            Окно редакттирования списка-->
            <modal v-if="modal_list == index"
                   class="modal"
                   @close="modal_list != index">
                <h3 slot="header">Изменение списка и добавление пунктов</h3>
                <div slot="body">
                    <div class="panel panel-default">
                        <div class="panel-heading">Настройки списка:</div>
                        <div class="panel-body">
                            <label for="sel1">Выберите тип: </label>
                            <select class="form-control"
                                    v-model="block.builder_id.design">
                                <option>С нумерацией</option>
                                <option>С точками</option>
                                <option>С картинкой</option>
                            </select>
                            <label for="sel1">Количество столбцов: </label>
                            <select class="form-control"
                                    v-model="block.builder_id.col">
                                <option>1</option>
                                <option>2</option>
                            </select>
                            <button class="btn btn-success m-2"
                                    @click="block_list_save(index)">
                                Сохранить
                            </button>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Редактирование:</div>
                        <div class="panel-body">
                            <div class="panel panel-default"
                                 v-for="item,indexI in block.description"
                                 v-show="item.list_id == block.builder_id.id">
                                <div class="panel-heading">
                                    <div class="row p-1">
                                        <div class="col-sm-11">
                                            {{item.id}}:
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="text-right">
                                                <button class="btn btn-danger btn-xs"
                                                        @click="block_list_item_delete(indexI, index)">
                                                    <span class="glyphicon glyphicon-remove " title="Удалить"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-sm-6">
                                        <textarea class="form-control rounded-0"
                                                  id="exampleFormControlTextarea1"
                                                  rows="4"
                                                  placeholder="Текст"
                                                  v-model="item.content">
                                        </textarea>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" placeholder="Имя"
                                               v-show="block.builder_id.design == 'С нумерацией'"
                                               v-model="item.title"><br>
                                        <div class="input-group p-2"
                                             v-show="block.builder_id.design == 'С картинкой'">
                                            <span class="input-group-addon"><strong>Картинка:</strong></span>
                                            <input type="text" class="form-control" placeholder="Путь к картинке"
                                                   v-model="item.image">
                                        </div>
                                    </div>
                                    <button class="btn btn-success m-2"
                                            @click="block_list_item_save(indexI,index)">
                                        Сохранить!
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Добавить пункт:</div>
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="col-sm-6">
                                    <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="4"
                                              placeholder="Текст"
                                              v-model="list_add_item_content">
                                    </textarea>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" placeholder="Жирный шрифт в начале"
                                               v-model="list_add_item_title"
                                               v-show="block.builder_id.design == 'С нумерацией'"><br>
                                        <div class="input-group"
                                             v-show="block.builder_id.design == 'С картинкой'">
                                            <span class="input-group-addon"><strong>Картинка:</strong></span>
                                            <input type="text" class="form-control" placeholder="Путь к картинке"
                                                   v-model="list_add_item_image">
                                        </div>
                                    </div>
                                    <button class="btn btn-success m-2"
                                            @click="block_list_item_add_in_list(block.builder_id.id)">
                                        Добавить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div slot="footer">
                    <button class="btn btn-danger"
                            @click="modal_close()"> Закрыть
                    </button>
                </div>
            </modal>


            <div v-if="block.builder_table == 'block_list_table'"
                 class="block"
                 @click="block_advantages_edit(index)">
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
                <button class="btn btn-default btn-xs"
                        @click="modal_advantages = index"
                        v-if="block.builder_id.text1 == ''">
                    Редактировать преимущества
                </button>
            </div>
            <!--            Окно редактирования преимуществ-->
            <modal v-if="modal_advantages == index"
                   class="modal"
                   @close="modal_advantages != index">
                <h3 slot="header">Редактирование преимуществ</h3>
                <div slot="body">
                    <div class="panel panel-default">
                        <div class="panel-heading">Настройки преимуществ:</div>
                        <div class="panel-body">
                            <select class="form-control" id="type"
                                    v-model="block.builder_id.design">
                                <option>4 столбца</option>
                                <option>5 столбцов</option>
                                <option>6 столбцов</option>
                                <option>6 блоков</option>
                            </select> <br>
                            <div class="input-group">
                                <span class="input-group-addon">Картикна:</span>
                                <input type="text" class="form-control" placeholder="Адресс картинки"
                                       v-model="block.builder_id.image1">
                                <span class="input-group-addon">Текст:</span>
                                <input type="text" class="form-control" placeholder="Текст"
                                       v-model="block.builder_id.text1">
                            </div>
                            <div class="input-group mt-2" v-if="block.builder_id.design == '6 блоков'">
                                <span class="input-group-addon">Описание:</span>
                                <input type="text" class="form-control" placeholder="Текст"
                                       v-model="block.builder_id.desc1">
                            </div>
                            <hr>
                            <div class="input-group">
                                <span class="input-group-addon">Картикна:</span>
                                <input type="text" class="form-control" placeholder="Адресс картинки"
                                       v-model="block.builder_id.image2">
                                <span class="input-group-addon">Текст:</span>
                                <input type="text" class="form-control" placeholder="Текст"
                                       v-model="block.builder_id.text2">
                            </div>
                            <div class="input-group mt-2" v-if="block.builder_id.design == '6 блоков'">
                                <span class="input-group-addon">Описание:</span>
                                <input type="text" class="form-control" placeholder="Текст"
                                       v-model="block.builder_id.desc2">
                            </div>
                            <hr>
                            <div class="input-group">
                                <span class="input-group-addon">Картикна:</span>
                                <input type="text" class="form-control" placeholder="Адресс картинки"
                                       v-model="block.builder_id.image3">
                                <span class="input-group-addon">Текст:</span>
                                <input type="text" class="form-control" placeholder="Текст"
                                       v-model="block.builder_id.text3">
                            </div>
                            <div class="input-group mt-2" v-if="block.builder_id.design == '6 блоков'">
                                <span class="input-group-addon">Описание:</span>
                                <input type="text" class="form-control" placeholder="Текст"
                                       v-model="block.builder_id.desc3">
                            </div>
                            <hr>
                            <div class="input-group">
                                <span class="input-group-addon">Картикна:</span>
                                <input type="text" class="form-control" placeholder="Адресс картинки"
                                       v-model="block.builder_id.image4">
                                <span class="input-group-addon">Текст:</span>
                                <input type="text" class="form-control" placeholder="Текст"
                                       v-model="block.builder_id.text4">
                            </div>
                            <div class="input-group mt-2" v-if="block.builder_id.design == '6 блоков'">
                                <span class="input-group-addon">Описание:</span>
                                <input type="text" class="form-control" placeholder="Текст"
                                       v-model="block.builder_id.desc4">
                            </div>
                            <hr>
                            <div class="input-group"
                                 v-show="block.builder_id.design != '4 столбца'">
                                <span class="input-group-addon">Картикна:</span>
                                <input type="text" class="form-control" placeholder="Адресс картинки"
                                       v-model="block.builder_id.image5">
                                <span class="input-group-addon">Текст:</span>
                                <input type="text" class="form-control" placeholder="Текст"
                                       v-model="block.builder_id.text5">
                            </div>
                            <div class="input-group mt-2" v-if="block.builder_id.design == '6 блоков'">
                                <span class="input-group-addon">Описание:</span>
                                <input type="text" class="form-control" placeholder="Текст"
                                       v-model="block.builder_id.desc5">
                            </div>
                            <hr>
                            <div class="input-group"
                                 v-show="((block.builder_id.design == '6 блоков') || (block.builder_id.design == '6 столбцов'))">
                                <span class="input-group-addon">Картикна:</span>
                                <input type="text" class="form-control" placeholder="Картинка"
                                       v-model="block.builder_id.image6">
                                <span class="input-group-addon">Текст:</span>
                                <input type="text" class="form-control" placeholder="Текст"
                                       v-model="block.builder_id.text6">
                            </div>
                            <div class="input-group mt-2" v-if="block.builder_id.design == '6 блоков'">
                                <span class="input-group-addon">Описание:</span>
                                <input type="text" class="form-control" placeholder="Текст"
                                       v-model="block.builder_id.desc6">
                            </div>
                            <br>
                            <button class="btn btn-success m-2"
                                    @click="block_advantages_save(index)">
                                Сохранить
                            </button>
                        </div>
                    </div>
                    >
                </div>
                <div slot="footer">
                    <button class="btn btn-danger"
                            @click="modal_close()"> Закрыть
                    </button>
                </div>
            </modal>
        </div>
    </section>


    <!--    Новый блок!-->
    <div class="bg-light text-center p-3 bg_block_new_add container"
         @click="block_new_add()">
        <span class="glyphicon glyphicon-plus"></span>
    </div>


    <!--    Окно добавления нового блока-->
    <modal class="modal"
           v-if="(showModal) && (block_add_modal)" @close="showModal = false">
        <h3 slot="header">Добавить блок</h3>
        <div slot="body">
            <div class="block_new_add mt-2 bg-light shadow-sm p-2"
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
                        @click="block_html_add()">
                    HTML
                </button>
                <button class="btn btn-default m-2"
                        @click="block_text_add()">
                    Текст
                </button>
                <button class="btn btn-default m-2"
                        @click="block_command_add()">
                    Команда
                </button>
                <button class="btn btn-default m-2"
                        @click="block_list_view()">
                    Список
                </button>
                <button class="btn btn-default m-2"
                        @click="block_hr_add()">
                    Полоска
                </button>
                <button class="btn btn-default m-2"
                        @click="block_advantages_view()">
                    Преимущества
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
                    <h3>Настройки команды:</h3>
                    <div class="form-group">
                        <label for="sel1">Выберите дизайн:</label>
                        <select class="form-control" id="sel1"
                                v-model="command_add_design">
                            <option>Вертикальный</option>
                            <option>Горизонтальный</option>
                        </select>
                        <label for="sel1">Количество столбцов:</label>
                        <select class="form-control" id="sel1"
                                v-model="command_add_col_sm">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>6</option>
                        </select>
                        <div class="input-group"
                             v-if="command_add_design == 'Горизонтальный'">
                            <span class="input-group-addon"><strong>Соотношение картинки к тексту:</strong></span>
                            <input type="text" class="form-control" placeholder="сверху"
                                   v-model="command_add_gor_col_image">
                            <span class="input-group-addon"> к </span>
                            <input type="text" class="form-control" placeholder="сверху"
                                   v-model="command_add_gor_col_content">
                            <span class="input-group-addon"> (сумма должна быть 12) </span>
                        </div>
                    </div>
                    <h3>Добавить человека:</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" placeholder="Имя"
                                   v-model="command_add_name"><br>
                        </div>
                        <div class="col-sm-6">
                    <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="4"
                              placeholder="Текст"
                              v-model="command_add_content"></textarea>
                        </div>
                        <br>

                        <div class="input-group col-sm-12">
                            <span class="input-group-addon"><strong>Картинка:</strong></span>
                            <input type="text" class="form-control" placeholder="Путь к картинке"
                                   v-model="command_add_image">
                            <span class="input-group-addon">Высота:</span>
                            <input type="text" class="form-control" placeholder="Высота"
                                   v-model="command_add_image_h">
                            <span class="input-group-addon">Ширина:</span>
                            <input type="text" class="form-control" placeholder="Ширина"
                                   v-model="command_add_image_w">
                            <span class="input-group-addon">Округление:</span>
                            <input type="text" class="form-control" placeholder="border"
                                   v-model="command_add_image_border">
                        </div>


                    </div>
                </div>
                <button class="btn btn-success"
                        @click="block_command_save()">
                    Добавить
                </button>
            </div>

            <!--    Добавление блока СПИСОК-->
            <div class="bg-light mt-3 p-4"
                 v-show="modal_add_list">
                Вид списка: <br>
                <select class="form-control" id="type"
                        v-model="block_list_design">
                    <option>С нумерацией</option>
                    <option>С точками</option>
                    <option>С картинкой</option>
                </select>
                <br>
                Количество столбцов: <br>
                <select class="form-control" id="pillar"
                        v-model="block_list_pillar">
                    <option>1</option>
                    <option>2</option>
                </select> <br>
                <button class="btn btn-default"
                        @click="block_list_add()">
                    Создать
                </button>

            </div>

            <!--    Добавление блока ПРЕИМУЩЕСТВА-->
            <div class="bg-light mt-3 p-4"
                 v-show="modal_add_advantages">
                Вид блока преимуществ: <br>
                <select class="form-control" id="type"
                        v-model="block_advantages_design">
                    <option>4 столбца</option>
                    <option>5 столбцов</option>
                    <option>6 столбцов</option>
                    <option>6 блоков</option>
                </select> <br>
                <div class="input-group">
                    <span class="input-group-addon">Картикна:</span>
                    <input type="text" class="form-control" placeholder="Адресс картинки"
                           v-model="advantages_1_add_image">
                    <span class="input-group-addon">Текст:</span>
                    <input type="text" class="form-control" placeholder="Текст"
                           v-model="advantages_1_add_text">
                </div>
                <div class="input-group mt-2" v-if="block_advantages_design == '6 блоков'">
                    <span class="input-group-addon">Описание:</span>
                    <input type="text" class="form-control" placeholder="Описание"
                           v-model="advantages_1_add_desc">
                </div>
                <hr>
                <div class="input-group">
                    <span class="input-group-addon">Картикна:</span>
                    <input type="text" class="form-control" placeholder="Адресс картинки"
                           v-model="advantages_2_add_image">
                    <span class="input-group-addon">Текст:</span>
                    <input type="text" class="form-control" placeholder="Текст"
                           v-model="advantages_2_add_text">
                </div>
                <div class="input-group mt-2" v-if="block_advantages_design == '6 блоков'">
                    <span class="input-group-addon">Описание:</span>
                    <input type="text" class="form-control" placeholder="Описание"
                           v-model="advantages_2_add_desc">
                </div>
                <hr>
                <div class="input-group">
                    <span class="input-group-addon">Картикна:</span>
                    <input type="text" class="form-control" placeholder="Адресс картинки"
                           v-model="advantages_3_add_image">
                    <span class="input-group-addon">Текст:</span>
                    <input type="text" class="form-control" placeholder="Текст"
                           v-model="advantages_3_add_text">
                </div>
                <div class="input-group mt-2" v-if="block_advantages_design == '6 блоков'">
                    <span class="input-group-addon">Описание:</span>
                    <input type="text" class="form-control" placeholder="Описание"
                           v-model="advantages_3_add_desc">
                </div>
                <hr>
                <div class="input-group">
                    <span class="input-group-addon">Картикна:</span>
                    <input type="text" class="form-control" placeholder="Адресс картинки"
                           v-model="advantages_4_add_image">
                    <span class="input-group-addon">Текст:</span>
                    <input type="text" class="form-control" placeholder="Текст"
                           v-model="advantages_4_add_text">
                </div>
                <div class="input-group mt-2" v-if="block_advantages_design == '6 блоков'">
                    <span class="input-group-addon">Описание:</span>
                    <input type="text" class="form-control" placeholder="Описание"
                           v-model="advantages_4_add_desc">
                </div>
                <hr>
                <div class="input-group"
                     v-show="block_advantages_design != '4 столбца'">
                    <span class="input-group-addon">Картикна:</span>
                    <input type="text" class="form-control" placeholder="Адресс картинки"
                           v-model="advantages_5_add_image">
                    <span class="input-group-addon">Текст:</span>
                    <input type="text" class="form-control" placeholder="Текст"
                           v-model="advantages_5_add_text">
                </div>
                <div class="input-group mt-2" v-if="block_advantages_design == '6 блоков'">
                    <span class="input-group-addon">Описание:</span>
                    <input type="text" class="form-control" placeholder="Описание"
                           v-model="advantages_5_add_desc">
                </div>
                <hr>
                <div class="input-group"
                     v-show="((block_advantages_design == '6 блоков') || (block_advantages_design == '6 столбцов'))">
                    <span class="input-group-addon">Картикна:</span>
                    <input type="text" class="form-control" placeholder="Картинка"
                           v-model="advantages_6_add_image">
                    <span class="input-group-addon">Текст:</span>
                    <input type="text" class="form-control" placeholder="Текст"
                           v-model="advantages_6_add_text">
                </div>
                <div class="input-group mt-2" v-if="block_advantages_design == '6 блоков'">
                    <span class="input-group-addon">Описание:</span>
                    <input type="text" class="form-control" placeholder="Описание"
                           v-model="advantages_6_add_desc">
                </div>
                <hr>
                <br>
                <button class="btn btn-success"
                        @click="block_advantages_add()">
                    Создать
                </button>

            </div>
        </div>
        <div slot="footer">
            <button class="btn btn-danger"
                    @click="modal_close()"> Закрыть
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
  block_block_edit_modal: 999,
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
      //добавление блока команда:
      command_add_design: 'Вертикальный',
      command_add_col_sm: 1,
      command_add_name: '',
      command_add_content: '',
      command_add_image: '',
      command_add_image_h: 50,
      command_add_image_w: 50,
      command_add_image_border: '0px 0px 0px 0px',
      command_add_gor_col_content: 8,
      command_add_gor_col_image: 4,
      //Редактирование команды:
      modal_command_people: 999,
      
      // блок список
      modal_add_list: false,
      block_list_design: 'С нумерацией',
      block_list_pillar: 1,
      // Добавление пункта!
      list_add_item_title: '',
      list_add_item_content: '',
      list_add_item_image: '',
      //Модальное окно редактироания
      modal_list: 999,
      
      // блок преимущества
      modal_add_advantages: false,
      block_advantages_design: '4 столбца',
      advantages_1_add_image: '',
      advantages_2_add_image: '',
      advantages_3_add_image: '',
      advantages_4_add_image: '',
      advantages_5_add_image: '',
      advantages_6_add_image: '',
      advantages_1_add_text: '',
      advantages_2_add_text: '',
      advantages_3_add_text: '',
      advantages_4_add_text: '',
      advantages_5_add_text: '',
      advantages_6_add_text: '',
      advantages_1_add_desc: '',
      advantages_2_add_desc: '',
      advantages_3_add_desc: '',
      advantages_4_add_desc: '',
      advantages_5_add_desc: '',
      advantages_6_add_desc: '',
      
      //редактирование преимуществ
      modal_advantages: 999,
      
      
  showModal: false,
  
  //menu
  menu_title_edit: 999,
},
methods: {
    block_block_block_edit_title(index){
      this.block_title_edit = index;
    },
    block_block_save_title(index) {
      this.block_title_edit = 999;
      $.ajax({
         url: '/testbuilder/ajax/block-save-title',
         type: 'GET',
         data: 'id=' + blocks[index].id + '&title=' + blocks[index].title + '&title_h=' + blocks[index].title_head + '&title_color=' + blocks[index].title_color + '&isH=' + this.blocks[index].isHide + '&isD=' + this.blocks[index].isDesktop + '&isT=' + this.blocks[index].isTablet + '&isM=' + this.blocks[index].isMobile,
         success: function(){
           console.log( blocks[index].id + 'success push');
         },
         error: function(){
         }
         });
    },
    block_block_duplicate(index){
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
    block_block_delete(index){
      $.ajax({
         url: '/testbuilder/ajax/block-delete',
         type: 'GET',
         data: 'id=' + blocks[index].id + '&page_id=' + this.page.id,
         success: function(){
           console.log( blocks[index].id + 'success push');
         },
         error: function(){
         }
         });
    },
    block_position_up(index){
      var pos1 = blocks[index].position;
      var pos2 = blocks[index - 1].position;
      this.block_save_pos(pos1, pos2);
    },
    block_position_down(index){
      var pos1 = blocks[index].position;
      var pos2 = blocks[index + 1].position;
      this.block_save_pos(pos1, pos2);
    },
    block_save_pos(pos1, pos2){
      $.ajax({
         url: '/testbuilder/ajax/block-save-pos',
         type: 'GET',
         data: 'pos1=' + pos1 + '&pos2=' + pos2,
         success: function(){
           console.log( pos1 + ' success push ' + pos2 );
         },
         error: function(){
         }
         });
    },
     block_block_edit(index){
      this.showModal = true;
      this.block_block_edit_modal = index;
    },
    block_block_save_data(index){
      this.block_title_edit = 999;
      this.modal_close();
    $.ajax({
         url: '/testbuilder/ajax/block-save-data',
         type: 'GET',
         data: 'page_id=' + this.page.id + '&title=' + this.blocks[index].title + '&title_head=' + this.blocks[index].title_head + '&title_color=' + this.blocks[index].title_color + '&class=' + this.blocks[index].class + '&id=' + this.blocks[index].id + '&mt=' + this.blocks[index].style_margin_top + '&mb=' + this.blocks[index].style_margin_bottom + '&isCont=' + this.blocks[index].css_isContainer + '&isLink=' + this.blocks[index].isLink + '&link_title=' + this.blocks[index].link_title + '&isH=' + this.blocks[index].isHide + '&isD=' + this.blocks[index].isDesktop + '&isT=' + this.blocks[index].isTablet + '&isM=' + this.blocks[index].isMobile + '&css_background=' + this.blocks[index].css_background,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         }
         });
  },
  
  
    // HTML
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
    block_html_create(){
      this.modal_close();
    $.ajax({
         url: '/testbuilder/ajax/block-html-add',
         type: 'GET',
         data: 'page_id=' + this.page.id + '&title=' + this.block_add_title + '&title_head=' + this.block_add_tag + '&title_color=' + this.block_add_color + '&class=' + this.block_add_class + '&code=' + this.html_block_create_code + '&border=' + this.html_block_create_border,
         success: function(){
           console.log( 'success push');
         },
         error: function(){
         }
         });
  },
  block_text_add(){
      this.modal_close();
      $.ajax({
         url: '/testbuilder/ajax/block-text-add',
         type: 'GET',
         data: 'page_id=' + this.page.id + '&title=' + this.block_add_title + '&title_head=' + this.block_add_tag + '&title_color=' + this.block_add_color + '&class=' + this.block_add_class + '&code=' + 'Новый текстовый блок' + '&border=' + this.html_block_create_border,
         success: function(){
           console.log( 'success push');
         },
         error: function(){
         }
         });
  },
  
   
  
  //команда
  block_command_add(){
      this.command_block_modal = true;
      this.block_add_view = false;
  },
  block_command_save(){
      $.ajax({
         url: '/testbuilder/ajax/block-commands-add',
         type: 'GET',
         data: 'page_id=' + this.page.id + '&command_design=' + this.command_add_design + '&command_col=' + this.command_add_col_sm + '&people_name=' + this.command_add_name + '&p_image=' + this.command_add_image + '&p_image_h=' + this.command_add_image_h + '&p_image_w=' + this.command_add_image_w + '&p_image_b=' + this.command_add_image_border + '&title=' + this.block_add_title + '&title_head=' + this.block_add_tag + '&title_color=' + this.block_add_color + '&class=' + this.block_add_class + '&col_content=' + this.command_add_gor_col_content + '&col_image=' + this.command_add_gor_col_image,
         success: function(){
           console.log('success push');
         },
         error: function(){
         }
         });
  },
  block_command_edit(index){
      this.modal_command_people = index;
  },
  block_people_add_in_command(id){
      $.ajax({
         url: '/testbuilder/ajax/block-people-add-in-command',
         type: 'GET',
         data: 'page_id=' + this.page.id + '&people_name=' + this.command_add_name + '&p_image=' + this.command_add_image + '&p_image_h=' + this.command_add_image_h + '&p_image_w=' + this.command_add_image_w + '&p_image_b=' + this.command_add_image_border + '&content=' + this.command_add_content + '&command_id=' + id,
         success: function(){
           console.log('success push');
         },
         error: function(){
         }
         });
      this.command_add_name = '';
      this.command_add_image = '';
      this.command_add_content = '';
  },
  block_command_delete_people(indexP, index){
      blocks[index].description[indexP].commands_id = 0;
      id = blocks[index].description[indexP].id
      $.ajax({
         url: '/testbuilder/ajax/block-command-people-delete',
         type: 'GET',
         data: 'id=' + id,
         success: function(){
           console.log('success push');
         },
         error: function(){
         }
      });
      },
   
  block_command_people_save(indexP, index){
      $.ajax({
         url: '/testbuilder/ajax/block-command-people-save',
         type: 'GET',
         data: 'id=' + blocks[index].description[indexP].id + '&name=' + blocks[index].description[indexP].name + '&content=' + blocks[index].description[indexP].content + '&image=' + blocks[index].description[indexP].image + '&image_h=' + blocks[index].description[indexP].image_h + '&image_w=' + blocks[index].description[indexP].image_w + '&image_border=' + blocks[index].description[indexP].image_border + '&job=' + blocks[index].description[indexP].job,
         success: function(){
           console.log('success push');
         },
         error: function(){
         }
      });
        },
  block_command_data_save(index){
      $.ajax({
         url: '/testbuilder/ajax/block-command-save',
         type: 'GET',
         data: 'col=' + this.blocks[index].builder_id.col + '&design=' + this.blocks[index].builder_id.design + '&id=' + this.blocks[index].builder_id.id + '&col_content=' + blocks[index].builder_id.gor_col_content + '&col_image=' + blocks[index].builder_id.gor_col_image,
         success: function(){
           console.log('success push');
         },
         error: function(){
         }
         });
  },
  
  // СПИСОК
  block_list_view(){
      this.modal_add_list = true;
      this.block_add_view = false;
  },
  block_list_add(){
      $.ajax({
         url: '/testbuilder/ajax/block-list-add',
         type: 'GET',
         data: 'type=' + this.block_list_design + '&pillar=' + this.block_list_pillar + '&page_id=' + this.page.id + '&title=' + this.block_add_title + '&title_head=' + this.block_add_tag + '&title_color=' + this.block_add_color + '&class=' + this.block_add_class,
         success: function(){
           console.log('success push');
         },
         error: function(){
         }
         });
  },
  block_list_save(index){
      $.ajax({
         url: '/testbuilder/ajax/block-list-save',
         type: 'GET',
         data: 'id=' + blocks[index].builder_id.id + '&col=' + blocks[index].builder_id.col + '&design=' + blocks[index].builder_id.design + '&page_id=' + this.page.id ,
         success: function(){
           console.log('success push');
         },
         error: function(){
         }
         });
  },
  block_list_item_add_in_list(list_id){
      $.ajax({
         url: '/testbuilder/ajax/block-list-item-add',
         type: 'GET',
         data: 'list_id=' + list_id + '&title=' + this.list_add_item_title + '&content=' + this.list_add_item_content + '&page_id=' + this.page.id + '&image=' + this.list_add_item_image ,
         success: function(){
           console.log('success push');
         },
         error: function(){
         }
         });
  },
  block_list_item_delete(indexI, index){
      blocks[index].description[indexI].list_id = 0;
      id = blocks[index].description[indexI].id;
      $.ajax({
         url: '/testbuilder/ajax/block-list-item-delete',
         type: 'GET',
         data: 'id=' + id,
         success: function(){
           console.log('success push');
         },
         error: function(){
         }
      });
  },
  block_list_item_save(indexI, index){
      $.ajax({
         url: '/testbuilder/ajax/block-command-people-save',
         type: 'GET',
         data: 'id=' + blocks[index].description[indexP].id + '&name=' + blocks[index].description[indexP].name + '&content=' + blocks[index].description[indexP].content + '&image=' + blocks[index].description[indexP].image + '&image_h=' + blocks[index].description[indexP].image_h + '&image_w=' + blocks[index].description[indexP].image_w + '&image_border=' + blocks[index].description[indexP].image_border + '&job=' + blocks[index].description[indexP].job,
         success: function(){
           console.log('success push');
         },
         error: function(){
         }
      });
  },
  // Блок ПРЕИМУЩЕСТВА
  block_advantages_view(){
      this.modal_add_advantages = true;
      this.block_add_view = false;
  },
  block_advantages_add(){
      this.modal_close();
      $.ajax({
         url: '/testbuilder/ajax/block-advantages-add',
         type: 'GET',
         data: 'page_id=' + this.page.id + '&design=' + this.block_advantages_design + '&image1=' + this.advantages_1_add_image + '&image2=' + this.advantages_2_add_image + '&image3=' + this.advantages_3_add_image + '&image4=' + this.advantages_4_add_image + '&image5=' + this.advantages_5_add_image + '&image6=' + this.advantages_6_add_image + '&text1=' + this.advantages_1_add_text + '&text2=' + this.advantages_2_add_text + '&text3=' + this.advantages_3_add_text + '&text4=' + this.advantages_4_add_text + '&text5=' + this.advantages_5_add_text + '&text6=' + this.advantages_6_add_text + '&title=' + this.block_add_title + '&title_head=' + this.block_add_tag + '&title_color=' + this.block_add_color + '&class=' + this.block_add_class + '&desc1=' + this.advantages_1_add_desc + '&desc2=' + this.advantages_2_add_desc + '&desc3=' + this.advantages_3_add_desc + '&desc4=' + this.advantages_4_add_desc + '&desc5=' + this.advantages_5_add_desc + '&desc6=' + this.advantages_6_add_desc,
         success: function(){
           console.log('success push');
         },
         error: function(){
         }
      });
  },
  block_advantages_edit(index){
      this.modal_advantages = index;
  },
  block_advantages_save(index){
      this.modal_close();
      $.ajax({
         url: '/testbuilder/ajax/block-advantages-save',
         type: 'GET',
         data: 'id=' + this.blocks[index].builder_id.id +'&design=' + this.blocks[index].builder_id.design + '&image1=' + this.blocks[index].builder_id.image1 + '&image2=' + this.blocks[index].builder_id.image2 + '&image3=' + this.blocks[index].builder_id.image3 + '&image4=' + this.blocks[index].builder_id.image4 + '&image5=' + this.blocks[index].builder_id.image5 + '&image6=' + this.blocks[index].builder_id.image6 + '&text1=' + this.blocks[index].builder_id.text1 + '&text2=' + this.blocks[index].builder_id.text2 + '&text3=' + this.blocks[index].builder_id.text3 + '&text4=' + this.blocks[index].builder_id.text4 + '&text5=' + this.blocks[index].builder_id.text5 + '&text6=' + this.blocks[index].builder_id.text6 + '&title=' + this.block_add_title + '&title_head=' + this.block_add_tag + '&title_color=' + this.block_add_color + '&class=' + this.block_add_class + '&desc1=' + this.blocks[index].builder_id.desc1 + '&desc2=' + this.blocks[index].builder_id.desc2 + '&desc3=' + this.blocks[index].builder_id.desc3 + '&desc4=' + this.blocks[index].builder_id.desc4 + '&desc5=' + this.blocks[index].builder_id.desc5 + '&desc6=' + this.blocks[index].builder_id.desc6,
         success: function(){
           console.log('success push');
         },
         error: function(){
         }
      });
  },
  
    
   
    // МОДАЛЬНОЕ ОКНО
    modal_close(){
      this.showModal = false;
      this.block_add_modal = false;
      this.block_add_view = false;
      this.command_block_modal = false;
      this.html_block_modal = false;
      this.modal_command_people = 999;
      this.modal_add_list = false;
      this.modal_list = 999;
      this.modal_add_advantages = false;
      this.modal_advantages = 999;
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
  menu_link_title_edit(index){
      this.menu_title_edit = 999;
      $.ajax({
         url: '/testbuilder/ajax/menu-edit-link',
         type: 'GET',
         data: 'id=' + blocks[index].id + '&link=' + blocks[index].link_title,
         success: function(){
           console.log( id + 'success push');
         },
         error: function(){
         }
         });
  },
  
   // Дабваление блоков
    block_new_add(){
      this.block_add_view = true;
      this.showModal = true;
      this.block_add_modal = true;
    },
    block_html_add(){
      this.block_add_view = false;
      this.html_block_modal = true;
    },
    
    block_hr_add()
    {
      $.ajax({
         url: '/testbuilder/ajax/block-hr-add',
         type: 'GET',
         data: 'page_id=' + this.page.id,
         success: function(){
           console.log('success push');
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
    .people_name {
        color: #191919;
        margin-top: 10px;
        font-weight: bold;
    }

    .html_block_border {
        padding: 45px 50px 20px;
        border: 2px solid #f60;
        margin-top: 2em;
    }

    .hideBlock {
        opacity: 0.5;
    }

    .block:not(.modal) :hover {
        border: #494f54 1px dotted;
    }

    .block_no_hover :hover {
        pointer-events: none;
    }

    .bg_block_new_add {
        border: 5px solid;
        border-color: #999999;
        border-radius: 20px 20px;
    }

    .bg_block_new_add :hover {
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
        width: 90%;
        height: 90%;
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

    .col-xs-five,
    .col-sm-five,
    .col-md-five,
    .col-lg-five {
        position: relative;
        min-height: 1px;
        padding-right: 10px;
        padding-left: 10px;
    }

    .col-xs-five {
        width: 20%;
        float: left;
    }

    @media (min-width: 768px) {
        .col-sm-five {
            width: 20%;
            float: left;
        }
    }

    @media (min-width: 992px) {
        .col-md-five {
            width: 20%;
            float: left;
        }
    }

    @media (min-width: 1200px) {
        .col-lg-five {
            width: 20%;
            float: left;
        }
    }

    /*Эти классы удалить!*/
    .ul-reset {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .section-5__list {
        margin-top: 2em;
    }

    .list__item {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        margin-bottom: 2em;
    }

    .list__img-wrap {
        -ms-flex-negative: 0;
        flex-shrink: 0;
        width: 70px;
        margin-right: 15px;
        text-align: right;
    }

    .list {
        -webkit-column-count: 2;
        -moz-column-count: 2;
        column-count: 2;
        -webkit-column-gap: 30px;
        -moz-column-gap: 30px;
        column-gap: 30px;
    }

    ol li {
        padding-left: 40px;
        position: relative;
        margin-bottom: .75em;
    }

    }
    ul:not(.ul-reset) li::before {
        content: "";
        position: absolute;
        left: 15px;
        top: 10px;
        width: 7px;
        height: 7px;
        background-color: #f60;
        border-radius: 50%;
    }

    .section--light-bg {
        background-color: #fcfcfc;
    }

    .tiles {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
    }

    .ul-reset {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .tiles__item {
        width: calc(100% / 3);
    }

    .tile__wrap {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
        padding: 50px;
        background-color: #fff;
        border-radius: 5px;
        -webkit-transition: .25s;
        transition: .25s;
    }

    .tile__text {
        width: 120px;
    }

    .tile__img {
        margin-top: 15px;
    }
</style>
<script>
    <?= $page->js ?>

</script>
