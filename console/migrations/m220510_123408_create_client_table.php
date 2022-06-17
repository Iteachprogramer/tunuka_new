<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client}}`.
 */
class m220510_123408_create_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'fulla_name' => $this->string(255)->notNull(),
            'phone' => $this->string(255),
            'debt' => $this->integer(),
            'client_type_id' => $this->integer(),
            'leader' => $this->string(),
            'text' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('fk_client_created_by', '{{%client}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_client_updated_by', '{{%client}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_client_created_by', '{{%client}}');
        $this->dropForeignKey('fk_client_updated_by', '{{%client}}');
        $this->dropTable('{{%client}}');
    }
}
