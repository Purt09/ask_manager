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
 * @property int $css_isContainer
 * @property int $isLink
 * @property string $link_title
 * @property int $isHide
 * @property int $isDesktop
 * @property int $isTablet
 * @property int $isMobile
 * @property string css_background
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
        return '{{%builder_blocks}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position', 'page_id', 'builder_id', 'style_margin_top', 'style_margin_bottom', 'css_isContainer', 'isLink', 'isHide', 'isDesktop', 'isTablet', 'isMobile', 'builder_id'], 'integer'],
            [['js', 'style'], 'string'],
            [['builder_table', 'title', 'description', 'class', 'link_title', 'css_background'], 'string', 'max' => 255],
            [['title_head', 'title_color'], 'string', 'max' => 10],
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
            'css_isContainer' => 'Css Is Container',
            'isLink' => 'Is Link',
            'link_title' => 'Link Title',
            'isHide' => 'Is Hide',
            'isDesktop' => 'Is Desktop',
            'isTablet' => 'Is Tablet',
            'isMobile' => 'Is Mobile',
            'css_background' => 'background'
        ];
    }

    /**
 * @return \yii\db\ActiveQuery
 */
    public function getBuilderHtml()
    {
        return $this->hasOne(BuilderBlockHtml::className(), ['id' => 'builder_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilderCommand()
    {
        return $this->hasOne(BuilderCommands::className(), ['id' => 'builder_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilderList()
    {
        return $this->hasOne(BuilderList::className(), ['id' => 'builder_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilderListTable()
    {
        return $this->hasOne(BuilderListTable::className(), ['id' => 'builder_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(BuilderPage::className(), ['id' => 'page_id']);
    }

    public function duplicate($builder_id){
        $block = new BuilderBlocks();
        $block->title = $this->title;
        $block->page_id = $this->page_id;
        $block->title_head = $this->title_head;
        $block->title_color = $this->title_color;
        $block->class = $this->class;
        $block->builder_id = $builder_id;
        $block->builder_table = $this->builder_table;
        $block->save();

        $block->position = $block->id;
        return $block->save();
    }
}
