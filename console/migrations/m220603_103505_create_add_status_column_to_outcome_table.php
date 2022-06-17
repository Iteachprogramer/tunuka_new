<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_status_column_to_outcome}}`.
 */
class m220603_103505_create_add_status_column_to_outcome_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%outcome}}', 'status', $this->integer()->defaultValue(0));
        $this->addColumn('{{%outcome}}', 'group_id', $this->integer());
        $this->addForeignKey('fk_outcome_group', '{{%outcome}}', 'group_id', '{{%outcome_group}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_outcome_group', '{{%outcome}}');
        $this->dropColumn('{{%outcome}}', 'status');
        $this->dropColumn('{{%outcome}}', 'group_id');
    }
}
