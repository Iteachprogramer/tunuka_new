<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%print_setting}}`.
 */
class m220616_122707_create_print_setting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%print_setting}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
            'width'=>$this->string(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer(),
            'updated_by'=>$this->integer(),
            'created_by'=>$this->integer(),
            'status'=>$this->integer(),
        ]);
        $this->addForeignKey('print_setting_updated_by','{{%print_setting}}','updated_by','{{%user}}','id','CASCADE','CASCADE');
        $this->addForeignKey('print_setting_created_by','{{%print_setting}}','created_by','{{%user}}','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('print_setting_updated_by','{{%print_setting}}');
        $this->dropForeignKey('print_setting_created_by','{{%print_setting}}');
        $this->dropTable('{{%print_setting}}');
    }
}
