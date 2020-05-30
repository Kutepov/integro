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

        $this->insert('{{%users}}', [
            'username' => 'manager',
            'email' => 'manager@integro.local',
            'full_name' => 'Менеджер',
            'password' => Yii::$app->security->generatePasswordHash('manager'),
            'role_id' => 2
        ]);

        $this->insert('{{%users}}', [
            'username' => 'head',
            'email' => 'head@integro.local',
            'full_name' => 'Руководитель',
            'password' => Yii::$app->security->generatePasswordHash('head'),
            'role_id' => 4
        ]);

        $this->update('{{%users}}', ['role_id' => 3], ['username' => 'admin']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_users_role_id', '{{%users}}');
        $this->dropTable('{{%users_roles}}');
    }
}
