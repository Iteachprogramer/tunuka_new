<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%outcome_item}}`.
 */
class m220601_084044_create_outcome_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%outcome_item}}', [
            'id' => $this->primaryKey(),
            'income_id' => $this->integer()->notNull(),
            'outcome_id' => $this->integer()->notNull(),
            'outcome_size' => $this->float(),
            'residue_size' => $this->float(),
        ]);
        $this->addForeignKey('fk_outcome_item_income', '{{%outcome_item}}', 'income_id', '{{%income}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_outcome_item_outcome', '{{%outcome_item}}', 'outcome_id', '{{%outcome}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_outcome_item_income', '{{%outcome_item}}');
        $this->dropForeignKey('fk_outcome_item_outcome', '{{%outcome_item}}');
        $this->dropTable('{{%outcome_item}}');
    }
}
