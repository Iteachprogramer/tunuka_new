<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_more_columns_to_outcome}}`.
 */
class m220526_044152_create_add_more_columns_to_outcome_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%outcome}}', 'created_at', $this->integer());
        $this->addColumn('{{%outcome}}', 'updated_at', $this->integer());
        $this->addColumn('{{%outcome}}', 'created_by', $this->integer());
        $this->addColumn('{{%outcome}}', 'updated_by', $this->integer());
        $this->addColumn('{{%outcome}}', 'cost', $this->float());
        $this->addForeignKey('fk_outcome_created_by', '{{%outcome}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_outcome_updated_by', '{{%outcome}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_outcome_created_by', '{{%outcome}}');
        $this->dropForeignKey('fk_outcome_updated_by', '{{%outcome}}');
        $this->dropColumn('{{%outcome}}', 'cost');
        $this->dropColumn('{{%outcome}}', 'created_at');
        $this->dropColumn('{{%outcome}}', 'updated_at');
        $this->dropColumn('{{%outcome}}', 'created_by');
        $this->dropColumn('{{%outcome}}', 'updated_by');
    }
}
