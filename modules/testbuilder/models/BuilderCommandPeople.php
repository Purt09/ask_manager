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
 * @property string $image
 * @property int $image_h
 * @property int $image_w
 * @property string $image_border
 * @property string $job
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
            [['commands_id', 'image_h', 'image_w'], 'integer'],
            [['name', 'image', 'image_border', 'job'], 'string', 'max' => 255],
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
            'image' => 'Image',
            'image_h' => 'Image H',
            'image_w' => 'Image W',
            'image_border' => 'Image Border',
            'job' => 'Job',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommands()
    {
        return $this->hasOne(BuilderCommands::className(), ['id' => 'commands_id']);
    }

    /** Дублирование
     * @param BuilderCommands $commands
     * @return bool
     */
    public function duplicate(BuilderCommands $commands){
        $people = new BuilderCommandPeople();
        $people->name = $this->name;
        $people->content = $this->content;
        $people->commands_id = $commands->id;
        $people->image = $this->image;
        $people->image_h = $this->image_h;
        $people->image_w = $this->image_w;
        $people->image_border = $this->image_border;
        $people->job = $this->job;
        return $people->save();
    }
}
