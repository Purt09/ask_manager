<?php

use yii\db\Migration;

/**
 * Class m190908_062536_builder_page
 */
class m190908_062536_builder_page extends Migration
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

        $this->createTable('{{%builder_page}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->string(),
            'class' => $this->string(),
            'seo_title' => $this->string(),
            'seo_desc' => $this->string(),
            'seo_key' => $this->string(),
            'footer_html' => $this->text(),
            'js' => $this->string(),
            'style' => $this->string(),
        ], $tableOptions);

        $this->createIndex('idx-builder_page-id', '{{%builder_page}}', 'id');

        $this->createTable('{{%builder_blocks}}', [
            'id' => $this->primaryKey(),
            'position' => $this->integer(),
            'page_id' => $this->integer(),
            'builder_table' => $this->string(),
            'builder_id' => $this->integer(),
            'title' => $this->string(),
            'description' => $this->string(),
            'class' => $this->string(),
            'title_head' => $this->string(10),
            'title_color' => $this->string(10),
            'js' => $this->string(),
            'style' => $this->string(),
        ], $tableOptions);

        $this->createIndex('idx-builder_blocks-id', '{{%builder_blocks}}', 'id');

        $this->createIndex('idx-builder_blocks-builder_id', '{{%builder_blocks}}', 'builder_id');

        $this->createIndex('idx-builder_blocks-page_id', '{{%builder_blocks}}', 'page_id');

        $this->createTable('{{%builder_block_html}}', [
            'id' => $this->primaryKey(),
            'code' => $this->text(),
            'border' => $this->smallInteger(),
        ], $tableOptions);

        $this->addForeignKey('fk-blocks-page', '{{%builder_blocks}}', 'page_id', '{{%builder_page}}','id', 'CASCADE', 'RESTRICT');

        $this->addForeignKey('fk-blocks-block_html', '{{%builder_blocks}}', 'builder_id', '{{%builder_block_html}}','id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190908_062536_builder_page cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190908_062536_builder_page cannot be reverted.\n";

        return false;
    }
    */
}
