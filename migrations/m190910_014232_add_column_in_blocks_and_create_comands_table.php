<?php

use yii\db\Migration;

/**
 * Class m190910_014232_add_column_in_blocks_and_create_comands_table
 */
class m190910_014232_add_column_in_blocks_and_create_comands_table extends Migration
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

        $this->addColumn('{{%builder_blocks}}', 'style_margin_top', $this->integer()->defaultValue(0)->notNull() );
        $this->addColumn('{{%builder_blocks}}', 'style_margin_bottom', $this->integer()->defaultValue(0)->notNull() );
        $this->addColumn('{{%builder_blocks}}', 'style_media', $this->integer()->defaultValue(3000)->notNull() );
        $this->addColumn('{{%builder_blocks}}', 'css_isContainer', $this->smallInteger()->defaultValue(0)->notNull() );
        $this->addColumn('{{%builder_blocks}}', 'isLink', $this->smallInteger()->defaultValue(0)->notNull() );
        $this->addColumn('{{%builder_blocks}}', 'link_title', $this->string());
        $this->alterColumn('{{%builder_blocks}}', 'js', $this->text());
        $this->alterColumn('{{%builder_blocks}}', 'style', $this->text());

        $this->createTable('{{%builder_commands}}', [
            'id' => $this->primaryKey(),
        ], $tableOptions);

        $this->createTable('{{%builder_command_people}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'content' => $this->text(),
            'commands_id' => $this->integer(),
            'design' => $this->smallInteger()->defaultValue(0),
            'image' => $this->string(),
            'image_h' => $this->integer(),
            'image_w' => $this->integer(),
            'image_border' => $this->string()->defaultValue('0px 0px 0px 0px'),
        ], $tableOptions);

        $this->addForeignKey('fk-commands-people', '{{%builder_command_people}}', 'commands_id', '{{%builder_commands}}','id', 'CASCADE', 'RESTRICT');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190910_014232_add_column_in_blocks_and_create_comands_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190910_014232_add_column_in_blocks_and_create_comands_table cannot be reverted.\n";

        return false;
    }
    */
}
