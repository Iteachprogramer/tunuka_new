<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shapes}}`.
 */
class m220530_131403_create_shapes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shapes}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shapes}}');
    }
}
