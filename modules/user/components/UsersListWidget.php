<?php

namespace app\modules\user\components;

use yii\base\Widget;

class UsersListWidget extends Widget
{
    public $users;

    public $button = [];

    public $tpl = 'usersListWidget';

    public $photo_size = 0;

    public $limit = null;

    public $button_bottom = [];

    public function run()
    {
        if(count($this->users) >= $this->limit) {
            $this->button_bottom['status'] = true;
        }

        if($this->limit !== null){
            $this->users = array_slice($this->users, 0 , $this->limit);
        }
        return $this->render($this->tpl, [
            'users' => $this->users,
            'buttons' => $this->button,
            'photo_size' => $this->photo_size,
            'button_bottom' => $this->button_bottom,
        ]);
    }
}