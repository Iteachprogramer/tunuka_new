<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%alter_dollar_columns_to_account}}`.
 */
class m220705_054734_create_alter_dollar_columns_to_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%account}}', 'dollar', $this->float()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       return false;
    }
}
