<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "documents_folders".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $parent_folder_id
 * @property int|null $project_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Documents[] $documents
 * @property DocumentsFolders $parentFolder
 * @property DocumentsFolders[] $childFolders
 *
 * @property Projects $project
 */
class DocumentsFolders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents_folders';
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
            [['parent_folder_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['name'], 'required'],
            [['parent_folder_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['parent_folder_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentsFolders::class, 'targetAttribute' => ['parent_folder_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::class, 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя папки'
        ];
    }

    /**
     * Gets query for [[Projects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::class, ['id' => 'project_id']);
    }

    /**
     * Gets query for [[Documents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(Documents::class, ['folder_id' => 'id'])->orderBy(['id' => SORT_ASC]);
    }

    /**
     * Gets query for [[ParentFolder]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentFolder()
    {
        return $this->hasOne(DocumentsFolders::class, ['id' => 'parent_folder_id']);
    }

    /**
     * Gets query for [[DocumentsFolders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChildFolders()
    {
        return $this->hasMany(DocumentsFolders::class, ['parent_folder_id' => 'id']);
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            if (!(bool)$this->parent_folder_id) {
                $this->parent_folder_id = null;
            } else {
                $this->project_id = null;
            }
        }
        return parent::beforeValidate();
    }

    public function delete()
    {
        foreach ($this->childFolders as $folder) {
            $folder->delete();
        }

        foreach ($this->documents as $document) {
            $document->delete();
        }
        return parent::delete();
    }
}
