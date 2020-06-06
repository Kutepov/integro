<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "project_steps_documents".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $path
 * @property int|null $type_id
 * @property int|null $project_step_id
 * @property string|null $extension
 *
 * @property ProjectSteps $projectStep
 * @property ProjectStepsDocumentsTypes $type
 */
class ProjectStepsDocuments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_steps_documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'project_step_id'], 'default', 'value' => null],
            [['type_id', 'project_step_id'], 'integer'],
            [['name', 'path', 'extension'], 'string', 'max' => 255],
            [['project_step_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectSteps::class, 'targetAttribute' => ['project_step_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectStepsDocumentsTypes::class, 'targetAttribute' => ['type_id' => 'id']],
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
            'path' => 'Path',
            'type_id' => 'Type ID',
            'project_step_id' => 'Project Step ID',
        ];
    }

    /**
     * Gets query for [[ProjectStep]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectStep()
    {
        return $this->hasOne(ProjectSteps::class, ['id' => 'project_step_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ProjectStepsDocumentsTypes::class, ['id' => 'type_id']);
    }

    /**
     * @param UploadedFile $file
     * @param int $stepId
     * @param int $typeId
     * @param string $path
     * @return bool
     */
    public static function saveItem(UploadedFile $file, int $stepId, int $typeId, string $path): bool
    {
        $doc = new self();
        $doc->path = $path;
        $doc->name = $file->baseName;
        $doc->type_id = $typeId;
        $doc->extension = $file->extension;
        $doc->project_step_id = $stepId;
        return $doc->save();
    }

    /**
     * @return false|int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete()
    {
        if (FileHelper::unlink(Yii::getAlias('@webroot').$this->path)) {
            return parent::delete();
        }
        return false;
    }

}
