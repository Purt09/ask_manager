<?php

namespace app\modules\testbuilder\controllers;

use app\modules\testbuilder\models\BuilderCommandPeople;
use app\modules\testbuilder\models\BuilderCommands;
use yii\web\Controller;
use app\modules\testbuilder\models\BuilderPage;
use app\modules\testbuilder\models\BuilderBlocks;
use app\modules\testbuilder\models\BuilderBlockHtml;

class AjaxController extends Controller
{
    // БЛОКИ
    /** Сохранение блока при быстром редактирование
     * @param $id
     * @param $title
     * @param $title_h
     * @param $title_color
     * @return bool|\yii\web\Response
     */
    public function actionBlockSaveTitle($id, $title, $title_h, $title_color, $isH = 0, $isD = 1, $isT = 1, $isM = 1)
    {
        if (\Yii::$app->request->isAjax) {
            $block = BuilderBlocks::findOne($id);
            $block->title = $title;
            $block->title_head = $title_h;
            $block->title_color = $title_color;
            ($isH == 'true') ? $block->isHide = 1 : $block->isHide = 0;
            ($isD == 'true') ? $block->isDesktop = 1 : $block->isDesktop = 0;
            ($isT == 'true') ? $block->isTablet = 1 : $block->isTablet = 0;
            ($isM == 'true') ? $block->isMobile = 1 : $block->isMobile = 0;
            return $block->save();
        } else {
            return $this->redirect('/');
        }
    }

    /**Сохранение всех данных блока при редактирование
     * @param $page_id
     * @param string $title
     * @param string $title_head
     * @param string $title_color
     * @param string $class
     * @param $id
     * @return bool|\yii\web\Response
     */
    public function actionBlockSaveData($page_id, $title = '', $title_head = '', $title_color = '', $class = '', $id, $mt = '', $mb = '', $isCont = '', $isLink = '', $link_title = '', $isH = 0, $isD = 1, $isT = 1, $isM = 1, $css_background = 'FFFFFF')
    {
        if (\Yii::$app->request->isAjax) {

            $block = BuilderBlocks::findOne($id);
            $block->title = $title;
            $block->page_id = $page_id;
            $block->title_head = $title_head;
            $block->title_color = $title_color;
            $block->class = $class;
            $block->style_margin_top = $mt;
            $block->style_margin_bottom = $mb;
            ($isCont == 'true') ? $block->css_isContainer = 1 : $block->css_isContainer = 0;
            ($isLink == 'true') ? $block->isLink = 1 : $block->isLink = 0;
            ($link_title == 'null') ? $block->link_title = ' ' : $block->link_title = $link_title;
            ($isH == 'true') ? $block->isHide = 1 : $block->isHide = 0;
            ($isD == 'true') ? $block->isDesktop = 1 : $block->isDesktop = 0;
            ($isT == 'true') ? $block->isTablet = 1 : $block->isTablet = 0;
            ($isM == 'true') ? $block->isMobile = 1 : $block->isMobile = 0;
            $block->css_background = $css_background;
            $block->save();

            return true;

        } else {
            return $this->redirect('/');
        }
    }

    /** Дублирование блока
     * Необходим прописывать каждый блок!
     * @param $id
     * @return \yii\web\Response
     */
    public function actionBlockDuplicate($id)
    {
        if (\Yii::$app->request->isAjax) {
            $block_old = BuilderBlocks::findOne($id);

            $block = new BuilderBlocks();
            $block->title = $block_old->title;
            $block->page_id = $block_old->page_id;
            $block->title_head = $block_old->title_head;
            $block->title_color = $block_old->title_color;
            $block->class = $block_old->class;

            if ($block_old->builder_table == 'blok_html') {
                $block_html_old = BuilderBlockHtml::findOne($block_old->builder_id);
                $block_html = new BuilderBlockHtml();
                $block_html->code = $block_html_old->code;
                $block_html->border = $block_html_old->border;
                $block_html->save();

                $block->builder_id = $block_html->id;
                $block->builder_table = 'blok_html';
            }
            if ($block_old->builder_table == 'block_command') {
                $block_command_old = BuilderCommands::findOne($block_old->builder_id);
                $block_command = new BuilderCommands();
                $block_command->col = $block_command_old->col;
                $block_command->design = $block_command_old->design;
                $block_command->save();

                $block->builder_id = $block_command->id;
                $block->builder_table = 'block_command';
            }
            $block->save();
            return $this->redirect('/testbuilder/default/index?id=' . $block_old->page_id);
        } else {
            return $this->redirect('/');
        }
    }

    /** Удаление блока
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionBlockDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
            $block = BuilderBlocks::findOne($id);
            if ($block->builder_table == 'blok_html') {
                $block_html = BuilderBlockHtml::findOne($block->builder_id);
                $block_html->delete();
            }
            if ($block->builder_table == 'block_command') {
                $block_command = BuilderCommands::findOne($block->builder_id);
                $block_command->delete();
            }
            $block->delete();
            return $this->redirect('/testbuilder/default/index?id=' . $page_id);
        } else {
            return $this->redirect('/');
        }
    }

    /** Сохранение настроек html блока
     * @param $id
     * @param $code
     * @param $border
     * @return bool|\yii\web\Response
     */
    public function actionBlockHtmlSave($id, $code, $border)
    {
        if (\Yii::$app->request->isAjax) {
            $block = BuilderBlockHtml::findOne($id);
            $block->code = $code;
            $block->border = $border;
            return $block->save();
        } else {
            return $this->redirect('/');
        }
    }

    /** Добавление html блока
     * @param $page_id
     * @param $title
     * @param $title_head
     * @param $title_color
     * @param $class
     * @param $border
     * @param $code
     * @return \yii\web\Response
     */
    public function actionBlockHtmlAdd($page_id, $title = 'Заголовок', $title_head = 'h2', $title_color, $class = '', $border = 0, $code = '')
    {
        if (\Yii::$app->request->isAjax) {
            $block_html = new BuilderBlockHtml();
            $block_html->code = $code;
            if ($border == 'true')
                $block_html->border = 1;
            else
                $block_html->border = 0;
            $block_html->save();

            $block = new BuilderBlocks();
            $block->title = $title;
            $block->page_id = $page_id;
            $block->title_head = $title_head;
            $block->title_color = $title_color;
            $block->builder_table = 'blok_html';
            $block->builder_id = $block_html->id;
            $block->class = $class;
            $block->save();

            $block->position = $block->id;
            $block->save();

            return $this->redirect('/testbuilder/default/index?id=' . $page_id);

        } else {
            return $this->redirect('/');
        }
    }

    /** Сохранение позици 2=ух блоков после перемещений их
     * @param $pos1
     * @param $pos2
     * @return \yii\web\Response
     */
    public function actionBlockSavePos($pos1, $pos2)
    {
        if (\Yii::$app->request->isAjax) {

            $block1 = BuilderBlocks::findOne($pos1);
            $block2 = BuilderBlocks::findOne($pos2);

            $pos = $block1->position;
            $block1->position = $block2->position;
            $block2->position = $pos;
            $block1->save();
            $block2->save();
            return $this->redirect('/testbuilder/default/index?id=' . $block1->page_id);

        } else {
            return $this->redirect('/');
        }
    }

    /** Создание блока Команда
     * @param $page_id
     * @param int $command_design
     * @param int $command_col
     * @param string $people_name
     * @param string $p_image
     * @param $p_image_h
     * @param $p_image_w
     * @param $p_image_b
     * @param string $title
     * @param string $title_head
     * @param $title_color
     * @param string $class
     * @return \yii\web\Response
     */
    public function actionBlockCommandsAdd($page_id, $command_design = 'Вертикальный', $command_col = 1, $people_name = '', $p_image = '', $p_image_h, $p_image_w, $p_image_b, $title = 'Заголовок', $title_head = 'h2', $title_color, $class = '', $col_image, $col_content)
    {
        if (\Yii::$app->request->isAjax) {
            $block_command = new BuilderCommands();
            $block_command->design = $command_design;
            $block_command->col = 12 / $command_col;
            $block_command->gor_col_content = $col_content;
            $block_command->gor_col_image = $col_image;
            $block_command->save();

            $people = new BuilderCommandPeople();
            $people->name = $people_name;
            if ($p_image == '')
                $p_image = 'http://placehold.it/' . $p_image_h . '/DC1734/fff&text=' . $people_name;
            $people->image = $p_image;
            $people->image_h = $p_image_h;
            $people->image_w = $p_image_w;
            $people->image_border = $p_image_b;
            $people->commands_id = $block_command->id;
            $people->save();


            $block = new BuilderBlocks();
            $block->title = $title;
            $block->page_id = $page_id;
            $block->title_head = $title_head;
            $block->title_color = $title_color;
            $block->builder_table = 'block_command';
            $block->builder_id = $block_command->id;
            $block->class = $class;
            $block->save();

            $block->position = $block->id;
            $block->save();

            return $this->redirect('/testbuilder/default/index?id=' . $page_id);

        } else {
            return $this->redirect('/');
        }
    }

    /** Добавление селовека в блок КОМАНДА
     * @param $page_id
     * @param string $people_name
     * @param string $p_image
     * @param $p_image_h
     * @param $p_image_w
     * @param $p_image_b
     * @param $content
     * @param $command_id
     * @return \yii\web\Response
     */
    public function actionBlockPeopleAddInCommand($page_id, $people_name = '', $p_image = '', $p_image_h, $p_image_w, $p_image_b, $content, $command_id)
    {
        if (\Yii::$app->request->isAjax) {
            $people = new BuilderCommandPeople();
            $people->name = $people_name;
            if ($p_image == '')
                $p_image = 'http://placehold.it/' . $p_image_h . '/DC1734/fff&text=' . $people_name;
            $people->content = $content;
            $people->image = $p_image;
            $people->image_h = $p_image_h;
            $people->image_w = $p_image_w;
            $people->image_border = $p_image_b;
            $people->commands_id = $command_id;
            $people->save();
            return $this->redirect('/testbuilder/default/index?id=' . $page_id);

        } else {
            return $this->redirect('/');
        }
    }


    /**
     * @param $id
     * @return false|int|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionBlockCommandPeopleDelete($id){
        if (\Yii::$app->request->isAjax) {

            $people = BuilderCommandPeople::findOne($id);
            return $people->delete();

        } else {
            return $this->redirect('/');
        }
    }


    /**
     * @param $id
     * @param $content
     * @param $commands_id
     * @param $image
     * @param $image_h
     * @param $image_w
     * @param $image_border
     * @param $job
     * @return false|int|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionBlockCommandPeopleSave($id, $name, $content, $image, $image_h, $image_w, $image_border, $job){
        if (\Yii::$app->request->isAjax) {

            $people = BuilderCommandPeople::findOne($id);
            $people->name = $name;
            $people->content = $content;
            if ($image == '')
                $image = 'http://placehold.it/' . $image_h . '/DC1734/fff&text=' . $name;
            $people->image = $image;
            $people->image_h = $image_h;
            $people->image_w = $image_w;
            $people->image_border = $image_border;
            $people->job = $job;
            return $people->save();

        } else {
            return $this->redirect('/');
        }
    }

    /** Сохранение настроек команды
     * @param $col
     * @param $design
     * @param $id
     * @return bool|\yii\web\Response
     */
    public function actionBlockCommandSave($col, $design, $id, $col_image, $col_content){
        if (\Yii::$app->request->isAjax) {
            $command = BuilderCommands::findOne($id);
            $command->col = 12 / $col;
            $command->design = $design;
            $command->gor_col_content = $col_content;
            $command->gor_col_image = $col_image;
            return  $command->save();

        } else {
            return $this->redirect('/');
        }
    }

    /** Обновление настроек страницы
     * @param $id
     * @param $title
     * @param $desc
     * @param $class
     * @param $seo_t
     * @param $seo_d
     * @param $seo_k
     * @param $foot
     * @param $js
     * @param $style
     * @return bool|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUpdatePage($id, $title, $desc, $class, $seo_t, $seo_d, $seo_k, $foot, $js, $style)
    {
        if (\Yii::$app->request->isAjax) {
            $page = BuilderPage::findOne($id);
            $page->title = $title;
            $page->description = $desc;
            $page->class = $class;
            $page->seo_title = $seo_t;
            $page->seo_desc = $seo_d;
            $page->seo_key = $seo_k;
            $page->footer_html = $foot;
            $page->js = $js;
            $page->style = $style;
            $page->update();
            return true;

        } else {
            return $this->redirect('/');
        }
    }



    /** Изменение заголовка ссылки!
     * @param $id
     * @param $link
     * @return bool|\yii\web\Response
     */
    public function actionMenuEditLink($id, $link)
    {
        if (\Yii::$app->request->isAjax) {
            $block = BuilderBlocks::findOne($id);
            $block->link_title = $link;
            $block->save();

            return true;

        } else {
            return $this->redirect('/');
        }
    }
}