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

    public static function findAllPoliMappingBpjs()
    {
        return PoliMapping::find()->alias("poli")
            ->select([
                "poli.poli_bpjs_id",
                "bpjs.poli_bpjs_nama",
                "poli.poli_rs_id",
                "penempatan.nama as poli_rs_nama"
            ])
            ->leftJoin(PoliBpjs::tableName() . " as bpjs", "poli.poli_bpjs_id::varchar = bpjs.poli_bpjs_id::varchar")
            ->leftJoin(UnitPenempatan::tableName() . " as penempatan", "poli.poli_rs_id::varchar = penempatan.kode::varchar")
            ->where(["penempatan.aktif" => "1"])
            ->asArray()->all();
    }
}
