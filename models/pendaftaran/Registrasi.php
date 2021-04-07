<?php

namespace app\models\pendaftaran;

use Yii;
class Registrasi extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'pendaftaran.registrasi';
    }
    function getLayanan()
    {
        return $this->hasMany(Layanan::className(),['registrasi_kode'=>'kode']);
    }
    function getDebiturdetail()
    {
        return $this->hasOne(DebiturDetail::className(),['kode'=>'debitur_detail_kode']);
    }
    function getPasien()
    {
        return $this->hasOne(Pasien::className(),['kode'=>'pasien_kode']);
    }
    static function findRawatinapPasien($req)
    {
        $rm=$req->post('no_rekam_medis');
        return self::find()->alias('reg')->joinWith([
            'debiturdetail dd',
            'layanan l'=>function($q){
                $q->joinWith(['kamar kmr','unit u','unitasal ua','kelas kl'],false);
            }
        ],false)->select(['reg.pasien_kode as no_rekam_medis','reg.kode as no_registrasi',"TO_CHAR(l.tgl_masuk::TIMESTAMP,'DD-MM-YYYY HH24:MI') as tgl_masuk",'dd.nama as debitur','u.nama as ruang','ua.nama as ruang_asal','kmr.no_kamar','kmr.no_kasur','kl.nama as kelas'])->where(['reg.pasien_kode'=>$rm])->andWhere('l.jenis_layanan = 3 and reg.tgl_keluar is null and reg.deleted_at is null')->orderBy(['l.tgl_masuk'=>SORT_ASC])->asArray()->all();
    }
}