<?php

namespace app\modules\testbuilder\controllers;

use app\modules\testbuilder\models\BuilderBlocks;
use app\modules\testbuilder\models\BuilderCommandPeople;
use app\modules\testbuilder\models\BuilderCommands;
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
        foreach ($blocks as $block) {
            if ($block['builder_table'] == 'blok_html')
                $block['builder_id'] = BuilderBlockHtml::find()->where(['id' => $block['builder_id']])->asArray()->one();
            if ($block['builder_table'] == 'blok_command') {
                $block['builder_id'] = BuilderCommands::find()->where(['id' => $block['builder_id']])->asArray()->one();
                $block['description']   = BuilderCommandPeople::find()->where(['commands_id' => $block['builder_id']['id']])->asArray()->all();
            }
        }

            if(Yii::$app->user->isGuest){
                return $this->render('view', [
                    'page' => $page,
                    'blocks' => $blocks,
                ]);
            } else {
                return $this->render('admin', [
                    'page' => $page,
                    'blocks' => $blocks,
                ]);
            }
    }
}
