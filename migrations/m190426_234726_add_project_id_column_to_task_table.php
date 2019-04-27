<?php

use yii\db\Migration;

/**
 * Handles adding project_id to table `{{%task}}`.
 */
class m190426_234726_add_project_id_column_to_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%task}}', 'project_id', $this->integer());

        $this->alterColumn('{{%task}}', 'status', $this->smallInteger()->notNull()->defaultValue(1));

        $this->createIndex('idx-task-project_id', '{{%task}}', 'project_id');
        $this->createIndex('idx-task-status', '{{%task}}', 'status');

        $this->addForeignKey('fk-task-project', '{{%task}}', 'project_id', '{{%project}}', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%task}}', 'project_id');

        $this->alterColumn('{{%task}}', 'status', $this->integer()->notNull()->defaultValue(1));

        $this->dropIndex(
            'idx-task-project_id',
            '{{%task}}'
        );

        $this->dropIndex(
            'idx-task-status',
            '{{%task}}'
        );

        $this->dropForeignKey(
            'fk-task-project',
            '{{%project}}'
        );
    }
}
