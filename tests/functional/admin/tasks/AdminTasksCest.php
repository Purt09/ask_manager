<?php

namespace tests\functional\admin\tasks;

use app\modules\user\models\User;
use app\modules\task\models\Task;
use FunctionalTester;
use tests\_fixtures\TaskFixture;
use yii\helpers\Url;

class AdminTasksCest
{
    private $formId = '#task-form';

    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'task' => [
                'class' => TaskFixture::className(),
                'dataFile' => '@tests/_fixtures/data/task.php'
            ]
        ]);
        $I->amLoggedInAs($I->grabRecord(User::className(), ['username' => 'admin']));
    }

    public function openCreate(FunctionalTester $I)
    {

        $I->amOnRoute('admin/tasks/create');
        $I->seeInTitle('TASK_CREATE');
    }
    public function viewExisting(FunctionalTester $I)
    {
        //$id = $I->grabRecord(User::className(), ['username' => 'admin-update'])->id;
        $I->amOnRoute('admin/tasks/view', ['id' => 1]);
        $I->seeInTitle('test1');
        $I->seeLink('UPDATE');
    }

    public function viewWrong(FunctionalTester $I)
    {
        $I->amOnPage(['admin/tasks/view', 'id' => 100000]);
        $I->canSee('404');
    }
    public function createWithEmptyFields(FunctionalTester $I)
    {
        $I->amOnRoute('admin/tasks/create');

        $I->submitForm($this->formId, [
            'Task[updated_at]' => '',
            'Task[project_id]' => '',
            'Task[title]' => '',
            'Task[description]' => '',
        ]);

        $I->see('Title cannot be blank.', '.help-block');
    }
    public function createSuccess(FunctionalTester $I)
    {
        $I->amOnRoute('admin/tasks/create');

        $I->submitForm($this->formId, [
            'Task[updated_at]' => '123',
            'Task[project_id]' => '',
            'Task[title]' => 'test2',
            'Task[description]' => 'test3',
        ]);



        $I->see('Tasks test2 test2');


    }

    public function updateSuccess(FunctionalTester $I)
    {

        $I->amOnRoute('admin/tasks/update', ['id' => 1]);

        $I->submitForm($this->formId, [
            'Task[updated_at]' => '123',
            'Task[project_id]' => '',
            'Task[title]' => 'UPDATE',
            'Task[description]' => 'test3',
        ]);

        $I->seeInTitle('UPDATE');
    }
}