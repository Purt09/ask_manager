<?php

use yii\db\Migration;

/**
 * Class m190913_020534_change_table_and_table_list
 */
class m190913_020534_change_table_and_table_list extends Migration
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

        $this->addColumn('{{%builder_page}}', 'css_background', $this->string()->defaultValue('FFFFFF')->notNull());
        $this->addColumn('{{%builder_command_people}}', 'job', $this->string());
        $this->alterColumn('{{%builder_commands}}', 'design', $this->string()->defaultValue('Вертикальный'));

        $this->createTable('{{%builder_list}}', [
            'id' => $this->primaryKey(),
            'col' => $this->smallInteger(),
            'content' => $this->text(),
            'design' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%builder_list_item}}', [
            'id' => $this->primaryKey(),
            'list_id' => $this->integer(),
            'content' => $this->text(),
            'image' => $this->string(),
            'title' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%builder_list_table}}', [
            'id' => $this->primaryKey(),
            'list_id' => $this->integer(),
            'image1' => $this->string(),
            'text1' => $this->text(),
            'image2' => $this->string(),
            'text2' => $this->text(),
            'image3' => $this->string(),
            'text3' => $this->text(),
            'image4' => $this->string(),
            'text4' => $this->text(),
            'image5' => $this->string(),
            'text5' => $this->text(),
            'image6' => $this->string(),
            'text6' => $this->text(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190913_020534_change_table_and_table_list cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190913_020534_change_table_and_table_list cannot be reverted.\n";

        return false;
    }
    */
}
