<?php

namespace app\modules\testbuilder\models;

use Yii;

/**
 * This is the model class for table "keys_builder_commands".
 *
 * @property int $id
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
        return '{{%builder_commands}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
