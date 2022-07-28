<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%account}}`.
 */
class m220723_063408_add_order_number_column_to_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%account}}', 'order_number', $this->integer()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%account}}', 'order_number');
    }
}
