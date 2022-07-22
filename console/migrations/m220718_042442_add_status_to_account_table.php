<?php

use yii\db\Migration;

/**
 * Class m220718_042442_add_status_to_account_table
 */
class m220718_042442_add_status_to_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%account}}', 'status', $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%account}}', 'status');
    }


}
