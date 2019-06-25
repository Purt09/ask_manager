<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m190331_200233_create_task_table extends Migration
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

        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'title' => $this->string()->notNull(),
            'description' => $this->string(),
            'project_id' => $this->integer(),
            'context_id' => $this->integer(),
            'user_id' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('idx-task-title', '{{%task}}', 'title');
        $this->createIndex('idx-task-updated_at', '{{%task}}', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task}}');
    }
}
