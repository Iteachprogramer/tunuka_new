<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_group_id_columns_to_account}}`.
 */
class m220701_092547_create_add_group_id_columns_to_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%account}}', 'group_id', $this->integer()->null()->defaultValue(null));
        $this->addForeignKey('fk_account_group_id', '{{%account}}', 'group_id', '{{%outcome_group}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_account_group_id', '{{%account}}');
        $this->dropColumn('{{%account}}', 'group_id');
    }
}
