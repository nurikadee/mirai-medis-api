<?php

namespace app\models\pendaftaran;

class Debitur extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'pendaftaran.debitur';
    }

    public static function findAllDebitur()
    {
        return Debitur::find()->alias('deb')
            ->select([
                "deb.kode as kode_debitur",
                "deb.nama as nama_debitur",
                "debdet.kode as kode_debitur_detail",
                "debdet.nama as nama_debitur_detail"
            ])
            ->leftJoin(DebiturDetail::tableName() . " as debdet", "debdet.debitur_kode::varchar = deb.kode::varchar")
            ->where(["deb.aktif" => "1"])
            ->asArray()->all();
    }
}
