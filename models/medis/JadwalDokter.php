<?php

namespace app\models\medis;

/**
 * This is the model class for table "medis.jadwal_dokter_klinik".
 *
 * @property int $id
 * @property int $unit_kode reff pegawai.dm_unit_penempatan.kode
 * @property int $pegawai_id reff pegawai.tb_pegawai.pegawai_id
 * @property string $tanggal
 * @property string $jam_mulai
 * @property string $jam_akhir
 * @property string|null $keterangan
 * @property int|null $status_datang default 1 : 0=>Tidak Hadir|1=>Hadir|2=>Digantikan
 * @property int|null $ganti_pegawai_id default null, jika diganti entry pegawai_id =>reff pegawai.tb_pegawai.pegawai_id
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int|null $is_deleted
 */
class JadwalDokter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.jadwal_dokter_klinik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_kode', 'pegawai_id', 'tanggal', 'jam_mulai', 'jam_akhir', 'created_at', 'created_by'], 'required'],
            [['unit_kode', 'pegawai_id', 'status_datang', 'ganti_pegawai_id', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['unit_kode', 'pegawai_id', 'status_datang', 'ganti_pegawai_id', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['tanggal', 'jam_mulai', 'jam_akhir', 'created_at', 'updated_at'], 'safe'],
            [['keterangan', 'log_data'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_kode' => 'Unit Kode',
            'pegawai_id' => 'Pegawai ID',
            'tanggal' => 'Tanggal',
            'jam_mulai' => 'Jam Mulai',
            'jam_akhir' => 'Jam Akhir',
            'keterangan' => 'Keterangan',
            'status_datang' => 'Status Datang',
            'ganti_pegawai_id' => 'Ganti Pegawai ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
        ];
    }
}
