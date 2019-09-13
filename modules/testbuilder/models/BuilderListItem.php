<?php

namespace app\modules\testbuilder\models;

use Yii;

/**
 * This is the model class for table "keys_builder_list_item".
 *
 * @property int $id
 * @property int $list_id
 * @property string $content
 * @property string $image
 * @property string $title
 */
class BuilderListItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%builder_list_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['list_id'], 'integer'],
            [['content'], 'string'],
            [['image', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'list_id' => 'List ID',
            'content' => 'Content',
            'image' => 'Image',
            'title' => 'Title',
        ];
    }

    public function getList()
    {
        return $this->hasOne(BuilderList::className(), ['id' => 'list_id']);
    }
}
