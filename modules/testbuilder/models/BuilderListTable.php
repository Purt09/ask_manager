<?php

namespace app\modules\testbuilder\models;

use Yii;

/**
 * This is the model class for table "keys_builder_list_table".
 *
 * @property int $id
 * @property int $list_id
 * @property string $image1
 * @property string $text1
 * @property string $image2
 * @property string $text2
 * @property string $image3
 * @property string $text3
 * @property string $image4
 * @property string $text4
 * @property string $image5
 * @property string $text5
 * @property string $image6
 * @property string $text6
 */
class BuilderListTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%builder_list_table}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['list_id'], 'integer'],
            [['text1', 'text2', 'text3', 'text4', 'text5', 'text6'], 'string'],
            [['image1', 'image2', 'image3', 'image4', 'image5', 'image6'], 'string', 'max' => 255],
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
            'image1' => 'Image1',
            'text1' => 'Text1',
            'image2' => 'Image2',
            'text2' => 'Text2',
            'image3' => 'Image3',
            'text3' => 'Text3',
            'image4' => 'Image4',
            'text4' => 'Text4',
            'image5' => 'Image5',
            'text5' => 'Text5',
            'image6' => 'Image6',
            'text6' => 'Text6',
        ];
    }

    public function getList()
    {
        return $this->hasOne(BuilderList::className(), ['id' => 'list_id']);
    }
}
