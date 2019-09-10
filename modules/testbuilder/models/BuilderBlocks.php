<?php

namespace app\modules\testbuilder\models;

use Yii;

/**
 * This is the model class for table "keys_builder_blocks".
 *
 * @property int $id
 * @property int $position
 * @property int $page_id
 * @property string $builder_table
 * @property int $builder_id
 * @property string $title
 * @property string $description
 * @property string $class
 * @property string $title_head
 * @property string $title_color
 * @property string $js
 * @property string $style
 * @property int $style_margin_top
 * @property int $style_margin_bottom
 * @property int $style_media
 * @property int $css_isContainer
 * @property int $isLink
 * @property string $link_title
 *
 * @property BuilderBlockHtml $builder
 * @property BuilderPage $page
 */
class BuilderBlocks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keys_builder_blocks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position', 'page_id', 'builder_id', 'style_margin_top', 'style_margin_bottom', 'style_media', 'css_isContainer', 'isLink'], 'integer'],
            [['js', 'style'], 'string'],
            [['builder_table', 'title', 'description', 'class', 'link_title'], 'string', 'max' => 255],
            [['title_head', 'title_color'], 'string', 'max' => 10],
            [['builder_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuilderBlockHtml::className(), 'targetAttribute' => ['builder_id' => 'id']],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuilderPage::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => 'Position',
            'page_id' => 'Page ID',
            'builder_table' => 'Builder Table',
            'builder_id' => 'Builder ID',
            'title' => 'Title',
            'description' => 'Description',
            'class' => 'Class',
            'title_head' => 'Title Head',
            'title_color' => 'Title Color',
            'js' => 'Js',
            'style' => 'Style',
            'style_margin_top' => 'Style Margin Top',
            'style_margin_bottom' => 'Style Margin Bottom',
            'style_media' => 'Style Media',
            'css_isContainer' => 'Css Is Container',
            'isLink' => 'Is Link',
            'link_title' => 'Link Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilder()
    {
        return $this->hasOne(BuilderBlockHtml::className(), ['id' => 'builder_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(BuilderPage::className(), ['id' => 'page_id']);
    }
}
