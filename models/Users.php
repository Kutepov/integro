<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $email
 * @property string|null $password
 * @property string|null $full_name
 * @property string|null $ip
 * @property string|null $job_position Должность
 * @property string|null $phone
 * @property string|null $num_oz Структурное подразделение
 * @property string|null $auth_key
 * @property string|null $access_token
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deactivation_at
 * @property int|null $pass_change_at
 * @property string|null $name_department
 * @property int|null $status
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email', 'num_oz', 'name_department'], 'required'],
            [['created_at', 'updated_at', 'deactivation_at', 'pass_change_at', 'status'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'deactivation_at', 'pass_change_at', 'status'], 'integer'],
            [['username', 'email', 'password', 'full_name', 'ip', 'num_oz', 'name_department'], 'string', 'max' => 255],
            [['job_position', 'access_token'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 30],
            [['auth_key'], 'string', 'max' => 50],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'full_name' => 'ФИО',
            'ip' => 'IP',
            'job_position' => 'Должность',
            'phone' => 'Телефон',
            'num_oz' => 'Номера заявок в АС ОЗ',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deactivation_at' => 'Окончание активности учетной записи',
            'pass_change_at' => 'Дата смены пароля',
            'name_department' => 'Структурное подразделение',
            'status' => 'Статус',
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * @param $username
     * @return Users|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
}
