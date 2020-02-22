<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m200222_175125_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'email' => $this->string()->unique(),
            'password' => $this->string(),
            'full_name' => $this->string(),
            'ip' => $this->string(),
            'job_position' => $this->string(100)->comment('Должность'),
            'phone' => $this->string(30),
            'num_oz' => $this->string()->comment('Структурное подразделение'),
            'auth_key' => $this->string(50),
            'access_token' => $this->string(100),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'deactivation_at' => $this->integer(11),
            'pass_change_at' => $this->integer(11),
            'name_department' => $this->string(),
            'status' => $this->smallInteger(1)
        ]);

        $this->insert('{{%users}}', [
            'username' => 'admin',
            'email' => 'admin@int.org',
            'password' => Yii::$app->security->generatePasswordHash('admin')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
