<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "projects".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $full_name
 * @property int|null $begin_at
 * @property int|null $end_at
 * @property string|null $description
 * @property string|null $linked_guid
 * @property int|null $linked_id
 * @property int|null $type_id
 * @property int|null $country_id
 * @property int|null $manager_id
 * @property int|null $ceo_id
 * @property int|null $agreement_id
 *
 * @property Countries $country
 * @property ProjectsAgreements $agreement
 * @property ProjectsTypes $type
 * @property Users $manager
 * @property Users $ceo
 * @property ProjectsCustomFields[] $projectsCustomFields
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['begin_at', 'end_at', 'linked_id', 'type_id', 'country_id', 'manager_id', 'ceo_id', 'agreement_id'], 'default', 'value' => null],
            [['linked_id', 'type_id', 'country_id', 'manager_id', 'ceo_id', 'agreement_id'], 'integer'],
            [['description'], 'string', 'max' => 2000],
            [['begin_at', 'end_at', 'name', 'full_name', 'linked_guid'], 'string', 'max' => 255],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::class, 'targetAttribute' => ['country_id' => 'id']],
            [['agreement_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectsAgreements::class, 'targetAttribute' => ['agreement_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectsTypes::class, 'targetAttribute' => ['type_id' => 'id']],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['manager_id' => 'id']],
            [['ceo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['ceo_id' => 'id']],
            [['full_name', 'type_id', 'country_id', 'name', 'begin_at', 'end_at', 'ceo_id'], 'required', 'message' => 'Поле не может быть пустым']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Краткое наименование',
            'full_name' => 'Полное название',
            'begin_at' => 'Начало проекта',
            'end_at' => 'Завершение проекта',
            'description' => 'Описание проекта',
            'linked_guid' => 'Linked Guid',
            'linked_id' => 'Linked ID',
            'type_id' => 'Тип проекта',
            'country_id' => 'Страна',
            'manager_id' => 'Проектный менеджер',
            'ceo_id' => 'Руководитель',
            'agreement_id' => 'Вид сделки',
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
     * Gets query for [[Agreement]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgreement()
    {
        return $this->hasOne(ProjectsAgreements::class, ['id' => 'agreement_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ProjectsTypes::class, ['id' => 'type_id']);
    }

    /**
     * Gets query for [[Manager]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(Users::class, ['id' => 'manager_id']);
    }

    /**
     * Gets query for [[Ceo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCeo()
    {
        return $this->hasOne(Users::class, ['id' => 'ceo_id']);
    }

    /**
     * Gets query for [[ProjectsCustomFields]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomFields()
    {
        return $this->hasMany(ProjectsCustomFields::class, ['project_id' => 'id']);
    }

    public static function getMenu()
    {
        if (Yii::$app->request->get('id') && $project = self::findOne(Yii::$app->request->get('id'))) {
            return [
                'Информация о проекте' => [
                    [
                        'name' => 'Описание',
                        'url' => Url::toRoute(['/project/view', 'id' => $project->id])
                    ],
                    [
                        'name' => 'Дорожная карта',
                        'url' => Url::toRoute(['/project/road-map', 'id' => $project->id])
                    ],
                    [
                        'name' => 'Дорожная карта',
                        'url' => Url::toRoute(['/project/documents', 'id' => $project->id])
                    ],
                    [
                        'name' => 'Галерея',
                        'url' => Url::toRoute(['/project/gallery', 'id' => $project->id])
                    ],
                    [
                        'name' => 'Диаграмма Ганта',
                        'url' => Url::toRoute(['/project/gunt', 'id' => $project->id])
                    ]
                ],
                'Ключевые показатели' => self::getIndicators($project->id),
                'Информация о стране' => [
                    [
                        'name' => 'Общая информация',
                        'url' => Url::toRoute(['/project/country', 'id' => $project->id, 'country_id' => $project->country_id, 'tab' => 'common'])
                    ],
                    [
                        'name' => 'Транспорт',
                        'url' => Url::toRoute(['/project/country', 'id' => $project->id, 'country_id' => $project->country_id, 'tab' => 'transport'])
                    ],
                    [
                        'name' => 'Экономические показатели',
                        'url' => Url::toRoute(['/project/country', 'id' => $project->id, 'country_id' => $project->country_id, 'tab' => 'economics'])
                    ],
                    [
                        'name' => 'Правовые отношения',
                        'url' => Url::toRoute(['/project/country', 'id' => $project->id, 'country_id' => $project->country_id, 'tab' => 'right'])
                    ]
                ],
                'Инструменты' => [
                    [
                        'name' => 'Добавить новый показатель',
                        'url' => '#',
                        'attributes' => [
                            'id' => 'js-btn-add-indicator'
                        ]
                    ]
                ]
            ];
        }
        return [];

    }

    /**
     * Получить список ключевых показателей для меню
     * @param $id
     * @return array[]
     */
    public static function getIndicators($id)
    {
        //TODO: Получить кастомные показатели и добавить в массив
        return [
            array(
                'name' => 'Выручка',
                //TODO: Сформировать урлы
                'url' => ''
            ),
            [
                'name' => 'EBITDA',
                //TODO: Сформировать урлы
                'url' => ''
            ]
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->begin_at = date('d.m.Y', $this->begin_at);
        $this->end_at = date('d.m.Y', $this->end_at);
    }

    public function beforeValidate()
    {
        $this->begin_at = strtotime($this->begin_at);
        $this->end_at = strtotime($this->end_at);
        return parent::beforeValidate();
    }
}
