<?php

namespace tests\functional\admin\projects;

use app\modules\user\models\User;
use FunctionalTester;
use tests\_fixtures\ProjectFixture;
use yii\helpers\Url;

class AdminProjectsCest
{
    private $formId = '#project-form';

    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'task' => [
                'class' => ProjectFixture::className(),
                'dataFile' => '@tests/_fixtures/data/project.php'
            ]
        ]);
        $I->amLoggedInAs($I->grabRecord(User::className(), ['username' => 'admin']));
    }

    public function openCreate(FunctionalTester $I)
    {

        $I->amOnRoute('admin/projects/create');
        $I->seeInTitle('CREATE_PROJECT');
    }
    public function viewExisting(FunctionalTester $I)
    {
        //$id = $I->grabRecord(User::className(), ['username' => 'admin-update'])->id;
        $I->amOnRoute('admin/projects/view', ['id' => 1]);
        $I->seeInTitle('project1');
        $I->seeLink('Update');
    }

    public function viewWrong(FunctionalTester $I)
    {
        $I->amOnPage(['admin/projects/view', 'id' => 100000]);
        $I->canSee('404');
    }
    public function createWithEmptyFields(FunctionalTester $I)
    {
        $I->amOnRoute('admin/projects/create');

        $I->submitForm($this->formId, [
            'Project[time_at]' => '',
            'Project[parent_id]' => '',
            'Project[title]' => '',
            'Project[description]' => '',
        ]);

        $I->see('Title cannot be blank.', '.help-block');
    }
    public function createSuccess(FunctionalTester $I)
    {
        $I->amOnRoute('admin/projects/create');

        $I->submitForm($this->formId, [
            'Project[time_at]' => '12321',
            'Project[parent_id]' => '2',
            'Project[title]' => 'project4',
            'Project[description]' => 'project4',
        ]);
        $I->see('project4 project4');
    }

    public function updateSuccess(FunctionalTester $I)
    {

        $I->amOnRoute('admin/projects/update', ['id' => 1]);

        $I->submitForm($this->formId, [
            'Project[time_at]' => '12321',
            'Project[parent_id]' => '2',
            'Project[title]' => 'project4',
            'Project[description]' => 'project4',
        ]);

        $I->seeInTitle('project4');
        $I->seeLink('Update');
    }
}