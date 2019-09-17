<?php

namespace app\modules\testbuilder\models;

use Yii;

/**
 * This is the model class for table "keys_builder_commands".
 *
 * @property int $id
 * @property string $design
 * @property int $peoples
 * @property int $col
 * @property int $gor_col_image
 * @property int $gor_col_content
 *
 * @property BuilderCommandPeople[] $builderCommandPeoples
 */
class BuilderCommands extends \yii\db\ActiveRecord
{
    public static $TABLE = 'block_command';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%builder_commands}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['peoples', 'col', 'gor_col_image', 'gor_col_content'], 'integer'],
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
            'design' => 'Design',
            'peoples' => 'Peoples',
            'col' => 'Col',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilderCommandPeoples()
    {
        return $this->hasMany(BuilderCommandPeople::className(), ['commands_id' => 'id']);
    }

    public function duplicate(BuilderBlocks $block_old){
        $block_new = new BuilderCommands();
        $block_new->design = $this->design;
        $block_new->col = $this->col;
        $block_new->gor_col_image = $this->gor_col_image;
        $block_new->gor_col_content = $this->gor_col_content;
        $block_new->save();

        $peoples = $this->getBuilderCommandPeoples()->all();
        foreach ($peoples as $people) $people->duplicate($block_new);

        $block_old->duplicate($block_new->id);
    }

}
