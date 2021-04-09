<?php

namespace app\models\mirai;

class Pendaftaran extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'mirai.tb_pendaftaran';
    }

    public static function getPendaftaran($no_rekam_medis, $poli_rs_id, $tanggal_kunjungan)
    {
        return \Yii::$app->db->createCommand("select 
         daf.id as pendaftaran_id,
         daf.no_rekam_medis,
         daf.tanggal_kunjungan,
         daf.tanggal_pendaftaran,
         daf.status_pembatalan,
         daf.note,
         deb.kode as kode_debitur,
         deb.nama as nama_debitur,
         antri.id as id_antrian,
         antri.nomor_antrian,
         tem.kode as poli_rs_id,
         tem.nama as poli_rs_nama
         from 
         mirai.tb_pendaftaran daf 
         left join mirai.tb_antrian antri on daf.id::varchar=antri.pendaftaran_id::varchar
         left join pendaftaran.debitur_detail deb on daf.debitur_id::varchar=deb.kode::varchar
         left join pegawai.dm_unit_penempatan tem on daf.poli_rs_id::varchar = tem.kode::varchar
         where 
         daf.no_rekam_medis = '$no_rekam_medis' 
         and daf.tanggal_kunjungan = '$tanggal_kunjungan' 
         and daf.poli_rs_id = '$poli_rs_id'")->queryOne();
    }
}
