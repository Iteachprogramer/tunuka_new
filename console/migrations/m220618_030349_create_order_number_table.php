<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_number}}`.
 */
class m220618_030349_create_order_number_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_number}}', [
            'id' => $this->primaryKey(),
            'client_order_number' => $this->integer(),
            'finish_order_number' => $this->integer(),
            'date' => $this->integer(),
        ]);
        $this->insert('{{%order_number}}', array(
            'client_order_number' => 0,
            'finish_order_number' => 3000,
            'date' => time(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_number}}');
    }
}
