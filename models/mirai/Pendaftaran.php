<?php

namespace app\models\mirai;

class Pendaftaran extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'mirai_medis.tb_pendaftaran';
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
         mirai_medis.tb_pendaftaran daf 
         left join mirai_medis.tb_antrian antri on daf.id::varchar=antri.pendaftaran_id::varchar
         left join pendaftaran.debitur_detail deb on daf.debitur_id::varchar=deb.kode::varchar
         left join pegawai.dm_unit_penempatan tem on daf.poli_rs_id::varchar = tem.kode::varchar
         where 
         daf.no_rekam_medis = '$no_rekam_medis' 
         and daf.tanggal_kunjungan = '$tanggal_kunjungan' 
         and daf.poli_rs_id = '$poli_rs_id'")->queryOne();
    }

    public static function getTransactionmirai_medis($no_rekam_medis)
    {
        return \Yii::$app->db->createCommand("select 
         CAST(daf.id as varchar) as pendaftaran_id,
         daf.no_rekam_medis,
         daf.tanggal_kunjungan,
         daf.tanggal_pendaftaran,
         daf.status_pembatalan,
         deb.kode as kode_debitur,
         deb.nama as nama_debitur,
         tem.kode as poli_rs_id,
         tem.nama as poli_rs_nama,
         false as layanan_web
         from 
         mirai_medis.tb_pendaftaran daf 
         left join pendaftaran.debitur_detail deb on daf.debitur_id::varchar=deb.kode::varchar
         left join pegawai.dm_unit_penempatan tem on daf.poli_rs_id::varchar = tem.kode::varchar
         where 
         daf.no_rekam_medis = '$no_rekam_medis'")->queryAll();
    }

    public static function getTransactionLayanan($no_rekam_medis)
    {
        return \Yii::$app->db->createCommand("select 
         r.kode as pendaftaran_id,
         r.pasien_kode as no_rekam_medis,
         to_date(cast(l.tgl_masuk as varchar), 'YYYY-MM-DD') as tanggal_kunjungan,
         r.created_at as tanggal_pendaftaran,
         0 as status_pembatalan,
         r.debitur_detail_kode as kode_debitur,
         deb.nama as nama_debitur,
         tem.kode as poli_rs_id,
         tem.nama as poli_rs_nama,
         true as layanan_web
        from pendaftaran.registrasi r 
        left join pendaftaran.layanan l on r.kode = l.registrasi_kode 
        left join pendaftaran.debitur_detail deb on r.debitur_detail_kode::varchar=deb.kode::varchar
        left join pegawai.dm_unit_penempatan tem on l.unit_kode::varchar = tem.kode::varchar
        where r.pasien_kode = '$no_rekam_medis'")->queryAll();
    }
}
