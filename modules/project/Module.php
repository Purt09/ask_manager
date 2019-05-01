<?php

namespace app\modules\project;

use Yii;

/**
 * Project module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\project\controllers';

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/project/' . $category, $message, $params, $language);
    }
}
