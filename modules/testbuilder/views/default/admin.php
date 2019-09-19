<?php

use yii\helpers\Json;

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
                 @click="block_edit_title(index)"
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
                                @click="block_duplicate(index)"><span
                                    class="glyphicon glyphicon-duplicate" title="Дублировать"></span></button>
                        <button type="button" class="btn btn-default"
                                @click="block_save(index)"><span
                                    class="glyphicon glyphicon-file" title="Сохранить"></span></button>
                        <button type="button" class="btn btn-default"
                                @click="block_edit(index)"><span
                                    class="glyphicon glyphicon-pencil " title="Редактировать"></span></button>
                        <button type="button" class="btn btn-danger"
                                @click="block_delete(index)"><span
                                    class="glyphicon glyphicon-remove" title="Удалить"></span>
                        </button>
                        <button class="btn btn-success" type="button"
                                @click="block_save_title(index)"><span class="glyphicon glyphicon-ok"
                                                                       title="Сохранить"></span> Сохранить
                        </button>
                        <button class="btn btn-warning" type="button"
                                @click="block_title_edit = 999"><span
                                    class="glyphicon glyphicon-remove" title="Закрыть"></span> Закрыть
                        </button>
                    </div>

                    <!--    Окно редактирования блока-->
                    <modal v-if="(block_edit_modal == index) && (showModal)" @close="showModal = false"
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
                                    @click="block_save_data(index)">
                                Сохранить
                            </button>
                        </div>
                        <div slot="footer">
                            <button class="btn btn-danger"
                                    @click="modal_close()"> Закрыть
                            </button>
                        </div>
                    </modal>

                    <!--    Окно сохранения блока-->
                    <modal v-if="(block_saved.modal == index) && (showModal)" @close="showModal = false"
                           class="modal">
                        <h3 slot="header">Добавить блок в "Сохраненное"</h3>
                        <div slot="body">
                            <div class="bg-light text-right">
                                <br>
                                <input type="text" class="form-control" placeholder="Заголовок"
                                       v-model="block_saved.title"><br>
                                <input type="text" class="form-control" placeholder="Картинка"
                                       v-model="block_saved.image"><br>
                                <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="3"
                                          placeholder="Описание"
                                          v-model="block_saved.description"></textarea>

                                <button class="btn btn-success m-2"
                                        @click="block_save_in_saved(index)">
                                    Сохранить
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
                    v-show="block.builder_table == 'block_command'">
                Редактировать команду
            </button>
            <div v-if="block.builder_table == 'block_command'"
                 class="block"
                 @click="block_command_edit(index)">
                <div class="row">
                    <div v-for="people in block.builder_id.peoples"
                         v-show="people.commands_id == block.builder_id.id">
                        <div :class="'col-sm-' + block.builder_id.col">
                            <!--                        Вертикальный дизайн-->
                            <div class="team__item team-item"
                                 v-if="block.builder_id.design == 'Вертикальный'">
                                <div class="image col-sm-4 text-right">
                                    <img :src="people.image"
                                         :alt="people.name"
                                         :style="'height: ' + people.image_h + 'px; width: ' + people.image_w + 'px; border-radius: ' + people.image_border">
                                </div>
                                <div class="text-left col-sm-8 team-item__text">
                                    <div class="people_name team-item__name">
                                        {{people.name}}
                                    </div>
                                    <div class="people_job team-item__position">
                                        {{people.content}}
                                    </div>
                                </div>
                            </div>
                            <!--                        Горизонтальный-->
                            <div v-if="block.builder_id.design == 'Горизонтальный'">
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
                            <!--                        Слово лидера-->
                            <div class="thesis"
                                 v-if="block.builder_id.design == 'Слово лидера'">
                                <div class="thesis__author team-item col-sm-5">
                                    <img class="team-item__img"
                                         :src="people.image"
                                         :alt="people.name"
                                         :style="'height: ' + people.image_h + 'px; width: ' + people.image_w + 'px; border-radius: ' + people.image_border">
                                    <div class="team-item__text">
                                        <div class="team-item__name"><b>{{people.name}}</b></div>
                                        <div class="team-item__position">{{people.job}}</div>
                                    </div>
                                </div>

                                <div class="people_content col-sm-7 thesis__text"
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
            <modal v-if="command_block.modal == index"
                   class="modal"
                   @close="command_block.modal = false">
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
                                <option>Слово лидера</option>
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
                                 v-for="people,indexP in block.builder_id.peoples"
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
                                               v-model="command_block.people.name"><br>
                                    </div>
                                    <div class="col-sm-6">
                                    <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="4"
                                              placeholder="Текст"
                                              v-model="command_block.people.content">
                                    </textarea>
                                    </div>
                                    <div class="input-group col-sm-12">
                                        <span class="input-group-addon"><strong>Картинка:</strong></span>
                                        <input type="text" class="form-control" placeholder="Путь к картинке"
                                               v-model="command_block.people.image">
                                        <span class="input-group-addon">Высота:</span>
                                        <input type="text" class="form-control" placeholder="Высота"
                                               v-model="command_block.people.image_h">
                                        <span class="input-group-addon">Ширина:</span>
                                        <input type="text" class="form-control" placeholder="Ширина"
                                               v-model="command_block.people.image_w">
                                        <span class="input-group-addon">Округление:</span>
                                        <input type="text" class="form-control" placeholder="border"
                                               v-model="command_block.people.image_border">
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
                 @click="block_list_edit(index)">
                <div class="row">
                    <div v-if="block.builder_id.design == 'С нумерацией'"
                         @click="list_block.modal = index">
                        <ol :class="{list: block.builder_id.col == 2}">
                            <li v-for="item in block.description">
                                <label for="list"> {{item.title}}</label><br v-show="item.title != ''">
                                <span v-html="item.content"></span>
                            </li>
                        </ol>
                    </div>
                    <div v-if="block.builder_id.design == 'С точками'"
                         @click="list_block.modal = index">
                        <ul :class="{list: block.builder_id.col == 2}">
                            <li v-for="item in block.description" v-html="item.content"></li>
                        </ul>
                    </div>
                    <div v-if="block.builder_id.design == 'С картинкой'"
                         @click="list_block.modal = index">
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
                            @click="list_block.modal = index">
                        Добавить пункт
                    </button>
                </div>
            </div>
            <!--            Окно редакттирования списка-->
            <modal v-if="list_block.modal == index"
                   class="modal"
                   @close="list_block.modal != index">
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
                                              v-model="list_block.item.content">
                                    </textarea>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" placeholder="Жирный шрифт в начале"
                                               v-model="list_block.item.title"
                                               v-show="block.builder_id.design == 'С нумерацией'"><br>
                                        <div class="input-group"
                                             v-show="block.builder_id.design == 'С картинкой'">
                                            <span class="input-group-addon"><strong>Картинка:</strong></span>
                                            <input type="text" class="form-control" placeholder="Путь к картинке"
                                                   v-model="list_block.item.image">
                                        </div>
                                    </div>
                                    <button class="btn btn-success m-2"
                                            @click="block_list_item_add(block.builder_id.id)">
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

            <!--Если преимущества-->
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
                        @click="advantages_block.modal = index"
                        v-if="block.builder_id.text1 == ''">
                    Редактировать преимущества
                </button>
            </div>
            <!--            Окно редактирования преимуществ-->
            <modal v-if="advantages_block.modal == index"
                   class="modal"
                   @close="advantages_block.modal != index">
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
           v-if="(showModal) && (block_add.modal)" @close="showModal = false">
        <h3 slot="header">Добавить блок</h3>
        <div slot="body">
            <div class="block_new_add mt-2 bg-light shadow-sm p-2"
                 v-show="block_add.view">
                <h3 class="text-center">
                    Добавление блока!
                </h3>
                <div class="row">
                    <div class="col-lg-5">
                        <input type="text" class="form-control" placeholder="Заголовок"
                               v-model="block_add.title">
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-1">
                        <select class="form-control" id="sel1"
                                v-model="block_add.tag">
                            <option>h2</option>
                            <option>h3</option>
                            <option>h4</option>
                        </select>
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-2">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Цвет"
                                   v-model="block_add.color">
                            <span class="input-group-addon"
                                  :style="'background: #' + block_add.color"></span>
                        </div>
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-2">
                        <input type="text" class="form-control" placeholder="class"
                               v-model="block_add.class">
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
                <div :style="'color: #' + block_add.color">
                    <div v-if="block_add.tag == 'h2'">
                        <h2> {{block_add.title}} </h2>
                    </div>
                    <div v-if="block_add.tag == 'h3'">
                        <h3> {{block_add.title}} </h3>
                    </div>
                    <div v-if="block_add.tag == 'h4'">
                        <h4> {{block_add.title}} </h4>
                    </div>
                </div>
                <button class="btn btn-default m-2"
                        @click="block_html_view()">
                    HTML
                </button>
                <button class="btn btn-default m-2"
                        @click="block_html_add('block_text')">
                    Текст
                </button>
                <button class="btn btn-default m-2"
                        @click="block_command_view()">
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
                <button class="btn btn-default m-2"
                        @click="block_saved_view()">
                    Сохраненное
                </button>
            </div>

            <!--    Создание блока HTML-->
            <div class="bg-light mt-3 p-4"
                 v-show="html_block.modal">
                <div class="form-group">
                    <label class="text-center" for="exampleFormControlTextarea1">Добавить html block! </label>
                    <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="10"
                              placeholder="Введите свой код!"
                              v-model="html_block.code"></textarea>
                </div>
                <input type="checkbox"
                       v-model="html_block.border"> Добавить рамку? <br>
                <button class="btn btn-success"
                        @click="block_html_add()">
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
                        <br>
                        <input type="radio" id="one_command" value="Вертикальный" v-model="command_block.design">
                        <label for="one_command"><img src="https://i.ibb.co/VqQ1jmr/20.png" alt="Вертикальный"
                                                      style="height: 100px;"></label>
                        <br>
                        <input type="radio" id="two_command" value="Горизонтальный" v-model="command_block.design">
                        <label for="two_command"><img src="https://i.ibb.co/m9GnGr3/39.png" alt="Горизонтальный"
                                                      style="height: 100px;"></label>
                        <br>
                        <input type="radio" id="three_command" value="Слово лидера" v-model="command_block.design">
                        <label for="three_command"><img src="https://i.ibb.co/tpzBg9w/21.png" alt="Слово лидера"
                                                        style="height: 100px;"></label>
                        <br>
                        <label for="sel1">Количество столбцов:</label>
                        <select class="form-control" id="sel1"
                                v-model="command_block.col">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>6</option>
                        </select>
                        <div class="input-group"
                             v-if="command_block.design == 'Горизонтальный'">
                            <span class="input-group-addon"><strong>Соотношение картинки к тексту:</strong></span>
                            <input type="text" class="form-control" placeholder="сверху"
                                   v-model="command_block.people.gor_col_image">
                            <span class="input-group-addon"> к </span>
                            <input type="text" class="form-control" placeholder="сверху"
                                   v-model="command_block.people.gor_col_content">
                            <span class="input-group-addon"> (сумма должна быть 12) </span>
                        </div>
                    </div>
                    <h3>Добавить человека:</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" placeholder="Имя"
                                   v-model="command_block.people.name"><br>
                        </div>
                        <div class="col-sm-6">
                    <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="4"
                              placeholder="Текст"
                              v-model="command_block.people.content"></textarea>
                        </div>
                        <br>

                        <div class="input-group col-sm-12">
                            <span class="input-group-addon"><strong>Картинка:</strong></span>
                            <input type="text" class="form-control" placeholder="Путь к картинке"
                                   v-model="command_block.people.image">
                            <span class="input-group-addon">Высота:</span>
                            <input type="text" class="form-control" placeholder="Высота"
                                   v-model="command_block.people.image_h">
                            <span class="input-group-addon">Ширина:</span>
                            <input type="text" class="form-control" placeholder="Ширина"
                                   v-model="command_block.people.image_w">
                            <span class="input-group-addon">Округление:</span>
                            <input type="text" class="form-control" placeholder="border"
                                   v-model="command_block.people.image_border">
                        </div>


                    </div>
                </div>
                <button class="btn btn-success"
                        @click="block_command_add()">
                    Добавить
                </button>
            </div>

            <!--    Добавление блока СПИСОК-->
            <div class="bg-light mt-3 p-4"
                 v-show="modal_add_list">
                <div class="form-group">
                    <label for="sel1">Вид списка:</label>
                    <br>
                    <input type="radio" id="one_list" value="С нумерацией" v-model="list_block.design">
                    <label for="one_list"><img src="https://i.ibb.co/9HTZMJF/5.png" alt="Вертикальный"
                                               style="height: 100px;"></label>
                    <br>
                    <input type="radio" id="two_list" value="С точками" v-model="list_block.design">
                    <label for="two_list"><img src="https://i.ibb.co/0Fhvw6j/8.png" alt="С точками"
                                               style="height: 100px;"></label>
                    <br>
                    <input type="radio" id="three_list" value="С картинкой" v-model="list_block.design">
                    <label for="three_list"><img src="https://i.ibb.co/xq2rhXR/1.png" alt="С картинкой"
                                                 style="height: 100px;"></label>
                    <br>
                    Количество столбцов: <br>
                    <select class="form-control" id="pillar"
                            v-model="list_block.col">
                        <option>1</option>
                        <option>2</option>
                    </select> <br>
                </div>
                <button class="btn btn-default"
                        @click="block_list_add()">
                    Создать
                </button>


            </div>

            <!--    Добавление блока ПРЕИМУЩЕСТВА-->
            <div class="bg-light mt-3 p-4"
                 v-show="modal_add_advantages">
                Вид блока преимуществ: <br>
                <br>
                <input type="radio" id="one_advantages" value="4 столбца" v-model="advantages_block.design">
                <label for="one_advantages"><img src="https://i.ibb.co/sW4k8k0/9.png" alt="4 столбца"
                                                 style="height: 100px;"></label>
                <br>
                <input type="radio" id="two_advantages" value="5 столбцов" v-model="advantages_block.design">
                <label for="two_advantages"><img src="https://i.ibb.co/TkY9K2j/6.png" alt="5 столбцов"
                                                 style="height: 100px;"></label>
                <br>
                <input type="radio" id="three_advantages" value="6 столбцов" v-model="advantages_block.design">
                <label for="three_advantages"><img src="https://i.ibb.co/kgnzjHS/image.png" alt="6 столбцов"
                                                   style="height: 100px;"></label>
                <br>
                <input type="radio" id="four_advantages" value="6 блоков" v-model="advantages_block.design">
                <label for="four_advantages"><img src="https://i.ibb.co/gZWCvwZ/40.png" alt="6 блоков"
                                                  style="height: 100px;"></label>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">Картикна:</span>
                    <input type="text" class="form-control" placeholder="Адресс картинки"
                           v-model="advantages_block.image1">
                    <span class="input-group-addon">Текст:</span>
                    <input type="text" class="form-control" placeholder="Текст"
                           v-model="advantages_block.text1">
                </div>
                <div class="input-group mt-2" v-if="advantages_block.design == '6 блоков'">
                    <span class="input-group-addon">Описание:</span>
                    <input type="text" class="form-control" placeholder="Описание"
                           v-model="advantages_block.desc1">
                </div>
                <hr>
                <div class="input-group">
                    <span class="input-group-addon">Картикна:</span>
                    <input type="text" class="form-control" placeholder="Адресс картинки"
                           v-model="advantages_block.image2">
                    <span class="input-group-addon">Текст:</span>
                    <input type="text" class="form-control" placeholder="Текст"
                           v-model="advantages_block.text2">
                </div>
                <div class="input-group mt-2" v-if="advantages_block.design == '6 блоков'">
                    <span class="input-group-addon">Описание:</span>
                    <input type="text" class="form-control" placeholder="Описание"
                           v-model="advantages_block.desc2">
                </div>
                <hr>
                <div class="input-group">
                    <span class="input-group-addon">Картикна:</span>
                    <input type="text" class="form-control" placeholder="Адресс картинки"
                           v-model="advantages_block.image3">
                    <span class="input-group-addon">Текст:</span>
                    <input type="text" class="form-control" placeholder="Текст"
                           v-model="advantages_block.text3">
                </div>
                <div class="input-group mt-2" v-if="advantages_block.design == '6 блоков'">
                    <span class="input-group-addon">Описание:</span>
                    <input type="text" class="form-control" placeholder="Описание"
                           v-model="advantages_block.desc3">
                </div>
                <hr>
                <div class="input-group">
                    <span class="input-group-addon">Картикна:</span>
                    <input type="text" class="form-control" placeholder="Адресс картинки"
                           v-model="advantages_block.image4">
                    <span class="input-group-addon">Текст:</span>
                    <input type="text" class="form-control" placeholder="Текст"
                           v-model="advantages_block.text4">
                </div>
                <div class="input-group mt-2" v-if="advantages_block.design == '6 блоков'">
                    <span class="input-group-addon">Описание:</span>
                    <input type="text" class="form-control" placeholder="Описание"
                           v-model="advantages_block.desc4">
                </div>
                <hr>
                <div class="input-group"
                     v-show="advantages_block.design != '4 столбца'">
                    <span class="input-group-addon">Картикна:</span>
                    <input type="text" class="form-control" placeholder="Адресс картинки"
                           v-model="advantages_block.image5">
                    <span class="input-group-addon">Текст:</span>
                    <input type="text" class="form-control" placeholder="Текст"
                           v-model="advantages_block.text5">
                </div>
                <div class="input-group mt-2" v-if="advantages_block.design == '6 блоков'">
                    <span class="input-group-addon">Описание:</span>
                    <input type="text" class="form-control" placeholder="Описание"
                           v-model="advantages_block.desc5">
                </div>
                <hr>
                <div class="input-group"
                     v-show="((advantages_block.design == '6 блоков') || (advantages_block.design == '6 столбцов'))">
                    <span class="input-group-addon">Картикна:</span>
                    <input type="text" class="form-control" placeholder="Картинка"
                           v-model="advantages_block.image6">
                    <span class="input-group-addon">Текст:</span>
                    <input type="text" class="form-control" placeholder="Текст"
                           v-model="advantages_block.text6">
                </div>
                <div class="input-group mt-2" v-if="advantages_block.design == '6 блоков'">
                    <span class="input-group-addon">Описание:</span>
                    <input type="text" class="form-control" placeholder="Описание"
                           v-model="advantages_block.desc6">
                </div>
                <hr>
                <br>
                <button class="btn btn-success"
                        @click="block_advantages_add()">
                    Создать
                </button>

            </div>

            <!--            Добавление блока сохраненное-->
            <div class="col-sm-4"
                 v-show="modal_add_saved"
                 v-for=" block_saved of blocks_saved">
            <div class="panel panel-default"
                 v-show="block_saved.id != 0"
                 @click="block_saved_add(block_saved.id)">
                <div class="panel-heading">
                    <h3 class="panel-title col-sm-10">{{block_saved.title}}</h3>
                    <button class="btn btn-danger btn-sm col-sm-2"
                            @click="block_saved_delete(block_saved.id)">
                        <span class="glyphicon glyphicon-remove "></span>
                    </button>
                    <br><br>
                </div>
                <div class="panel-body">
                    <img style="max-width: 320px;max-height: 300px"
                         :src="block_saved.image"
                         :alt="block_saved.title">
                </div>
                <div class="panel-footer">
                    {{block_saved.description}}
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

</div>


<?php
Yii::$app->view->registerJs("var page = " . Json::encode($page)
    . ";", \yii\web\View::POS_END);
Yii::$app->view->registerJs("var blocks_saved = " . Json::encode($blocks_saved)
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
  
  // Сохранение блока
  blocks_saved: blocks_saved,
  modal_add_saved: false,
  block_saved: {
    modal: 999,
    image: '',
    title: '',
    description: '',
    },
    
 
  // добавление блока
          block_add: {
              color: '7faf24',
              view: false,
              title: '',
              tag: 'h2',
              class: '',
              modal: false,
          },
      
      //БЛОК HTML
      prev_html: 999,
      html_block: {
          modal: false,
          code: '',
          border: 0,
      },
      
      // блок команда
      command_block_modal: false,
      //добавление блока команда:
      command_block: {
          design: 'Вертикальный',
          col: 1,
          people: {
              name: '',
              content: '',
              image: '',
              image_h: 100,
              image_w: 100,
              image_border: '0px 0px 0px 0px',
              gor_col_content: 8,
              gor_col_image: 4,
          },
          modal: 999,
      },
      
      // блок список
      modal_add_list: false,
      list_block:{
          design: 'С нумерацией',
          col: 1,
          item: {
            title: '',
            content: '',
            image: '',
          },
          modal: 999,
      },
      
      // блок преимущества
      modal_add_advantages: false,
      advantages_block:{
          design: '4 столбца',
          image1: '',
          image2: '',
          image3: '',
          image4: '',
          image5: '',
          image6: '',
          text1: '',
          text2: '',
          text3: '',
          text4: '',
          text5: '',
          text6: '',
          desc1: '',
          desc2: '',
          desc3: '',
          desc4: '',
          desc5: '',
          desc6: '',
          modal: 999,
      },
     
  showModal: false,
  
  //menu
  menu_title_edit: 999,
},
methods: {
  // Общее редактирование блока
    block_edit_title(index){
      this.block_title_edit = index;
    },
    block_save_title(index) {
      this.block_title_edit = 999;
      this.push_ajax('block-save-title', 'id=' + blocks[index].id + '&title=' + blocks[index].title + '&title_h=' + blocks[index].title_head + '&title_color=' + blocks[index].title_color + '&isHide=' + this.blocks[index].isHide + '&isDesktop=' + this.blocks[index].isDesktop + '&isTablet=' + this.blocks[index].isTablet + '&isMobile=' + this.blocks[index].isMobile);
    },
    block_duplicate(index){ //TODO более гибкое дублирование, а не костыли!
      this.push_ajax('block-duplicate', 'id=' + blocks[index].id + '&page_id=' + this.page.id);
    },
    block_delete(index){ 
      this.push_ajax('block-delete', 'id=' + blocks[index].id + '&page_id=' + this.page.id);
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
      this.push_ajax('block-save-pos', 'pos1=' + pos1 + '&pos2=' + pos2);
    },
     block_edit(index){
      this.showModal = true;
      this.block_edit_modal = index;
    },
    block_save_data(index){
      this.block_title_edit = 999;
      this.modal_close();
      this.push_ajax('block-save-data', 'page_id=' + this.page.id + '&title=' + this.blocks[index].title + '&title_head=' + this.blocks[index].title_head + '&title_color=' + this.blocks[index].title_color + '&class=' + this.blocks[index].class + '&id=' + this.blocks[index].id + '&mt=' + this.blocks[index].style_margin_top + '&mb=' + this.blocks[index].style_margin_bottom + '&isCont=' + this.blocks[index].css_isContainer + '&isLink=' + this.blocks[index].isLink + '&link_title=' + this.blocks[index].link_title + '&isHide=' + this.blocks[index].isHide + '&isDesktop=' + this.blocks[index].isDesktop + '&isTablet=' + this.blocks[index].isTablet + '&isMobile=' + this.blocks[index].isMobile + '&css_background=' + this.blocks[index].css_background);
  },
  
  
    // HTML
    block_html_view(){
      this.block_add.view = false;
      this.html_block.modal = true;
    },
    block_html_save(index){
      this.prev_html = 999;
      this.push_ajax('block-html-save', 'id=' + this.blocks[index].builder_id.id + '&code=' + this.blocks[index].builder_id.code + '&border=' + this.blocks[index].builder_id.border);
    },
    block_html_add(type){
      this.modal_close();
      this.push_ajax('block-html-add', 'page_id=' + this.page.id + '&title=' + this.block_add.title + '&title_head=' + this.block_add.tag + '&title_color=' + this.block_add.color + '&class=' + this.block_add.class + '&code=' + this.html_block.code + '&border=' + this.html_block.border + '&type=' + type);
  },
  
  //команда
  block_command_view(){
      this.command_block_modal = true;
      this.block_add.view = false;
  },
  
  block_command_add(){  
      this.modal_close();
      this.push_ajax('block-command-add', 'page_id=' + this.page.id + '&command_design=' + this.command_block.design + '&command_col=' + this.command_block.col + '&people_name=' + this.command_block.people.name + '&p_image=' + this.command_block.people.image + '&p_image_h=' + this.command_block.people.image_h + '&p_image_w=' + this.command_block.people.image_w + '&p_image_b=' + this.command_block.people.image_border + '&content=' + this.command_block.people.content + '&title=' + this.block_add.title + '&title_head=' + this.block_add.tag + '&title_color=' + this.block_add.color + '&class=' + this.block_add.class + '&col_content=' + this.command_block.people.gor_col_content + '&col_image=' + this.command_block.people.gor_col_image);
  },
  block_command_edit(index){
      this.command_block.modal = index;
  },
  block_people_add_in_command(id){
      this.push_ajax('block-people-add-in-command', 'page_id=' + this.page.id + '&people_name=' + this.command_block.people.name + '&p_image=' + this.command_block.people.image + '&p_image_h=' + this.command_block.people.image_h + '&p_image_w=' + this.command_block.people.image_w + '&p_image_b=' + this.command_block.people.image_border + '&content=' + this.command_block.people.content + '&command_id=' + id);
      this.command_block.people.name = '';
      this.command_block.people.image = '';
      this.command_block.people.content = '';
  },
  block_command_delete_people(indexP, index){
      blocks[index].builder_id.peoples[indexP].commands_id = 0;
      id = blocks[index].builder_id.peoples[indexP].id
      this.push_ajax('block-command-people-delete', 'id=' + id);
      },
   
  block_command_people_save(indexP, index){
      this.push_ajax('block-command-people-save', 'id=' + blocks[index].builder_id.peoples[indexP].id + '&name=' + blocks[index].builder_id.peoples[indexP].name + '&content=' + blocks[index].builder_id.peoples[indexP].content + '&image=' + blocks[index].builder_id.peoples[indexP].image + '&image_h=' + blocks[index].builder_id.peoples[indexP].image_h + '&image_w=' + blocks[index].builder_id.peoples[indexP].image_w + '&image_border=' + blocks[index].builder_id.peoples[indexP].image_border + '&job=' + blocks[index].builder_id.peoples[indexP].job);
        },
  block_command_data_save(index){
      this.push_ajax('block-command-save', 'col=' + this.blocks[index].builder_id.col + '&design=' + this.blocks[index].builder_id.design + '&id=' + this.blocks[index].builder_id.id + '&col_content=' + blocks[index].builder_id.gor_col_content + '&col_image=' + blocks[index].builder_id.gor_col_image + '&page_id=' + this.page.id);
  },
  
  
  // СПИСОК
  block_list_view(){
      this.modal_add_list = true;
      this.block_add.view = false;
  },
  block_list_add(){  //TODO не работает!!!
      this.modal_close();
      this.push_ajax('block-list-add', 'type=' + this.list_block.design + '&col=' + this.list_block.col + '&page_id=' + this.page.id + '&title=' + this.block_add.title + '&title_head=' + this.block_add.tag + '&title_color=' + this.block_add.color + '&class=' + this.block_add.class);
  },
  block_list_save(index){ 
      this.modal_close();
      this.push_ajax('block-list-save', 'id=' + blocks[index].builder_id.id + '&col=' + blocks[index].builder_id.col + '&design=' + blocks[index].builder_id.design + '&page_id=' + this.page.id);
  },
  block_list_item_add(list_id){
      this.push_ajax('block-list-item-add', 'list_id=' + list_id + '&title=' + this.list_block.item.title + '&content=' + this.list_block.item.content + '&page_id=' + this.page.id + '&image=' + this.list_block.item.image);
  },
  block_list_item_delete(indexI, index){
      blocks[index].description[indexI].list_id = 0;
      id = blocks[index].description[indexI].id;
      this.push_ajax('block-list-item-delete', 'id=' + id);
  },
  block_list_item_save(indexI, index){
      this.push_ajax('block-list-item-save', 'id=' + blocks[index].description[indexI].id + '&title=' + blocks[index].description[indexI].title + '&content=' + blocks[index].description[indexI].content + '&image=' + blocks[index].description[indexI].image + '&list_id=' + blocks[index].builder_id.id);
  },
  
  
  
  // Блок ПРЕИМУЩЕСТВА
  block_advantages_view(){
      this.modal_add_advantages = true;
      this.block_add.view = false;
  },
  block_advantages_add(){
      this.modal_close();
      this.push_ajax('block-advantages-add', 'page_id=' + this.page.id + '&design=' + this.advantages_block.design + '&image1=' + this.advantages_block.image1 + '&image2=' + this.advantages_block.image2 + '&image3=' + this.advantages_block.image3 + '&image4=' + this.advantages_block.image4 + '&image5=' + this.advantages_block.image5 + '&image6=' + this.advantages_block.image6 + '&text1=' + this.advantages_block.text1 + '&text2=' + this.advantages_block.text2 + '&text3=' + this.advantages_block.text3 + '&text4=' + this.advantages_block.text4 + '&text5=' + this.advantages_block.text5 + '&text6=' + this.advantages_block.text6 + '&title=' + this.block_add.title + '&title_head=' + this.block_add.tag + '&title_color=' + this.block_add.color + '&class=' + this.block_add.class + '&desc1=' + this.advantages_block.desc1 + '&desc2=' + this.advantages_block.desc2 + '&desc3=' + this.advantages_block.desc3 + '&desc4=' + this.advantages_block.desc4 + '&desc5=' + this.advantages_block.desc5 + '&desc6=' + this.advantages_block.desc6);
  },
  block_advantages_edit(index){
      this.advantages_block.modal = index;
  },
  block_advantages_save(index){
      this.modal_close();
      this.push_ajax('block-advantages-save', 'id=' + this.blocks[index].builder_id.id +'&design=' + this.blocks[index].builder_id.design + '&image1=' + this.blocks[index].builder_id.image1 + '&image2=' + this.blocks[index].builder_id.image2 + '&image3=' + this.blocks[index].builder_id.image3 + '&image4=' + this.blocks[index].builder_id.image4 + '&image5=' + this.blocks[index].builder_id.image5 + '&image6=' + this.blocks[index].builder_id.image6 + '&text1=' + this.blocks[index].builder_id.text1 + '&text2=' + this.blocks[index].builder_id.text2 + '&text3=' + this.blocks[index].builder_id.text3 + '&text4=' + this.blocks[index].builder_id.text4 + '&text5=' + this.blocks[index].builder_id.text5 + '&text6=' + this.blocks[index].builder_id.text6 + '&title=' + this.block_add.title + '&title_head=' + this.block_add.tag + '&title_color=' + this.block_add.color + '&class=' + this.block_add.class + '&desc1=' + this.blocks[index].builder_id.desc1 + '&desc2=' + this.blocks[index].builder_id.desc2 + '&desc3=' + this.blocks[index].builder_id.desc3 + '&desc4=' + this.blocks[index].builder_id.desc4 + '&desc5=' + this.blocks[index].builder_id.desc5 + '&desc6=' + this.blocks[index].builder_id.desc6);
  },
  
  
    
   
    // МОДАЛЬНОЕ ОКНО
    modal_close(){
      this.showModal = false;
      this.block_add.modal = false;
      this.block_add.view = false;
      this.command_block_modal = false;
      this.html_block.modal = false;
      this.command_block.modal = 999;
      this.modal_add_list = false;
      this.list_block.modal = 999;
      this.modal_add_advantages = false;
      this.advantages_block.modal = 999;
      this.block_add_saved = false;
      this.modal_add_saved = false;
    },
   
  
  // СТРАНИЦА
  page_save(){
    this.page_cog = false;
    this.push_ajax('update-page', 'id=' + page.id + '&title=' + page.title + '&desc=' + page.description + '&class=' + page.class + '&seo_t=' + page.seo_title + '&seo_d=' + page.seo_desc + '&seo_k=' + page.seo_key + '&foot=' + page.footer_html + '&js=' +  page.js + '&style=' + page.style);
  },
  menu_link_title_edit(index){
      this.menu_title_edit = 999;
      this.push_ajax('menu-edit-link', 'id=' + blocks[index].id + '&link=' + blocks[index].link_title);
  },
  
   // Дабавление блоков
    block_new_add(){
      this.block_add.view = true;
      this.showModal = true;
      this.block_add.modal = true;
    },
    
    // Сохранение блока
    block_save(index){
      this.showModal = true;
      this.block_saved.modal = index;
    },
    block_save_in_saved(index){
      this.push_ajax('block-save-in-saved','block_id=' + this.blocks[index].id + '&title=' + this.block_saved.title + '&description=' + this.block_saved.description + '&image=' + this.block_saved.image );
      this.modal_close();
    },
    block_saved_view(){
      this.block_add.view = false;
      this.block_add_saved = true;
      this.modal_add_saved = true;
    },
    block_saved_delete(id){
      this.push_ajax('block-saved-delete', 'id=' + this.blocks_saved[id].id);
      this.blocks_saved[id].id = 0;
  },
    block_saved_add(id){
      this.modal_close();
      this.push_ajax('block-saved-add', 'id=' + this.blocks_saved[id].id + '&page_id=' + this.page.id);
    },
    
   
    
    block_hr_add()  {
      this.push_ajax('block-hr-add', 'page_id=' + this.page.id);
    },
    push_ajax(action, request){
       $.ajax({
         url: '/testbuilder/ajax/' + action,
         type: 'GET',
         data: request,
         success: function(){
           console.log('success push action: ' + action + ' request: ' + request);
         },
         error: function(){
           alert('Error' + request);
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
    .team-item {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
    }

    .team-item__img {
        -ms-flex-negative: 0;
        flex-shrink: 0;
        margin-right: 15px;
        border-radius: 50%;
        border: 2px solid #f60;
    }

    .team-item__text {
        margin-top: 35px;
    }

    .thesis__text {
        font-style: italic;
        line-height: 1.5;
        position: relative;
        padding-left: 30px;
    }

    .thesis {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        background-color: #73b721;
        padding: 40px;
        color: #fff;
    }

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
