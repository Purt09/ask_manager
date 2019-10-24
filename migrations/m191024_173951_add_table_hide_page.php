<?php

use yii\db\Migration;

/**
 * Class m191024_173951_add_table_hide_page
 */
class m191024_173951_add_table_hide_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%hide_page}}', [
            'id' => $this->primaryKey(),
            'code' => $this->text(),
            'url' => $this->string(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191024_173951_add_table_hide_page cannot be reverted.\n";
        $this->dropTable('{{%hide_page}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191024_173951_add_table_hide_page cannot be reverted.\n";

        return false;
    }
    */
}
