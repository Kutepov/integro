<?php

use yii\db\Migration;

/**
 * Class m200606_160902_create_table_gallery
 */
class m200606_160902_create_table_gallery extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%gallery}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(),
            'title' => $this->string(),
            'path' => $this->string(),
            'type' => $this->string()->comment('Фото/видео'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey('FK_gallery_project_project_id', '{{%gallery}}', 'project_id', '{{%projects}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_gallery_project_project_id', '{{%gallery}}');
        $this->dropTable('{{%gallery}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200606_160902_create_table_gallery cannot be reverted.\n";

        return false;
    }
    */
}
