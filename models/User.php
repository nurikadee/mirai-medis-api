<?php

namespace app\models;

use app\models\auth\UserIdentity;
use yii\behaviors\TimestampBehavior;
use Yii;

class User extends UserIdentity
{
    const STATUS_ACTIVE   = 10;
    const STATUS_INACTIVE = 1;
    const STATUS_DELETED  = 0;

    public $statusList = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_DELETED  => 'Deleted'
    ];

    public function rules()
    {
        return [
            [['no_rekam_medis', 'tanggal_lahir', 'password_hash', 'status', 'auth_key'], 'required'],
            [['no_rekam_medis', 'no_identitas', 'password_hash', 'auth_key', 'password_reset_token', 'account_activation_token', 'created_at', 'updated_at'], 'string'],
            [['tanggal_lahir'], 'safe'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_rekam_medis' => 'No Rekam Medis',
            'no_identitas' => 'No Identitas',
            'tanggal_lahir' => 'Tanggal Lahir',
            'password_hash' => 'Password Hash',
            'status' => 'Status',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'account_activation_token' => 'Account Activation Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public static function findByNoRekamMedisOrNoId($username)
    {
        return User::find()
            ->where(['no_identitas' => $username])
            ->orWhere(['no_rekam_medis' => $username])
            ->one();
    }

    public static function findByNoRekamMedis($no_rekam_medis)
    {
        return static::findOne(['no_rekam_medis' => $no_rekam_medis]);
    }

    public static function findByNoId($no_identitas)
    {
        return static::findOne(['no_identitas' => $no_identitas]);
    }

    public static function findByTanggalLahir($tanggal_lahir)
    {
        return static::findOne(['tanggal_lahir' => $tanggal_lahir]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => User::STATUS_ACTIVE,
        ]);
    }

    public static function findByAccountActivationToken($token)
    {
        return static::findOne([
            'account_activation_token' => $token,
            'status' => User::STATUS_INACTIVE,
        ]);
    }

    public function getStatusName($status)
    {
        return $this->statusList[$status];
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function generateAccountActivationToken()
    {
        $this->account_activation_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removeAccountActivationToken()
    {
        $this->account_activation_token = null;
    }
}
