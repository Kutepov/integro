<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_roles}}`.
 */
class m200224_214531_create_users_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_roles}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);

        $this->batchInsert('{{%users_roles}}',
            ['id', 'name'],
            [
                [1, '«Просмотр»'],
                [2, '«Куратор»'],
                [3, '«Администратор системы»'],
                [4, '«Руководитель»'],
            ]
        );

        $this->addColumn('{{%users}}', 'role_id', $this->integer());
        $this->addForeignKey('FK_users_role_id', '{{%users}}', 'role_id', '{{users_roles}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users_roles}}');
    }
}
