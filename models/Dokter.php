<?php

namespace app\models;

use app\models\medis\JadwalDokter;

class Dokter extends \yii\db\ActiveRecord
{

  public static function findAllDokter()
  {
    return \Yii::$app->db->createCommand("select
          a.pegawai_id,
          a.id_nip_nrp,
          a.gelar_sarjana_depan,
          a.nama_lengkap,
          a.gelar_sarjana_belakang,
          b.unit_kerja,
          c.nama,
          b.sdm_rumpun,
          b.sdm_jenis
        from
          pegawai.tb_pegawai a 
          left join pegawai.tb_unit_plt_plh b on a.id_nip_nrp=b.id_nip_nrp
          left join pegawai.dm_unit_penempatan c on b.unit_kerja=c.kode
        where
          a.status_aktif_pegawai = 1 and b.status = 1 and b.sdm_rumpun = 1")->queryAll();
  }

  public static function findAllJadwalDokter($id_dokter)
  {
    return JadwalDokter::find()
      ->select([
        "id",
        "unit_kode",
        "pegawai_id",
        "tanggal",
        "jam_mulai",
        "jam_akhir",
        "keterangan",
        "status_datang"
      ])
      ->where(['>', "tanggal", date('Y-m-d')])
      ->andWhere(['!=', "is_deleted", "1"])
      ->andWhere(['pegawai_id' => $id_dokter])
      ->orderBy("tanggal asc")
      ->asArray()
      ->all();
  }
}
