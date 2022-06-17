<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_payment_sum_column_to_outcome_group}}`.
 */
class m220607_104307_create_add_payment_sum_column_to_outcome_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%outcome_group}}', 'payment_sum', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%outcome_group}}', 'payment_sum');
    }
}
