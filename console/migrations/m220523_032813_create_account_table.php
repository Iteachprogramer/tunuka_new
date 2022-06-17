<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%account}}`.
 */
class m220523_032813_create_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%account}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'type_id' => $this->integer(),
            'sum' => $this->integer(),
            'dollar' => $this->integer(),
            'dollar_course' => $this->float(),
            'bank'=> $this->integer(),
            'total' => $this->integer(),
            'comment'=> $this->string(),
            'expense_type_id' => $this->integer(),
            'is_main' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'date'=> $this->integer(),
        ]);
        $this->addForeignKey('fk_account_client_id', '{{%account}}', 'client_id', '{{%client}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_account_expense_type_id', '{{%account}}', 'expense_type_id', '{{%expense_type}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_account_created_by', '{{%account}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_account_updated_by', '{{%account}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_account_client_id', '{{%account}}');
        $this->dropForeignKey('fk_account_expense_type_id','{{%account}}');
        $this->dropForeignKey('fk_account_created_by', '{{%account}}');
        $this->dropForeignKey('fk_account_updated_by', '{{%account}}');

        $this->dropTable('{{%account}}');
    }
}
