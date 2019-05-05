<?php
/**
 * Created by PhpStorm.
 * User: Purtv
 * Date: 05.05.2019
 * Time: 15:58
 */

namespace tests\_fixtures;

use yii\test\ActiveFixture;

class ProjectFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\project\models\Project';
    public $dataFile = '@tests/_fixtures/data/project.php';
}