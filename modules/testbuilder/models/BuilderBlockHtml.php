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
    public static $TABLE = 'blok_html';
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

    /** Дублирует себя и родительский блок
     * @param BuilderBlocks $block_old
     * @param $page_id
     */
    public function duplicate(BuilderBlocks $block_old, $page_id){
        $block_new = new BuilderBlockHtml();
        $block_new->code = $this->code;
        $block_new->border = $this->border;
        $block_new->save();

        $block_old->duplicate($block_new->id, $page_id);
    }
}
