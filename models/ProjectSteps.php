<?php

namespace app\models;

use app\models\scopes\ProjectStepsQuery;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "project_steps".
 *
 * @property int $id
 * @property string|null $name Название
 * @property int|null $begin_at Дата начала
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
 * @property int|null $project_id Проект
 * @property int $position
 * @property array $arrForDropdown
 * @property array $exclude_files1
 * @property array $exclude_files2
 *
 * @property array $template_docs1
 * @property array $template_docs2
 *
 * @property UploadedFile[] $docs1
 * @property UploadedFile[] $docs2
 * @property ProjectSteps $parent
 * @property ProjectSteps $child
 * @property ProjectSteps $win
 * @property ProjectSteps $lose
 * @property ProjectStepsStatuses $status
 * @property Projects $project
 * @property ProjectStepsDocuments[] $projectStepsDocuments
 * @property ProjectStepsDocuments[] $projectStepsDocuments1
 * @property ProjectStepsDocuments[] $projectStepsDocuments2
 */
class ProjectSteps extends \yii\db\ActiveRecord
{
    public $docs1;
    public $docs2;
    public $template_docs1 = [];
    public $template_docs2 = [];
    public $exclude_files1;
    public $exclude_files2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_steps';
    }

    public static function find()
    {
        return new ProjectStepsQuery(get_called_class());
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
            [['status_id', 'parent_id', 'child_id', 'win_id', 'lose_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'project_id'], 'default', 'value' => null],
            [['status_id', 'parent_id', 'child_id', 'win_id', 'lose_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'project_id', 'position'], 'integer'],
            [['is_template', 'is_substep'], 'boolean'],
            [['is_template', 'is_substep'], 'default', 'value' => false],
            [['position'], 'default', 'value' => 1],
            [['name', 'begin_at', 'end_at', 'status_id'], 'required', 'message' => 'Поле не может быть пустым'],
            [['reason', 'actions'], 'string'],
            [['docs1', 'docs2'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 100],
            [['name', 'begin_at', 'end_at'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectSteps::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['child_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectSteps::class, 'targetAttribute' => ['child_id' => 'id']],
            [['win_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectSteps::class, 'targetAttribute' => ['win_id' => 'id']],
            [['lose_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectSteps::class, 'targetAttribute' => ['lose_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectStepsStatuses::class, 'targetAttribute' => ['status_id' => 'id']],
            [['exclude_files1', 'exclude_files2', 'template_docs1', 'template_docs2'], 'safe'],
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
            'begin_at' => 'Дата начала',
            'end_at' => 'Дата завершения',
            'status_id' => 'Статус',
            'is_template' => 'Сохранить этап, как шаблон',
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
     * @return \yii\db\ActiveQuery
     */
    public function getProjectStepsDocuments1()
    {
        return $this->getProjectStepsDocuments()->where(['type_id' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectStepsDocuments2()
    {
        return $this->getProjectStepsDocuments()->where(['type_id' => 2]);
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

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->docs1 as $index => $file) {
                if (!in_array($index, $this->exclude_files1)) {
                    $url = '/uploads/projects/' . $this->project_id .'/steps/'.$this->id.'/type-1/';
                    $filename = $file->baseName . time() . '.' . $file->extension;
                    $path = Yii::getAlias('@webroot').$url;
                    FileHelper::createDirectory($path);
                    $path .= $filename;
                    if ($file->saveAs($path)) {
                        ProjectStepsDocuments::saveItem($file, $this->id, 1, $url.$filename);
                    }
                }
            }
            foreach ($this->docs2 as $index =>  $file) {
                if (!in_array($index, $this->exclude_files2)) {
                    $url = '/uploads/projects/' . $this->project_id .'/steps/'.$this->id.'/type-2/';
                    $filename = $file->baseName . time() . '.' . $file->extension;
                    $path = Yii::getAlias('@webroot').$url;
                    FileHelper::createDirectory($path);
                    $path .= $filename;
                    if ($file->saveAs($path)) {
                        ProjectStepsDocuments::saveItem($file, $this->id, 2, $url.$filename);
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->begin_at = date('d.m.Y', $this->begin_at);
        $this->end_at = date('d.m.Y', $this->end_at);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeValidate()
    {
        $this->begin_at = (string)strtotime($this->begin_at) ?: $this->begin_at;
        $this->end_at = (string)strtotime($this->end_at) ?: $this->end_at;

        if (!is_array($this->exclude_files1)) {
            $this->exclude_files1 = explode(', ', $this->exclude_files1);
            unset($this->exclude_files1[count($this->exclude_files1) - 1]);
        }
        if (!is_array($this->exclude_files2)) {
            $this->exclude_files2 = explode(', ', $this->exclude_files2);
            unset($this->exclude_files2[count($this->exclude_files2) - 1]);
        }

        return parent::beforeValidate();
    }

    /**
     * @return array
     */
    public function getArrForDropdown()
    {
        $result = [];
        if ($this->isNewRecord && isset(Yii::$app->request->cookies['projectId'])) {
            $mainSteps = Projects::findOne(Yii::$app->request->cookies['projectId'])->mainSteps;
        }
        elseif (!$this->isNewRecord) {
            $mainSteps = $this->project->mainSteps;
        }
        else {
            return $result;
        }

        foreach ($mainSteps as $mainStep) {
            $result[$mainStep->id] = $mainStep->name;
            if ($children = $mainStep->getChain('child')) {
                foreach ($children as $child) {
                    $result[$child->id] = ' -> '.$child->name;
                }
            }
        }

        return $result;
    }

    /**
     * @param string $type
     * @param int $related_step_id
     * @return bool
     */
    public function updateRelations(string $type, int $related_step_id): bool
    {
        $relatedStep = self::findOne($related_step_id);
        if ($relatedStep) {
            switch ($type) {
                case 'right':
                    $this->position = $relatedStep->position + 1;
                    $this->is_substep = false;
                    $this->updatePositions('>', $this->project_id, $relatedStep->position);
                    $this->save();
                    return true;
                case 'left':
                    $this->position = $relatedStep->position;
                    $this->is_substep = false;
                    $this->updatePositions('>=', $this->project_id, $relatedStep->position);
                    $this->save();
                    return true;
                case 'child':
                    $this->child_id = $relatedStep->child_id;
                    $child = $relatedStep->child;
                    $relatedStep->child_id = $this->id;
                    $this->parent_id = $relatedStep->id;
                    if ($child) {
                        $child->parent_id = $this->id;
                        $child->save();
                    }
                    $this->is_substep = true;
                    $relatedStep->save();
                    $this->save();
                    return true;
                case 'top':
                    $this->parent_id = $relatedStep->parent_id;
                    $parent = $relatedStep->parent;
                    $relatedStep->parent_id = $this->id;
                    $this->child_id = $relatedStep->id;
                    if ($parent) {
                        $parent->child_id = $this->id;
                        $parent->save();
                    }
                    $this->is_substep = true;
                    $relatedStep->save();
                    $this->save();
                    return true;
                case 'bottom':
                    $this->child_id = $relatedStep->child_id;
                    $child = $relatedStep->child;
                    $relatedStep->child_id = $this->id;
                    $this->parent_id = $relatedStep->id;
                    if ($child) {
                        $child->parent_id = $this->id;
                        $child->save();
                    }
                    $this->is_substep = true;
                    $relatedStep->save();
                    $this->save();
                    return true;
                case 'first':
                    $this->is_substep = false;
                    $this->save();
                    return true;
                default:
                    return false;
            }
        }
        else {
            return false;
        }
    }

    /**
     * @param string $operation
     * @param int $project_id
     * @param int $position
     * @return bool
     */
    private function updatePositions(string $operation, int $project_id, int $position): bool
    {
        $rightSteps = self::find()
            ->where(['project_id' => $project_id])
            ->andWhere([$operation, 'position', $position])
            ->all();

        foreach ($rightSteps as $step) {
            $step->position = $step->position + 1;
            $step->save(false);
        }

        return true;
    }

    /**
     * @return bool
     */
    public function saveTemplateDocs()
    {
        if ($this->id) {
            foreach ($this->template_docs1 as $doc) {
                $this->saveTemplateDocById($doc);
            }

            foreach ($this->template_docs2 as $doc) {
                $this->saveTemplateDocById($doc);
            }
            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @return bool
     * @throws \yii\base\Exception
     */
    private function saveTemplateDocById($id)
    {
        $model = ProjectStepsDocuments::findOne($id);

        if (!$model) return false;

        $url = '/uploads/projects/' . $this->project_id .'/steps/'.$this->id.'/type-'.$model->type_id.'/';
        $path = Yii::getAlias('@webroot').$url;
        FileHelper::createDirectory($path);
        $filename = $model->name.time().'.'.$model->extension;
        $path .= $filename;

        if (copy(Yii::getAlias('@webroot').$model->path, $path)) {
            $newModel = new ProjectStepsDocuments();
            $newModel->name = $model->name;
            $newModel->path = $url.$filename;
            $newModel->extension = $model->extension;
            $newModel->type_id = $model->type_id;
            $newModel->project_step_id = $this->id;
            return $newModel->save();
        }

        return false;
    }

    /**
     * @param array $data
     * @param null $formName
     * @return bool
     */
    public function load($data, $formName = null)
    {
        if (parent::load($data, $formName)) {
            $this->docs1 = UploadedFile::getInstances($this, 'docs1');
            $this->docs2 = UploadedFile::getInstances($this, 'docs2');
            return true;
        }
        return false;
    }

    public function delete()
    {
        $this->overrideRelations();
        $this->removeRelations();
        $this->deleteAllDocuments();
        return parent::delete();
    }

    /**
     * @throws \Throwable
     * @throws \yii\base\ErrorException
     * @throws \yii\db\StaleObjectException
     */
    private function deleteAllDocuments()
    {
        foreach ($this->projectStepsDocuments as $document) {
            $document->delete();
        }
        $this->removeDocsDirectory();
    }

    /**
     * Удаляет всю дирректорию с документами проекта. Использовать крайне аккуратно, иначе можно потерять документы
     * @throws \yii\base\ErrorException
     */
    private function removeDocsDirectory()
    {
        FileHelper::removeDirectory(Yii::getAlias('@webroot').'/uploads/projects/'.$this->project_id.'/steps/'.$this->id);
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    private function overrideRelations()
    {
        if (!$this->is_substep) {
            return $this->removeAllChildren();
        }

        $model = self::findOne($this->id);

        $parent = $model->parent;
        $child = $model->child;
        if ($parent) {
            $parent->child_id = $model->child_id;
            $parent->save();
        }
        if ($child) {
            $child->parent_id = $model->parent_id;
            $child->save();
        }

        return true;
    }

    /**
     * Удаляет все подэтапы
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    private function removeAllChildren()
    {
        if (!$this->is_substep) {
            $children = $this->getChain('child', true);
            foreach ($children as $child) {
                $child->delete();
            }
            return true;
        }
        return false;
    }

    /**
     * Удалить все связи
     */
    private function removeRelations()
    {
        $this->child_id = null;
        $this->parent_id = null;
        $this->win_id = null;
        $this->lose_id = null;
        self::updateAll(['lose_id' => null], ['lose_id' => $this->id]);
        self::updateAll(['win_id' => null], ['win_id' => $this->id]);
        $this->save();
    }
}
