<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.3
 */

use yii\db\Schema;
use yii\db\Migration;

class m141116_114354_rbac_data extends Migration
{
    public function up()
    {
        $this->batchInsert('{{%auth_rule}}', ['name', 'data', 'created_at', 'updated_at'],[
            [
                'Adm-IsOwnUser',
                'O:30:"pavlinter\\adm\\rbac\\OwnUserRule":3:{s:4:"name";s:9:"isOwnUser";s:9:"createdAt";i:'.time().';s:9:"updatedAt";i:'.time().';}',
                time(),
                time(),
            ],

        ]);

        $this->batchInsert('{{%auth_item}}', ['name', 'type', 'description', 'rule_name', 'data', 'created_at', 'updated_at'],[
            [
                'AdmRoot',
                1,
                'The main role for adm module',
                NULL,
                NULL,
                time(),
                time(),
            ],
            [
                'AdmAdmin',
                1,
                'The secondary role for adm module',
                NULL,
                NULL,
                time(),
                time(),
            ],
            [
                'Adm-FilesRoot',
                2,
                'Access to Media Files (Full access)',
                NULL,
                NULL,
                time(),
                time(),
            ],
            [
                'Adm-FilesAdmin',
                2,
                'Access to Media Files (Own directory)',
                NULL,
                NULL,
                time(),
                time(),
            ],
            [
                'Adm-Language',
                2,
                NULL,
                NULL,
                NULL,
                time(),
                time(),
            ],
            [
                'Adm-Transl',
                2,
                NULL,
                NULL,
                NULL,
                time(),
                time(),
            ],
            [
                'Adm-Transl:Html',
                2,
                'Can write html code',
                NULL,
                NULL,
                time(),
                time(),
            ],
            [
                'Adm-TranslRoot',
                2,
                'Full access to SourceMessage',
                NULL,
                NULL,
                time(),
                time(),
            ],
            [
                'Adm-UpdateOwnUser',
                2,
                'Update own adm profile',
                'Adm-IsOwnUser',
                NULL,
                time(),
                time(),
            ],
            [
                'Adm-User',
                2,
                NULL,
                NULL,
                NULL,
                time(),
                time(),
            ],

        ]);


        $this->batchInsert('{{%auth_item_child}}', ['parent', 'child'],[
            [
                'AdmAdmin',
                'Adm-FilesAdmin',
            ],
            [
                'AdmRoot',
                'Adm-FilesRoot',
            ],
            [
                'AdmRoot',
                'Adm-Language',
            ],
            [
                'Adm-TranslRoot',
                'Adm-Transl',
            ],
            [
                'AdmAdmin',
                'Adm-Transl',
            ],
            [
                'Adm-TranslRoot',
                'Adm-Transl:Html',
            ],
            [
                'AdmRoot',
                'Adm-TranslRoot',
            ],
            [
                'Adm-User',
                'Adm-UpdateOwnUser',
            ],
            [
                'AdmAdmin',
                'Adm-User',
            ],
            [
                'AdmRoot',
                'Adm-User',
            ],
        ]);

        $this->insert('{{%user}}',[
            'username' => 'adm',
            'auth_key' => '',
            'password_hash' => '$2y$13$ou51/VBEdXAQcLqwPYOFduppKv2EyE/KSGJkDrJZhPQyf3drRmKpu',
            'email' => 'adm@adm.com',
            'role' => 5,
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $user_id = $this->db->getLastInsertID();

        $this->insert('{{%auth_assignment}}',[
            'item_name' => 'AdmRoot',
            'user_id' => $user_id,
            'created_at' => time(),
        ]);
    }

    public function down()
    {
        echo "m141116_114354_rbac_data cannot be reverted.\n";
        return false;
    }
}
