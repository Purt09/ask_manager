<?php

namespace tests\functional\user\profile;

use FunctionalTester;
use tests\_fixtures\UserFixture;

class ProfileUpdateCest
{
    private $formId = '#profile-update-form';

    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/_fixtures/data/user.php'
            ]
        ]);
        $I->amLoggedInAsUser();
        $I->amOnRoute('user/profile/update');
    }

    public function open(FunctionalTester $I)
    {
        $I->seeInTitle('Update');
        $I->seeElement($this->formId);
    }

    public function updateWithEmptyFields(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'User[email]' => '',
            'User[first_name]' => '',
            'User[last_name]' => '',
            'User[phone]' => '',
        ]);

        $I->see('Email cannot be blank.', '.help-block');
    }

    public function updateWithWrongFields(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'User[email]' => 'wrong-email',
            'User[first_name]' => 'First_alexFirst_alexFirst_alexFirst_alexFirst_alexFirst_alexFirst_alexFirst_alexFirst_alexFirst_alexFirst_alexFirst_alex',
            'User[last_name]' => 'Last_alexLast_alexLast_alexLast_alexLast_alexLast_alexLast_alexLast_alexLast_alexLast_alexLast_alexLast_alexLast_alex',
        ]);

        $I->see('Email is not a valid email address.', '.help-block');
        $I->see('Значение «Имя» должно содержать максимум 60 символа.', '.help-block');
        $I->see('Значение «Фамилия» должно содержать максимум 60 символа.', '.help-block');
    }

    public function updateSuccess(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'User[email]' => 'correct@email.com',
            'User[first_name]' => 'First_alex',
            'User[last_name]' => 'Last_alex',
        ]);

        $I->seeInTitle('Profile');
        $I->see('correct@email.com', '.detail-view');
        $I->see('First_alex', '.detail-view');
        $I->see('Last_alex', '.detail-view');
    }
}
