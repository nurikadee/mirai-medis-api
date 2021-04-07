<?php

namespace app\models\medis;

use Yii;
use app\models\pendaftaran\Kelas;
use app\models\pendaftaran\Layanan;
use app\models\pegawai\UnitPenempatan;
class Kamar extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'medis.kamar';
    }
    function getLayanan()
    {
        return $this->hasMany(Layanan::className(),['kamar_id'=>'id']);
    }
    function getUnit()
    {
        return $this->hasOne(UnitPenempatan::className(),['kode'=>'unit_id']);
    }
    function getKelas()
    {
        return $this->hasOne(Kelas::className(),['kode'=>'kelas_rawat_kode']);
    }
    static function getListKamar($ruang=NULL,$kelas=NULL)
    {
        $query = self::find()->alias('km')->joinWith([
            'unit u',
            'kelas k'
        ],false)
        ->with([
            'layanan'=>function($q){
                $q->alias('l')->joinWith([
                    'registrasi'=>function($q){
                        $q->alias('reg')->joinWith(['pasien ps']);
                    }
                ],false);
                $q->select(['ps.kode as no_rekam_medis','ps.nama','l.kamar_id','l.registrasi_kode'])->andWhere("l.tgl_keluar is null and l.jenis_layanan = 3 and l.deleted_at is null and unit_tujuan_kode is null");
            }
        ])->select(['km.id','u.nama as ruang','k.nama as kelas','km.no_kamar','km.no_kasur'])
        ->where('km.aktif = 1 and km.is_deleted = 0')->asArray();
        if($ruang!=NULL){
            $query->andWhere(['km.unit_id'=>$ruang]);
        }
        if($kelas!=NULL){
            $query->andWhere(['kelas_rawat_kode'=>$kelas]);
        }
        return $query->all();
    }
}