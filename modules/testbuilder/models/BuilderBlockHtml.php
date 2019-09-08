<?php

namespace app\modules\testbuilder\models;

use Yii;

/**
 * This is the model class for table "keys_builder_block_html".
 *
 * @property int $id
 * @property string $code
 * @property int $border
 *
 * @property BuilderBlocks[] $builderBlocks
 */
class BuilderBlockHtml extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%builder_block_html}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'string'],
            [['border'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'border' => 'Border',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilderBlocks()
    {
        return $this->hasMany(BuilderBlocks::className(), ['builder_id' => 'id']);
    }
}
