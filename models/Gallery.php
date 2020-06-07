<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use Yii;

/**
 * Class Gallery
 * @property integer $id
 * @property integer $project_id
 * @property string $title
 * @property string $path
 * @property string $type
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $thumbnail
 * @property array $videoExtensions
 *
 * @property UploadedFile $file
 * @property Projects $project
 */

class Gallery extends ActiveRecord
{
    const THUMBNAIL_VIDEO = 'images/video-play.png';
    public $videoExtensions = ['mp4', 'webm', 'ogg', '3gp', 'flv'];
    public $file;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%gallery}}';
    }

    /**
     * @return array|string[]
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::class, ['id' => 'project_id']);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, gif, png, mp4, webm, ogg, 3gp, flv'],
            [['type', 'title', 'path'], 'string'],
            [['project_id', 'type', 'title'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Файл',
            'title' => 'Название'
        ];
    }

    /**
     * Возвращает URI до миниатюры изображения
     * @return string
     */
    public function getThumbnail()
    {
        return  $this->type == 'video' ? self::THUMBNAIL_VIDEO : $this->path;
    }

    /**
     * @return bool|false
     * @throws \yii\base\Exception
     */
    public function upload()
    {
        if ($this->validate()) {
            $url = '/uploads/projects/' . $this->project->id .'/gallery/';
            $filename = $this->file->baseName . time() . '.' . $this->file->extension;
            $path = Yii::getAlias('@webroot').$url;
            FileHelper::createDirectory($path);
            $path .= $filename;
            if ($this->file->saveAs($path)) {
                $this->path = $url.$filename;
                return $this->save(false);
            }
        } else {
            return false;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->type = in_array($this->file->extension, $this->videoExtensions) ? 'video' : 'image';
        return parent::beforeValidate();
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