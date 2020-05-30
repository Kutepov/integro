<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%countries}}`.
 */
class m200222_200819_create_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%countries}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'area' => $this->integer(),
            'area_measurement' => $this->string(32),
            'capital' => $this->string(),
            'corruption_rank' => $this->integer(),
            'currency' => $this->string(64),
            'currency_to_usd' => $this->double(),
            'currency_to_usd_measurement' => $this->string(32),
            'currency_to_rub' => $this->double(),
            'currency_to_rub_amount' => $this->integer(),
            'currency_to_rub_measurement' => $this->string(32),
            'ease_of_doing_business_rank' => $this->integer(),
            'gdp_growth_rate' => $this->double(),
            'government_debt' => $this->double(),
            'government_debt_measurement' => $this->string(32),
            'government_revenues' => $this->double(),
            'government_revenues_measurement' => $this->string(32),
            'government_spending' => $this->double(),
            'government_spending_measurement' => $this->string(32),
            'government_type' => $this->string(32),
            'inflation_rate' => $this->double(),
            'land_border' => $this->integer(),
            'land_border_measurement' => $this->string(32),
            'language' => $this->string(64),
            'national_holiday' => $this->string(),
            'national_holiday_date' => $this->string(64),
            'phone_code' => $this->integer(),
            'population' => $this->integer(),
            'religion' => $this->string(512),
            'surplus_deficit' => $this->double(),
            'unemployment_rate' => $this->double(),
            'water_border' => $this->integer(),
            'water_border_measurement' => $this->string(32),
            'iso_country' => $this->string(10),
            'old' => $this->bigInteger(),
            'code' => $this->string(),
            'linked_guid' => $this->string(),
            'linked_id' => $this->bigInteger(),
            'airports' => $this->integer(),
            'autoroads' => $this->integer(),
            'tuberoads' => $this->integer(),
            'railroadsP' => $this->integer(),
            'railroadsC' => $this->integer(),
            'railroads' => $this->integer(),
            'VTO' => $this->smallInteger()
        ]);

        $this->createTable('{{%countries_custom_fields}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);

        $this->createTable('{{%countries_custom_fields_sections}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);

        $this->createTable('{{%countries_custom_fields_values}}', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer(),
            'custom_field_id' => $this->integer(),
            'custom_section_id' => $this->integer(),
            'value' => $this->string()
        ]);

        $this->addForeignKey(
            'FK_countries_custom_fields_values_country_id',
            '{{%countries_custom_fields_values}}',
            'custom_field_id',
            '{{%countries_custom_fields}}',
            'id'
            );

        $this->addForeignKey(
            'FK_countries_custom_fields_values_custom_section_id',
            '{{%countries_custom_fields_values}}',
            'custom_section_id',
            '{{%countries_custom_fields_sections}}',
            'id'
        );

        $this->addForeignKey(
            'FK_countries_custom_fields_values_countries',
            '{{%countries_custom_fields_values}}',
            'country_id',
            '{{%countries}}',
            'id'
        );

        $this->batchInsert('{{%countries_custom_fields_sections}}',
            ['id', 'name'],
            [
                [1, 'Общая информация'],
                [2, 'Транспорт'],
                [3, 'Экономические показатели'],
                [4, 'Правовые отношения'],
            ]
        );

        //Для тестов. В следующих миграциях заполнить корректными данными, а эти удалить
        $this->batchInsert('{{%countries}}', ['id', 'name'], [[1, 'Россия'], [2, 'США']]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%countries_custom_fields_values}}');
        $this->dropTable('{{%countries_custom_fields_sections}}');
        $this->dropTable('{{%countries_custom_fields}}');
        $this->dropTable('{{%countries}}');
    }
}
