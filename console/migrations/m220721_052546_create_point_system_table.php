<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%point_system}}`.
 */
class m220721_052546_create_point_system_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%point_system}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'point' => $this->float(),
        ]);
        $this->addForeignKey('fk_point_system_client_id', '{{%point_system}}', 'client_id', '{{%client}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_point_system_client_id', '{{%point_system}}');
        $this->dropTable('{{%point_system}}');
    }
}
