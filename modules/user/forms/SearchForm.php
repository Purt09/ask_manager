<?php

namespace app\modules\user\forms;

use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Form for search USser
 *
 * @property User|null $user This property is read-only.
 *
 */
class SearchForm extends Model
{
    public $query;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['query', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'query' => Yii::t('app', 'SEARCH_USER'),
        ];
    }

    public function searchUser($query)
    {

        foreach ($query as $search) {
            $search1 = str_replace(' ', '', $search);
        }


        return $users = User::find()->where(['like', 'username', $search1])->all();
    }
}