<?php

namespace app\modules\testbuilder\models;

use Yii;

/**
 * This is the model class for table "keys_builder_list".
 *
 * @property int $id
 * @property int $col
 * @property string $content
 * @property string $design
 */
class BuilderList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%builder_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['col'], 'integer'],
            [['content'], 'string'],
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
            'col' => 'Col',
            'content' => 'Content',
            'design' => 'Design',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListItem()
    {
        return $this->hasMany(BuilderListItem::className(), ['list_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListTable()
    {
        return $this->hasMany(BuilderListTable::className(), ['list_id' => 'id']);
    }

    /** Дублирует себя и создает родительский блок с page_id
     * @param BuilderBlocks $block_old
     * @param $page_id
     */
    public function duplicate(BuilderBlocks $block_old, $page_id){
        $block_new = new BuilderList();
        $block_new->design = $this->design;
        $block_new->col = $this->col;
        $block_new->content = $this->content;
        $block_new->save();

        $items = $this->getListItem()->all();
        foreach ($items as $item) $item->duplicate($block_new);

        $block_old->duplicate($block_new->id, $page_id);
    }
}
