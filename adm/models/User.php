<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.0
 */

namespace pavlinter\adm\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 10;
    const ROLE_ADM = 5;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['username'], 'unique'],
            [['email'], 'email'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(static::status())],

            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => array_keys(static::roles())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['adm-insert'] = ['username', 'email', 'status', 'role'];
        $scenarios['adm-updateOwn'] = ['username', 'email'];
        $scenarios['adm-update'] = ['username', 'email', 'status', 'role'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('modelAdm/user', 'Username'),
            'email' => Yii::t('modelAdm/user', 'Email'),
            'role' => Yii::t('modelAdm/user', 'Role'),
            'status' => Yii::t('modelAdm/user', 'Status'),
            'created_at' => Yii::t('modelAdm/user', 'Created'),
            'updated_at' => Yii::t('modelAdm/user', 'Updated'),
        ];
    }
    /**
     * @param null $key
     * @param null $default
     * @return array|null
     */
    public static function roles($key = null, $default = null)
    {
        $roles = [
            self::ROLE_USER => Yii::t('adm/user', 'User Role', ['dot' => false]),
            self::ROLE_ADM  => Yii::t('adm/user', 'Adm Role', ['dot' => false]),
        ];
        if ($key !== null) {
            if (isset($roles[$key])) {
                return $roles[$key];
            }
            return $default;
        }

        return $roles;
    }

    /**
     * @param null $key
     * @param null $default
     * @return array|null
     */
    public static function status($key = null, $default = null)
    {
        $status = [
            self::STATUS_ACTIVE     => Yii::t('adm/user', 'Active Status', ['dot' => false]),
            self::STATUS_DELETED    => Yii::t('adm/user', 'Deleted Status', ['dot' => false]),
        ];
        if ($key !== null) {
            if (isset($status[$key])) {
                return $status[$key];
            }
            return $default;
        }

        return $status;
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        if (isset(Yii::$app->params['user.passwordResetTokenExpire'])){
            $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        } else {
            $expire = 3600;
        }

        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
