<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "countries_custom_fields_values".
 *
 * @property int $id
 * @property int|null $country_id
 * @property int|null $custom_field_id
 * @property int|null $custom_section_id
 * @property string|null $value
 *
 * @property Countries $country
 * @property CountriesCustomFields $customField
 * @property CountriesCustomFieldsSections $customSection
 */
class CountriesCustomFieldsValues extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries_custom_fields_values';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_id', 'custom_field_id', 'custom_section_id'], 'default', 'value' => null],
            [['country_id', 'custom_field_id', 'custom_section_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::class, 'targetAttribute' => ['country_id' => 'id']],
            [['custom_field_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountriesCustomFields::class, 'targetAttribute' => ['custom_field_id' => 'id']],
            [['custom_section_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountriesCustomFieldsSections::class, 'targetAttribute' => ['custom_section_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_id' => 'Country ID',
            'custom_field_id' => 'Custom Field ID',
            'custom_section_id' => 'Custom Section ID',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::class, ['id' => 'country_id']);
    }

    /**
     * Gets query for [[CustomField]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomField()
    {
        return $this->hasOne(CountriesCustomFields::class, ['id' => 'custom_field_id']);
    }

    /**
     * Gets query for [[CustomSection]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomSection()
    {
        return $this->hasOne(CountriesCustomFieldsSections::class, ['id' => 'custom_section_id']);
    }
}
