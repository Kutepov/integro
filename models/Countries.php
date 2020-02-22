<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $area
 * @property string|null $area_measurement
 * @property string|null $capital
 * @property int|null $corruption_rank
 * @property string|null $currency
 * @property float|null $currency_to_usd
 * @property string|null $currency_to_usd_measurement
 * @property float|null $currency_to_rub
 * @property int|null $currency_to_rub_amount
 * @property string|null $currency_to_rub_measurement
 * @property int|null $ease_of_doing_business_rank
 * @property float|null $gdp_growth_rate
 * @property float|null $government_debt
 * @property string|null $government_debt_measurement
 * @property float|null $government_revenues
 * @property string|null $government_revenues_measurement
 * @property float|null $government_spending
 * @property string|null $government_spending_measurement
 * @property string|null $government_type
 * @property float|null $inflation_rate
 * @property int|null $land_border
 * @property string|null $land_border_measurement
 * @property string|null $language
 * @property string|null $national_holiday
 * @property string|null $national_holiday_date
 * @property int|null $phone_code
 * @property int|null $population
 * @property string|null $religion
 * @property float|null $surplus_deficit
 * @property float|null $unemployment_rate
 * @property int|null $water_border
 * @property string|null $water_border_measurement
 * @property string|null $iso_country
 * @property int|null $old
 * @property string|null $code
 * @property string|null $linked_guid
 * @property int|null $linked_id
 * @property int|null $airports
 * @property int|null $autoroads
 * @property int|null $tuberoads
 * @property int|null $railroadsP
 * @property int|null $railroadsC
 * @property int|null $railroads
 * @property boolean $VTO
 * @property CountriesCustomFieldsValues[] $countriesCustomFieldsValues
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['area', 'corruption_rank', 'currency_to_rub_amount', 'ease_of_doing_business_rank', 'land_border', 'phone_code', 'population', 'water_border', 'old', 'linked_id', 'airports', 'autoroads', 'tuberoads', 'railroadsP', 'railroadsC', 'railroads'], 'default', 'value' => null],
            [['area', 'corruption_rank', 'currency_to_rub_amount', 'ease_of_doing_business_rank', 'land_border', 'phone_code', 'population', 'water_border', 'old', 'linked_id', 'airports', 'autoroads', 'tuberoads', 'railroadsP', 'railroadsC', 'railroads'], 'integer'],
            [['currency_to_usd', 'currency_to_rub', 'gdp_growth_rate', 'government_debt', 'government_revenues', 'government_spending', 'inflation_rate', 'surplus_deficit', 'unemployment_rate'], 'number'],
            [['name', 'capital', 'national_holiday', 'code', 'linked_guid'], 'string', 'max' => 255],
            [['area_measurement', 'currency_to_usd_measurement', 'currency_to_rub_measurement', 'government_debt_measurement', 'government_revenues_measurement', 'government_spending_measurement', 'government_type', 'land_border_measurement', 'water_border_measurement'], 'string', 'max' => 32],
            [['currency', 'language', 'national_holiday_date'], 'string', 'max' => 64],
            [['religion'], 'string', 'max' => 512],
            [['iso_country'], 'string', 'max' => 10],
            [['VTO'], 'boolean']
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
            'area' => 'Территория квад. Км.',
            'area_measurement' => 'Area Measurement',
            'capital' => 'Столица',
            'corruption_rank' => 'Коррупция ранг',
            'currency' => 'Национальная валюта',
            'currency_to_usd' => 'Currency To Usd',
            'currency_to_usd_measurement' => 'Currency To Usd Measurement',
            'currency_to_rub' => 'Курс национальной валюты к Рублю',
            'currency_to_rub_amount' => 'Currency To Rub Amount',
            'currency_to_rub_measurement' => 'Currency To Rub Measurement',
            'ease_of_doing_business_rank' => 'Легкость ведения бизнеса',
            'gdp_growth_rate' => 'Темп роста ВВП кв. к кв., %',
            'government_debt' => 'Государственный долг',
            'government_debt_measurement' => 'Government Debt Measurement',
            'government_revenues' => 'Государственные доходы, млрд. руб.',
            'government_revenues_measurement' => 'Government Revenues Measurement',
            'government_spending' => 'Государственные расходы, млрд. руб.',
            'government_spending_measurement' => 'Government Spending Measurement',
            'government_type' => 'Форма правления',
            'inflation_rate' => 'Среднегодовой темп инфляции',
            'land_border' => 'Протяженность сухопутных границ',
            'land_border_measurement' => 'Land Border Measurement',
            'language' => 'Официальный язык',
            'national_holiday' => 'Крупные национальные праздники',
            'national_holiday_date' => 'Nation Holiday Date',
            'phone_code' => 'Телефонный код',
            'population' => 'Население',
            'religion' => 'Религия',
            'surplus_deficit' => 'Профицит/Дефицит',
            'unemployment_rate' => 'Уровень безработицы',
            'water_border' => 'Протяженность морского берега',
            'water_border_measurement' => 'Water Border Measurement',
            'iso_country' => 'Iso Country',
            'old' => 'Old',
            'code' => 'Code',
            'linked_guid' => 'Linked Guid',
            'linked_id' => 'Linked ID',
            'airports' => 'Количество аэропортов',
            'autoroads' => 'Протяженность автомобильных дорог (км)',
            'tuberoads' => 'Протяженность трубопровода (км)',
            'railroadsP' => 'Пассажироперевозки железнодорожным транспортом (млн. пассажиро-км)',
            'railroadsC' => 'Грузоперевозки железнодорожным транспортом (млн. тонн-км)',
            'railroads' => 'Протяженность ЖД путей (км)',
            'VTO' => 'Членство в ВТО'
        ];
    }

    /**
     * Gets query for [[CountriesCustomFieldsValues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountriesCustomFieldsValues()
    {
        return $this->hasMany(CountriesCustomFieldsValues::class, ['country_id' => 'id']);
    }
}
