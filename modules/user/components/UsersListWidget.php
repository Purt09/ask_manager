<?php

namespace app\modules\user\components;

use yii\base\Widget;

class UsersListWidget extends Widget
{
    public $users;

    public $button = [];

    public $tpl = 'usersListWidget';

    public $photo_size = 0;

    public $info = '';

    public function run()
    {
        return $this->render($this->tpl, [
            'users' => $this->users,
            'button' => $this->button,
            'photo_size' => $this->photo_size,
        ]);
    }
}