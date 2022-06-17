<?php

use yii\db\Migration;

/**
 * Class m220531_053525_create_add_users_column_to_shapes
 */
class m220531_053525_create_add_users_column_to_shapes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shapes}}', 'created_at', $this->integer());
        $this->addColumn('{{%shapes}}', 'updated_at', $this->integer());
        $this->addColumn('{{%shapes}}', 'created_by', $this->integer());
        $this->addColumn('{{%shapes}}', 'updated_by', $this->integer());
        $this->addForeignKey('fk_shapes_created_by', '{{%shapes}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_shapes_updated_by', '{{%shapes}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_shapes_created_by', '{{%shapes}}');
        $this->dropForeignKey('fk_shapes_updated_by', '{{%shapes}}');
        $this->dropColumn('{{%shapes}}', 'created_at');
        $this->dropColumn('{{%shapes}}', 'updated_at');
        $this->dropColumn('{{%shapes}}', 'created_by');
        $this->dropColumn('{{%shapes}}', 'updated_by');
    }

}
