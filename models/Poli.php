<?php

namespace app\models;

use app\models\mirai\PoliBpjs;
use app\models\mirai\PoliMapping;
use app\models\pegawai\UnitPenempatan;
use app\models\pendaftaran\KelompokUnitLayanan;

class Poli extends \yii\db\ActiveRecord
{
    public static function findAllPoli()
    {
        return KelompokUnitLayanan::find()->alias("layanan")
            ->select([
                "CAST(layanan.unit_id AS varchar) as poli_rs_id",
                "penempatan.nama as poli_rs_nama"
            ])
            ->leftJoin(UnitPenempatan::tableName() . " as penempatan", "layanan.unit_id::varchar = penempatan.kode::varchar")
            ->where(["layanan.type" => "2"])
            ->andWhere(["penempatan.aktif" => "1"])
            ->asArray()->all();
    }

    public static function findAllPoliUtama()
    {
        return KelompokUnitLayanan::find()->alias("layanan")
            ->select([
                "CAST(layanan.unit_id AS varchar) as poli_rs_id",
                "penempatan.nama as poli_rs_nama"
            ])
            ->leftJoin(UnitPenempatan::tableName() . " as penempatan", "layanan.unit_id::varchar = penempatan.kode::varchar")
            ->where(["layanan.type" => "5"])
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

    public static function findAllPoliRSByPoliBpjs($poliBpjsId)
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
            ->andWhere(["poli.poli_bpjs_id" => $poliBpjsId])
            ->asArray()->all();
    }
}
