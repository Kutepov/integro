<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "countries_custom_fields".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property CountriesCustomFieldsValues[] $countriesCustomFieldsValues
 */
class CountriesCustomFields extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries_custom_fields';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[CountriesCustomFieldsValues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountriesCustomFieldsValues()
    {
        return $this->hasMany(CountriesCustomFieldsValues::className(), ['custom_field_id' => 'id']);
    }
}
