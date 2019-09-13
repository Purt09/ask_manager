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

    public function getListItem()
    {
        return $this->hasMany(BuilderListItem::className(), ['list_id' => 'id']);
    }

    public function getListTable()
    {
        return $this->hasMany(BuilderListTable::className(), ['list_id' => 'id']);
    }
}
