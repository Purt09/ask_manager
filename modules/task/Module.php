<?php

namespace app\modules\task;

use Yii;
/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\task\controllers';


    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/task/' . $category, $message, $params, $language);
    }
}
