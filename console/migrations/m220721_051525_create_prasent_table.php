<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prasent}}`.
 */
class m220721_051525_create_prasent_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prasent}}', [
            'id' => $this->primaryKey(),
            'prasent' => $this->float(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('fk_prasent_created_by', '{{%prasent}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_prasent_updated_by', '{{%prasent}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_prasent_created_by', '{{%prasent}}');
        $this->dropForeignKey('fk_prasent_updated_by', '{{%prasent}}');
        $this->dropTable('{{%prasent}}');
    }
}
