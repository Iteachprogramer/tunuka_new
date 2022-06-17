<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%units}}`.
 */
class m220510_100146_create_units_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%units}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('fk_units_created_by', '{{%units}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_units_updated_by', '{{%units}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_units_created_by', '{{%units}}');
        $this->dropForeignKey('fk_units_updated_by', '{{%units}}');
        $this->dropTable('{{%units}}');
    }
}
