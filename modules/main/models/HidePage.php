<?php

namespace app\modules\main\models;

use Yii;

/**
 * This is the model class for table "keys_hide_page".
 *
 * @property int $id
 * @property string $code
 * @property string $url
 */
class HidePage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keys_hide_page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'string'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'url' => 'Url',
        ];
    }
}
