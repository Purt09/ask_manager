<?php

namespace app\modules\testbuilder\models;

use Yii;

/**
 * This is the model class for table "keys_builder_commands".
 *
 * @property int $id
 * @property int $design
 * @property int $col-sm
 * @property int $peoples
 *
 * @property BuilderCommandPeople[] $builderCommandPeoples
 */
class BuilderCommands extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keys_builder_commands';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['design', 'col-sm', 'peoples'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'design' => 'Design',
            'col-sm' => 'Col Sm',
            'peoples' => 'Peoples',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilderCommandPeoples()
    {
        return $this->hasMany(BuilderCommandPeople::className(), ['commands_id' => 'id']);
    }
}
