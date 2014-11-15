<?php

use yii\db\Schema;

class m140428_105041_db_translation extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%source_message}}', [
            'id' => Schema::TYPE_PK,
            'category' => Schema::TYPE_STRING . '(32) NOT NULL',
            'message' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->createTable('{{%message}}', [
            'id' => Schema::TYPE_INTEGER,
            'language_id' => Schema::TYPE_INTEGER,
            'translation' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->addPrimaryKey('PRIM','{{%message}}',['id','language_id']);

        $this->addForeignKey('fk_message_source_message', '{{%message}}', 'id', '{{%source_message}}', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%message}}');
        $this->dropTable('{{%source_message}}');
    }
}