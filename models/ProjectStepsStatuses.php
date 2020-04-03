<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_steps_statuses".
 *
 * @property int $id
 * @property string|null $name
 * @property string $class
 * @property string $color
 *
 * @property ProjectSteps[] $projectSteps
 */
class ProjectStepsStatuses extends \yii\db\ActiveRecord
{
    /** @var string[]  */
    private $classes = [
        1 => 'complete',
        2 => 'in-work',
        3 => 'upcoming',
        4 => 'uncomplete'
    ];

    /** @var string[]  */
    private $colors = [
        1 => '#8bb85c',
        2 => '#f6cb00',
        3 => '#85898d',
        4 => '#db7235'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_steps_statuses';
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
     * Gets query for [[ProjectSteps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectSteps()
    {
        return $this->hasMany(ProjectSteps::class, ['status_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return 'step-'.$this->classes[$this->id];
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->colors[$this->id];
    }
}
