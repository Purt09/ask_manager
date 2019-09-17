<?php

namespace app\modules\testbuilder\models;

use Yii;

/**
 * This is the model class for table "keys_builder_commands".
 *
 * @property int $id
 * @property string $design
 * @property int $peoples
 * @property int $col
 * @property int $gor_col_image
 * @property int $gor_col_content
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
        return [
            [['peoples', 'col', 'gor_col_image', 'gor_col_content'], 'integer'],
            [['design'], 'string', 'max' => 255],
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
            'peoples' => 'Peoples',
            'col' => 'Col',
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
