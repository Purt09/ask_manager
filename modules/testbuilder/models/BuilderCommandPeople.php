<?php

namespace app\modules\testbuilder\models;

use Yii;

/**
 * This is the model class for table "keys_builder_command_people".
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property int $commands_id
 * @property int $design
 * @property string $image
 * @property int $image_h
 * @property int $image_w
 * @property string $image_border
 *
 * @property BuilderCommands $commands
 */
class BuilderCommandPeople extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%builder_command_people}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['commands_id', 'design', 'image_h', 'image_w'], 'integer'],
            [['name', 'image', 'image_border'], 'string', 'max' => 255],
            [['commands_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuilderCommands::className(), 'targetAttribute' => ['commands_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'content' => 'Content',
            'commands_id' => 'Commands ID',
            'design' => 'Design',
            'image' => 'Image',
            'image_h' => 'Image H',
            'image_w' => 'Image W',
            'image_border' => 'Image Border',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommands()
    {
        return $this->hasOne(BuilderCommands::className(), ['id' => 'commands_id']);
    }
}
