<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_debt_dollor_to_client}}`.
 */
class m220623_101141_create_add_debt_dollor_to_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('{{%client}}', 'debt_dollor', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('{{%client}}', 'debt_dollor');
    }
}
