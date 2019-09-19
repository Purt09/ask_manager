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
 * @property string $desc6
 * @property string $desc1
 * @property string $desc2
 * @property string $desc3
 * @property string $desc4
 * @property string $desc5
 * @property string $design
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
            [['text1', 'text2', 'text3', 'text4', 'text5', 'text6', 'desc1', 'desc2', 'desc3', 'desc4', 'desc5', 'desc6'], 'string'],
            [['image1', 'image2', 'image3', 'image4', 'image5', 'image6', 'design'], 'string', 'max' => 255],
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
            'design' => 'Design',
            'desc1' => 'Desc1',
            'desc2' => 'Desc2',
            'desc3' => 'Desc3',
            'desc4' => 'Desc4',
            'desc5' => 'Desc5',
            'desc6' => 'Desc6',
        ];
    }

    /** Дублирует себя
     * @param BuilderBlocks $block_old
     */
    public function duplicate(BuilderBlocks $block_old){
        $block_new = new BuilderListTable();
        $block_new->design = $this->design;
        $block_new->desc1 = $this->desc1;
        $block_new->desc2 = $this->desc2;
        $block_new->desc3 = $this->desc3;
        $block_new->desc4 = $this->desc4;
        $block_new->desc5 = $this->desc5;
        $block_new->desc6 = $this->desc6;
        $block_new->image1 = $this->image1;
        $block_new->image2 = $this->image2;
        $block_new->image3 = $this->image3;
        $block_new->image4 = $this->image4;
        $block_new->image5 = $this->image5;
        $block_new->image6 = $this->image6;
        $block_new->text1 = $this->text1;
        $block_new->text2 = $this->text2;
        $block_new->text3 = $this->text3;
        $block_new->text4 = $this->text4;
        $block_new->text5 = $this->text5;
        $block_new->text6 = $this->text6;
        $block_new->save();


        $block_old->duplicate($block_new->id);
    }
}
