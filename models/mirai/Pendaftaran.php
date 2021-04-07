<?php

namespace app\models\mirai;

use app\models\pendaftaran\DebiturDetail;
use Yii;

/**
 * This is the model class for table "mirai.tb_pendaftaran".
 *
 * @property int $id
 * @property string $no_rekam_medis
 * @property string $poli_rs_id
 * @property string $tanggal_kunjungan
 * @property string|null $tanggal_pendaftaran
 * @property string $debitur_id
 * @property int $statuc_cetak_tracer
 * @property int $status_distribusi
 * @property int $status_pembatalan
 * @property string|null $no_kartu_bpjs
 * @property string|null $no_rujukan_bpjs
 * @property int|null $id_control_simrs
 * @property string|null $note
 * @property string|null $kode_booking_antrian_mobile_jkn
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Pendaftaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mirai.tb_pendaftaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_rekam_medis', 'poli_rs_id', 'tanggal_kunjungan', 'debitur_id'], 'required'],
            [['no_rekam_medis', 'poli_rs_id', 'tanggal_pendaftaran', 'debitur_id', 'no_kartu_bpjs', 'no_rujukan_bpjs', 'note', 'kode_booking_antrian_mobile_jkn', 'created_at', 'updated_at'], 'string'],
            [['tanggal_kunjungan'], 'safe'],
            [['statuc_cetak_tracer', 'status_distribusi', 'status_pembatalan', 'id_control_simrs'], 'default', 'value' => null],
            [['statuc_cetak_tracer', 'status_distribusi', 'status_pembatalan', 'id_control_simrs'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_rekam_medis' => 'No Rekam Medis',
            'poli_rs_id' => 'Poli Rs ID',
            'tanggal_kunjungan' => 'Tanggal Kunjungan',
            'tanggal_pendaftaran' => 'Tanggal Pendaftaran',
            'debitur_id' => 'Debitur ID',
            'statuc_cetak_tracer' => 'Statuc Cetak Tracer',
            'status_distribusi' => 'Status Distribusi',
            'status_pembatalan' => 'Status Pembatalan',
            'no_kartu_bpjs' => 'No Kartu Bpjs',
            'no_rujukan_bpjs' => 'No Rujukan Bpjs',
            'id_control_simrs' => 'Id Control Simrs',
            'note' => 'Note',
            'kode_booking_antrian_mobile_jkn' => 'Kode Booking Antrian Mobile Jkn',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
         antri.nomor_antrian
         from 
         mirai.tb_pendaftaran daf 
         left join mirai.tb_antrian antri on daf.id::varchar=antri.pendaftaran_id::varchar
         left join pendaftaran.debitur_detail deb on daf.debitur_id::varchar=deb.kode::varchar
         where 
         daf.no_rekam_medis = '$no_rekam_medis' 
         and daf.tanggal_kunjungan = '$tanggal_kunjungan' 
         and daf.poli_rs_id = '$poli_rs_id'")->queryOne();
    }
}
