<?php

namespace app\models;

use app\models\KelompokUnitLayanan;
use app\models\UnitPenempatan;

class Poli extends \yii\db\ActiveRecord
{
    public static function findAllPoli()
    {
        return KelompokUnitLayanan::find()->alias("layanan")
            ->select([
                "layanan.id",
                "layanan.unit_id",
                "penempatan.nama"
            ])
            ->leftJoin(UnitPenempatan::tableName() . " as penempatan", "layanan.unit_id::varchar = penempatan.kode::varchar")
            ->where(["layanan.type" => "2"])
            ->andWhere(["penempatan.aktif" => "1"])
            ->asArray()->all();
    }
}
