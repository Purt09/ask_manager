<?php

namespace app\modules\testbuilder\models;

use Yii;

/**
 * This is the model class for table "builder_block_saved".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property int $block_id
 */
class BuilderBlockSaved extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%builder_block_saved}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['block_id'], 'integer'],
            [['title', 'description', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'image' => 'Image',
            'block_id' => 'Block ID',
        ];
    }
}
