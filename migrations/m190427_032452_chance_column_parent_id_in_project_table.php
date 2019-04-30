<?php

use yii\db\Migration;

/**
 * Class m190427_032452_chance_column_parent_id_in_project_table
 */
class m190427_032452_chance_column_parent_id_in_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%project}}', 'parent_id', $this->integer()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190427_032452_chance_column_parent_id_in_project_table cannot be reverted.\n";
        $this->alterColumn('{{%project}}', 'parent_id', $this->integer()->notNull());

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190427_032452_chance_column_parent_id_in_project_table cannot be reverted.\n";

        return false;
    }
    */
}
