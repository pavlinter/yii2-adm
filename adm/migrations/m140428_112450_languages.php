<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 2.0.3
 */

use yii\db\Schema;

class m140428_112450_languages extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%language}}', [
            'id' => Schema::TYPE_PK,
            'code' => Schema::TYPE_STRING . '(16) NOT NULL',
            'name' => Schema::TYPE_STRING . '(20) NOT NULL',
            'image' => Schema::TYPE_STRING . '(250) NULL',
            'weight' => Schema::TYPE_INTEGER . ' NULL',
            'active' => Schema::TYPE_BOOLEAN . '(1) NOT NULL DEFAULT 1',
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);


        $this->insert('{{%language}}', [
            'code' => 'en',
            'name' => 'English',
            'weight'=> 50,
            'updated_at' => time(),
        ]);

        $this->insert('{{%language}}', [
            'code' => 'ru',
            'name' => 'Russian',
            'weight'=> 100,
            'updated_at' => time(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%language}}');
    }
}
