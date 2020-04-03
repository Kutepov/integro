<?php

namespace app\models;

use phpDocumentor\Reflection\Types\Boolean;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "project_steps".
 *
 * @property int $id
 * @property string|null $name Название
 * @property int|null $start_at Дата начала
 * @property int|null $end_at Дата завершения
 * @property int|null $status_id Статус
 * @property bool|null $is_template Шаблон
 * @property bool|null $is_substep Подэтап
 * @property int|null $parent_id Родительский этап
 * @property int|null $child_id Дочерний этап
 * @property int|null $win_id Если выполнен, то запускаем
 * @property int|null $lose_id Если не выполнен, то запускаем
 * @property string|null $reason Причины этапа
 * @property string|null $actions Действия
 * @property int|null $created_at Создан
 * @property int|null $updated_at Обновлен
 * @property int|null $created_by Создал
 * @property int|null $updated_by Изменил
 * @property int|null $project_id Изменил
 * @property int $position
 *
 * @property ProjectSteps $parent
 * @property ProjectSteps $child
 * @property ProjectSteps $win
 * @property ProjectSteps $lose
 * @property ProjectStepsStatuses $status
 * @property Projects $project
 * @property ProjectStepsDocuments[] $projectStepsDocuments
 */
class ProjectSteps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_steps';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_at', 'end_at', 'status_id', 'parent_id', 'child_id', 'win_id', 'lose_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'project_id'], 'default', 'value' => null],
            [['start_at', 'end_at', 'status_id', 'parent_id', 'child_id', 'win_id', 'lose_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'project_id', 'position'], 'integer'],
            [['is_template', 'is_substep'], 'boolean'],
            [['reason', 'actions'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectSteps::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['child_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectSteps::class, 'targetAttribute' => ['child_id' => 'id']],
            [['win_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectSteps::class, 'targetAttribute' => ['win_id' => 'id']],
            [['lose_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectSteps::class, 'targetAttribute' => ['lose_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectStepsStatuses::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'start_at' => 'Дата начала',
            'end_at' => 'Дата завершения',
            'status_id' => 'Статус',
            'is_template' => 'Шаблон',
            'is_substep' => 'Подэтап',
            'parent_id' => 'Родительский этап',
            'child_id' => 'Дочерний этап',
            'win_id' => 'Если выполнен, то запускаем',
            'lose_id' => 'Если не выполнен, то запускаем',
            'reason' => 'Причины этапа',
            'actions' => 'Действия',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'created_by' => 'Создал',
            'updated_by' => 'Изменил',
        ];
    }

    /**
     * Gets query for [[Project]]
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::class, ['id' => 'project_id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ProjectSteps::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[Child]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChild()
    {
        return $this->hasOne(ProjectSteps::class, ['id' => 'child_id']);
    }

    /**
     * Gets query for [[Win]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWin()
    {
        return $this->hasOne(ProjectSteps::class, ['id' => 'win_id']);
    }

    /**
     * Gets query for [[Lose]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLose()
    {
        return $this->hasOne(ProjectSteps::class, ['id' => 'lose_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(ProjectStepsStatuses::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[ProjectStepsDocuments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectStepsDocuments()
    {
        return $this->hasMany(ProjectStepsDocuments::class, ['project_step_id' => 'id']);
    }

    /**
     * @param string $type
     * @param bool $reverse
     * @return ProjectSteps[]
     */
    public function getChain(string $type, bool $reverse = false) : array
    {
        $type_id = $type.'_id';
        $result = [];

        /** @var self $model */
        $model = $this->$type;
        if ($model) {
            while ($model->$type_id) {
                $result[] = $model;
                $model = $model->$type;
            }
            $result[] = $model;
        }

        return $reverse ? array_reverse($result) : $result;
    }


    /**
     * @param $documentType
     * @return array|ProjectStepsDocuments[]
     */
    public function getDocuments($documentType)
    {
        return $this->getProjectStepsDocuments()->where(['type_id' => $documentType])->all();
    }
}
