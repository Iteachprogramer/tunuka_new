<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%outcome_group}}`.
 */
class m220721_064510_add_prasent_status_column_to_outcome_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%outcome_group}}', 'prasent_status', $this->integer()->defaultValue(0));
        $this->addColumn('{{%outcome_group}}', 'prasent_sum', $this->float()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%outcome_group}}', 'prasent_status');
        $this->dropColumn('{{%outcome_group}}', 'prasent_sum');
    }
}
