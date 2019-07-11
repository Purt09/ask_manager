<?php

use yii\db\Migration;

/**
 * Class m190711_010015_Change_user_table
 */
class m190711_010015_Change_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'username', $this->string(32)->notNull()->unique());

        $this->alterColumn('{{%user}}', 'email', $this->string(64)->notNull()->unique());

        $this->alterColumn('{{%user}}', 'photo', $this->string(255)->defaultValue('/web/img/default/Not_photo_avatar.png'));

        $this->alterColumn('{{%user}}', 'photo_medium', $this->string(255)->defaultValue('/web/img/default/Not_photo_medium_avatar.png'));

        $this->alterColumn('{{%user}}', 'photo_big', $this->string(255)->defaultValue('/web/img/default/Not_photo_big_avatar.png'));


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190711_010015_Change_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190711_010015_Change_user_table cannot be reverted.\n";

        return false;
    }
    */
}
