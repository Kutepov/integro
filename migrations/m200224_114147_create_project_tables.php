<?php

use yii\db\Migration;

/**
 * Class m200224_114147_create_project_tables
 */
class m200224_114147_create_project_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%projects}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'full_name' => $this->string(),
            'begin_at' => $this->integer(11),
            'end_at' => $this->integer(11),
            'description' => $this->text(),
            'linked_guid' => $this->string(),
            'linked_id' => $this->integer(),
            'type_id' => $this->integer(),
            'country_id' => $this->integer(),
            'manager_id' => $this->integer(),
            'ceo_id' => $this->integer(),
            'agreement_id' => $this->integer()
        ]);

        $this->createTable('{{projects_types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'code' => $this->string()
        ]);

        $this->batchInsert('{{projects_types}}',
            ['id', 'name', 'code'],
            [
                [1, 'Проект', 'project'],
                [2, 'Бизнес идея', 'idea'],
                [3, 'Архивный проект', 'archive']
            ]
        );

        $this->createTable('{{%projects_agreements}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);

        $this->batchInsert('{{%projects_agreements}}',
            ['id', 'name'],
            [
                [1, 'Строительство'],
                [2, 'Строительство и поставка'],
                [3, 'EPC-контракты'],
                [4, 'ГЧП / Концессия'],
                [5, 'Проекты на принципах проектного финансирования'],
                [6, 'M&A'],
            ]
            );

        $this->createTable('{{%projects_custom_fields}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'value' => $this->string(),
            'project_id' => $this->integer()
        ]);


        $this->addForeignKey(
            'FK_projects_type_id',
            '{{%projects}}',
            'type_id',
            '{{%projects_types}}',
            'id'
        );

        $this->addForeignKey(
            'FK_projects_country_id',
            '{{%projects}}',
            'country_id',
            '{{%countries}}',
            'id'
        );

        $this->addForeignKey(
            'FK_projects_manager_id',
            '{{%projects}}',
            'manager_id',
            '{{%users}}',
            'id'
        );

        $this->addForeignKey(
            'FK_projects_ceo_id',
            '{{%projects}}',
            'ceo_id',
            '{{%users}}',
            'id'
        );

        $this->addForeignKey(
            'FK_projects_agreement_id',
            '{{%projects}}',
            'agreement_id',
            '{{%projects_agreements}}',
            'id'
        );

        $this->addForeignKey(
            'FK_projects_custom_fields_project_id',
            '{{%projects_custom_fields}}',
            'project_id',
            '{{%projects}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%projects_custom_fields}}');
        $this->dropTable('{{%projects}}');
        $this->dropTable('{{%projects_agreements}}');
        $this->dropTable('{{%projects_types}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200224_114147_create_project_tables cannot be reverted.\n";

        return false;
    }
    */
}
