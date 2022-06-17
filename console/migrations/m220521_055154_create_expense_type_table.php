<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%expense_type}}`.
 */
class m220521_055154_create_expense_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%expense_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'status' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createIndex('expense_created_by_index','{{%expense_type}}','created_by');
        $this->createIndex('expense_updated_by_index','{{%expense_type}}','updated_by');
        $this->addForeignKey('expense_created_by','{{%expense_type}}','created_by','{{%user}}','id','CASCADE','CASCADE');
        $this->addForeignKey('expense_updated_by','{{%expense_type}}','updated_by','{{%user}}','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('expense_created_by','{{%expense_type}}');
        $this->dropForeignKey('expense_updated_by','{{%expense_type}}');
        $this->dropTable('{{%expense_type}}');
    }
}
