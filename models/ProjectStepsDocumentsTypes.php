<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_steps_documents_types".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property ProjectStepsDocuments[] $projectStepsDocuments
 */
class ProjectStepsDocumentsTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_steps_documents_types';
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
     * Gets query for [[ProjectStepsDocuments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectStepsDocuments()
    {
        return $this->hasMany(ProjectStepsDocuments::class, ['type_id' => 'id']);
    }
}
