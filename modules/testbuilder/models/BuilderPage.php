<?php

namespace app\modules\testbuilder\models;

use Yii;

/**
 * This is the model class for table "keys_builder_page".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $class
 * @property string $seo_title
 * @property string $seo_desc
 * @property string $seo_key
 * @property string $footer_html
 * @property string $js
 * @property string $style
 *
 * @property BuilderBlocks[] $builderBlocks
 */
class BuilderPage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%builder_page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['footer_html'], 'string'],
            [['title', 'description', 'class', 'seo_title', 'seo_desc', 'seo_key', 'js', 'style'], 'string', 'max' => 255],
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
            'class' => 'Class',
            'seo_title' => 'Seo Title',
            'seo_desc' => 'Seo Desc',
            'seo_key' => 'Seo Key',
            'footer_html' => 'Footer Html',
            'js' => 'Js',
            'style' => 'Style',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilderBlocks()
    {
        return $this->hasMany(BuilderBlocks::className(), ['page_id' => 'id']);
    }
}
