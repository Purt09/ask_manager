<?php

namespace app\modules\user\models\connections;

/**
 * This is the ActiveQuery class for [[UserTask]].
 *
 * @see UserTask
 */
class UserTaskQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserTask[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserTask|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
