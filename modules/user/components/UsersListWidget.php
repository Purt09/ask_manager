<?php

namespace app\modules\user\components;

use yii\base\Widget;

class UsersListWidget extends Widget
{
    public $users = [];

    public $button_link_profile = false;

    public $tpl = 'usersListWidget';

    public function run()
    {

        return $this->render($this->tpl, [
            'users' => $this->users,
            'button_link_profile' => $this->button_link_profile,
        ]);
    }
}