<?php

namespace tests\_fixtures;

use yii\test\ActiveFixture;

class TaskFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\task\models\Task';
    public $dataFile = '@tests/_fixtures/data/task.php';
}