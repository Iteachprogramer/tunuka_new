<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dollar_course}}`.
 */
class m220512_132417_create_dollar_course_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dollar_course}}', [
            'id' => $this->primaryKey(),
            'course'=>$this->float(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer(),
            'created_by'=>$this->integer(),
            'updated_by'=>$this->integer(),
        ]);
        $this->addForeignKey('fk_dollar_course_created_by', '{{%dollar_course}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_dollar_course_updated_by', '{{%dollar_course}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_dollar_course_created_by', '{{%dollar_course}}');
        $this->dropForeignKey('fk_dollar_course_updated_by', '{{%dollar_course}}');
        $this->dropTable('{{%dollar_course}}');
    }
}
