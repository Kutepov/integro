<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project_steps}}`.
 */
class m200402_101950_create_project_steps_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project_steps}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('Название'),
            'begin_at' => $this->integer()->comment('Дата начала'),
            'end_at' => $this->integer()->comment('Дата завершения'),
            'is_template' => $this->boolean()->comment('Шаблон'),
            'is_substep' => $this->boolean()->comment('Подэтап'),
            'reason' => $this->text()->comment('Причины этапа'),
            'actions' => $this->text()->comment('Действия'),
            'position' => $this->integer()->comment('Позиция'),
            'parent_id' => $this->integer()->comment('Родительский этап'),
            'child_id' => $this->integer()->comment('Дочерний этап'),
            'status_id' => $this->smallInteger()->comment('Статус'),
            'project_id' => $this->integer()->comment('Проект'),
            'win_id' => $this->integer()->comment('Если выполнен, то запускаем'),
            'lose_id' => $this->integer()->comment('Если не выполнен, то запускаем'),
            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Обновлен'),
            'created_by' => $this->integer()->comment('Создал'),
            'updated_by' => $this->integer()->comment('Изменил'),
        ]);

        $this->createTable('{{%project_steps_statuses}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
        $this->batchInsert('{{%project_steps_statuses}}', ['name'], [['Выполненный'], ['В работе'], ['Предстоящий'], ['Невыполненный']]);

        $this->addForeignKey('FK_project_steps_parent_id', '{{%project_steps}}', 'parent_id', '{{%project_steps}}', 'id');
        $this->addForeignKey('FK_project_steps_child_id', '{{%project_steps}}', 'child_id', '{{%project_steps}}', 'id');
        $this->addForeignKey('FK_project_steps_win_id', '{{%project_steps}}', 'win_id', '{{%project_steps}}', 'id');
        $this->addForeignKey('FK_project_steps_lose_id', '{{%project_steps}}', 'lose_id', '{{%project_steps}}', 'id');
        $this->addForeignKey('FK_project_steps_status_id', '{{%project_steps}}', 'status_id', '{{%project_steps_statuses}}', 'id');

        $this->createTable('{{%project_steps_documents}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'path' => $this->string(),
            'extension' => $this->string(),
            'type_id' => $this->integer(),
            'project_step_id' => $this->integer()
        ]);

        $this->createTable('{{%project_steps_documents_types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);
        $this->batchInsert('{{%project_steps_documents_types}}', ['name'], [['Нормативные документы'], ['Вложенные документы']]);

        $this->addForeignKey('FK_project_steps_documents_type_id', '{{project_steps_documents}}', 'type_id', '{{%project_steps_documents_types}}', 'id');
        $this->addForeignKey('FK_project_steps_documents_project_step_id', '{{project_steps_documents}}', 'project_step_id', '{{%project_steps}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%project_steps_documents}}');
        $this->dropTable('{{%project_steps_documents_types}}');
        $this->dropTable('{{%project_steps}}');
        $this->dropTable('{{%project_steps_statuses}}');
    }
}
