<?php

namespace app\models\pendaftaran;

class Pasien extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'pendaftaran.pasien';
    }

    public static function findByNoRekamMedisOrNoId($username)
    {
        return Pasien::find()
            ->where(['no_identitas' => $username])
            ->orWhere(['kode' => $username])
            ->one();
    }

    public static function findByNoRekamMedis($no_rekam_medis)
    {
        return static::findOne(['kode' => $no_rekam_medis]);
    }
}
