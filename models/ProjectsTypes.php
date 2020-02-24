<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects_types".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $code
 *
 * @property Projects[] $projects
 */
class ProjectsTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'string', 'max' => 255],
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
            'code' => 'Code',
        ];
    }

    /**
     * Gets query for [[Projects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Projects::class, ['type_id' => 'id']);
    }
}
