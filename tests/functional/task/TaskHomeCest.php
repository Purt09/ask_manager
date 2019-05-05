<?php

namespace functional\task;

use FunctionalTester;
use app\modules\task\models\Task;
use tests\_fixtures\TaskFixture;
use yii\helpers\Url;

class TaskHomeCest
{
    private $formId = '#user-form';

    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => TaskFixture::className(),
                'dataFile' => '@tests/_fixtures/data/task.php'
            ]
        ]);
        $I->amLoggedInAsAdmin();
    }

    public function home(FunctionalTester $I)
    {
        $I->amOnRoute('task/user');
        $I->seeInTitle('Tasks');
    }

    public function OpenCreate(FunctionalTester $I)
    {
        $I->amOnRoute('task/user/create');
        $I->seeInTitle('TASK_CREATE');
    }

    public function OpenOverdue(FunctionalTester $I)
    {
        $I->amOnRoute('task/user/done');
        $I->seeInTitle('Выполненные задачи');
    }

    public function OpenUpdate(FunctionalTester $I)
    {
        $I->amOnPage(['task/user/update', 'id' => 1]);
        $I->seeInTitle('UPDATE: test1');
    }
    public function viewWrong(FunctionalTester $I)
    {
        $I->amOnPage(['task/user/update', 'id' => 10000000]);
        $I->canSee('404');
    }
}