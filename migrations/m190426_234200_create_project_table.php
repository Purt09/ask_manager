<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m190426_234200_create_project_table extends Migration
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

        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'time_at' => $this->integer(),
            'title' => $this->string()->notNull(),
            'description' => $this->string(),
            'parent_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-project-parent_id', '{{%project}}', 'parent_id');

        $this->addForeignKey('fk-project-parent', '{{%project}}', 'parent_id', '{{%project}}','id', 'CASCADE', 'RESTRICT');
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%project}}');

        $this->dropIndex(
            'idx-project-parent_id',
            'project'
        );

        $this->dropForeignKey(
            'fk-project-parent',
            'project'
        );
    }
}
