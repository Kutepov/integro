<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use Yii;

/**
 * This is the model class for table "documents".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $path
 * @property string|null $extension
 * @property int|null $folder_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property bool $is_preview
 *
 * @property DocumentsFolders $folder
 * @property Users $creator
 * @property USers $editor
 * @property UploadedFile $file
 * @property Projects $project
 */
class Documents extends ActiveRecord
{
    public $file;
    public $is_preview = false;

    /** @var string[] */
    public static $extensionsForPreview = [
        'png', 'gif', 'jpg', 'pdf', 'txt'
    ];

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        $this->is_preview = in_array($this->extension, self::$extensionsForPreview);
        return parent::afterFind();
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents';
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
            [['folder_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['folder_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'path', 'extension'], 'string', 'max' => 255],
            [['file'],
                'file',
                'extensions' => 'pdf, doc, docx, rtf, txt, xls, xlsx, ppt, pptx, bmp, tif, jpg, gif, png, zip, rar',
                'skipOnEmpty' => true,
                'maxSize' => 1024 * 1024 * 50
            ],
            [['folder_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentsFolders::class, 'targetAttribute' => ['folder_id' => 'id']],
        ];
    }

    /**
     * Gets query for [[Folder]].
     *
     * @return ActiveQuery
     */
    public function getFolder()
    {
        return $this->hasOne(DocumentsFolders::class, ['id' => 'folder_id']);
    }

    /**
     * Gets query for [[Users]]
     *
     * @return ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(Users::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Users]]
     *
     * @return ActiveQuery
     */
    public function getEditor()
    {
        return $this->hasOne(Users::class, ['id' => 'updated_by']);
    }

    /**
     * @return Projects
     */
    public function getProject()
    {
        $rootFolder = $this->folder;
        while (!$rootFolder->project_id) {
            $rootFolder = $rootFolder->parentFolder;
        }
        return $rootFolder->project;
    }

    /**
     * @param array $data
     * @param null $formName
     * @return bool
     */
    public function load($data, $formName = null)
    {
        if (parent::load($data, $formName)) {
            $this->file = UploadedFile::getInstance($this, 'file');
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function upload()
    {
        if ($this->validate()) {
            $url = '/uploads/projects/' . $this->project->id .'/documents/';
            $filename = $this->file->baseName . time() . '.' . $this->file->extension;
            $path = Yii::getAlias('@webroot').$url;
            FileHelper::createDirectory($path);
            $path .= $filename;
            if ($this->file->saveAs($path)) {
                $this->name = $this->file->baseName;
                $this->extension = $this->file->extension;
                $this->path = $url.$filename;
                return $this->save(false);
            }
        } else {
            return false;
        }

        return false;
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
