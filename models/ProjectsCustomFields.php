<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects_custom_fields".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $value
 * @property int|null $project_id
 *
 * @property Projects $project
 */
class ProjectsCustomFields extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects_custom_fields';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id'], 'default', 'value' => null],
            [['project_id'], 'integer'],
            [['name', 'value'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::class, 'targetAttribute' => ['project_id' => 'id']],
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
            'value' => 'Value',
            'project_id' => 'Project ID',
        ];
    }

    /**
     * @param $projectId
     * @return int
     */
    public static function clearByProject($projectId)
    {
        return self::deleteAll(['project_id' => $projectId]);
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::class, ['id' => 'project_id']);
    }
}
