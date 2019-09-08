<?php

namespace app\modules\testbuilder\controllers;

use yii\web\Controller;
use app\modules\testbuilder\models\BuilderPage;
use app\modules\testbuilder\models\BuilderBlocks;
use app\modules\testbuilder\models\BuilderBlockHtml;

class AjaxController extends Controller
{
    public function actionAddBlockHtml($page_id, $title,$title_head, $title_color, $class, $border, $code){
        if (\Yii::$app->request->isAjax) {

            $block_html = new BuilderBlockHtml();
            $block_html->code = $code;
            $block_html->border = $border;
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

            return $this->redirect('/testbuilder/default/view?id=' . $page_id);

        } else {
            return $this->redirect('/');
        }
    }
}