<?php

namespace app\models\pendaftaran;

use app\models\medis\Kamar;
use app\models\pegawai\UnitPenempatan;

class Layanan extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'pendaftaran.layanan';
    }
    function getKelas()
    {
        return $this->hasOne(Kelas::className(), ['kode' => 'kelas_rawat_kode']);
    }
    function getKamar()
    {
        return $this->hasOne(Kamar::className(), ['id' => 'kamar_id']);
    }
    function getUnit()
    {
        return $this->hasOne(UnitPenempatan::className(), ['kode' => 'unit_kode']);
    }
    function getUnitasal()
    {
        return $this->hasOne(UnitPenempatan::className(), ['kode' => 'unit_asal_kode']); //->alias('ua');
    }
    function getRegistrasi()
    {
        return $this->hasOne(Registrasi::className(), ['kode' => 'registrasi_kode']);
    }
}
