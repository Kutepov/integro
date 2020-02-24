<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects_agreements".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Projects[] $projects
 */
class ProjectsAgreements extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects_agreements';
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
     * Gets query for [[Projects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Projects::class, ['agreement_id' => 'id']);
    }
}
