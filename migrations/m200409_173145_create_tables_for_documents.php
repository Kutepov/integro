<?php

use yii\db\Migration;

/**
 * Class m200409_173145_create_tables_for_documents
 */
class m200409_173145_create_tables_for_documents extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%documents_folders}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'parent_folder_id' => $this->integer(),
            'project_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey(
            'FK_documents_folders_parent_folder_id',
            '{{%documents_folders}}',
            'parent_folder_id',
            '{{%documents_folders}}',
            'id'
        );

        $this->addForeignKey(
            'FK_documents_folders_project_id',
            '{{%documents_folders}}',
            'project_id',
            '{{%projects}}',
            'id'
        );

        $this->createTable('{{%documents}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'path' => $this->string(),
            'extension' => $this->string(),
            'folder_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey(
            'FK_documents_folder_id',
            '{{%documents}}',
            'folder_id',
            '{{%documents_folders}}',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%documents}}');
        $this->dropTable('{{%documents_folders}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200409_173145_create_tables_for_documents cannot be reverted.\n";

        return false;
    }
    */
}
