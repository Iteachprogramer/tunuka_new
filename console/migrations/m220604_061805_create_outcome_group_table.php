<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%outcome_group}}`.
 */
class m220604_061805_create_outcome_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%outcome_group}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'date' => $this->integer(),
            'status' => $this->integer(),
            'discount' => $this->integer(),
            'total' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('fk_outcome_group_client_id', '{{%outcome_group}}', 'client_id', '{{%client}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_outcome_group_created_by', '{{%outcome_group}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_outcome_group_updated_by', '{{%outcome_group}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_outcome_group_client_id', '{{outcome_group}}');
        $this->dropForeignKey('fk_outcome_group_created_by', '{{outcome_group}}');
        $this->dropForeignKey('fk_outcome_group_updated_by', '{{outcome_group}}');
        $this->dropTable('{{%outcome_group}}');
    }
}
