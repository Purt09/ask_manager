<?php

namespace app\modules\testbuilder\controllers;

use app\modules\testbuilder\models\BuilderBlocks;
use app\modules\testbuilder\models\BuilderBlockSaved;
use app\modules\testbuilder\models\BuilderCommandPeople;
use app\modules\testbuilder\models\BuilderCommands;
use app\modules\testbuilder\models\BuilderList;
use app\modules\testbuilder\models\BuilderListItem;
use app\modules\testbuilder\models\BuilderListTable;
use app\modules\user\models\User;
use yii\web\Controller;
use app\modules\testbuilder\models\BuilderPage;
use app\modules\testbuilder\models\BuilderBlockHtml;
use Yii;

/**
 * Default controller for the `testbuilder` module
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($id)
    {
        $page = BuilderPage::findOne($id);

        $blocks = $page->getBuilderBlocks()->orderBy('position')->all();
        foreach ($blocks as $block)
            $this->generateBlock($block);

        $block_saved = new BuilderBlockSaved();
        $blocks_saved = $block_saved->find()->indexBy('id')->all();

            if(Yii::$app->user->isGuest){
                return $this->render('view', [
                    'page' => $page,
                    'blocks' => $blocks,
                ]);
            } else {
                return $this->render('admin', [
                    'page' => $page,
                    'blocks' => $blocks,
                    'blocks_saved' => $blocks_saved,
                ]);
            }
    }
    private function generateBlock(BuilderBlocks $block){

        if (($block['builder_table'] == 'blok_html') || ($block['builder_table'] == 'block_text'))
            $block['builder_id'] = $block->getBuilderHtml()->where(['id' => $block['builder_id']])->asArray()->one();
        if ($block['builder_table'] == 'block_command') {
            $block['builder_id'] = $block->getBuilderCommand()->where(['id' => $block['builder_id']])->one();
            $block['builder_id']->peoples = $block['builder_id']->getBuilderCommandPeoples()->where(['commands_id' => $block['builder_id']['id']])->asArray()->all();
            if($block['builder_id']->col == 1) return $block['builder_id']->col = 12;
            if($block['builder_id']->col == 2) return $block['builder_id']->col = 6;
            if($block['builder_id']->col == 3) return $block['builder_id']->col = 4;
            if($block['builder_id']->col == 4) return $block['builder_id']->col = 3;
            if($block['builder_id']->col == 6) return $block['builder_id']->col = 2;

        }
        if ($block['builder_table'] == 'block_list') {
            $block['builder_id'] = $block->getBuilderList()->where(['id' => $block['builder_id']])->one();
            if($block['builder_id']->col == 1) return $block['builder_id']->col = 12;
            if($block['builder_id']->col == 2) return $block['builder_id']->col = 6;
            if($block['builder_id']->col == 3) return $block['builder_id']->col = 4;
            if($block['builder_id']->col == 4) return $block['builder_id']->col = 3;
            if($block['builder_id']->col == 6) return $block['builder_id']->col = 2;
            $block['description'] = $block['builder_id']->getListItem()->where(['list_id' => $block['builder_id']['id']])->asArray()->all();
        }
        if ($block['builder_table'] == 'block_list_table')
            $block['builder_id'] = $block->getBuilderListTable()->where(['id' => $block['builder_id']])->one();
    }
}
