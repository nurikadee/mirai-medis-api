<?php

namespace app\models\pendaftaran;

use Yii;

/**
 * This is the model class for table "pendaftaran.pasien".
 *
 * @property int|null $pendidikan_kode
 * @property string|null $tempat_lahir
 * @property string|null $tgl_lahir
 * @property string|null $alergi
 * @property string|null $kelurahan_kode
 * @property string|null $kedudukan_keluarga 1=Kepala Keluarga,2=Istri,3=Anak
 * @property int|null $anak_ke
 * @property int|null $istri_ke
 * @property string|null $goldar
 * @property string|null $jurusan_kode
 * @property string $kode
 * @property string|null $nama
 * @property string|null $alamat
 * @property string|null $no_identitas
 * @property string|null $no_telp
 * @property string|null $jkel
 * @property string|null $status_kawin_kode
 * @property string|null $tempat_kerja
 * @property string|null $alamat_tempat_kerja
 * @property string|null $ayah_nama
 * @property string|null $ibu_nama
 * @property string|null $nama_pasangan
 * @property int|null $agama_kode
 * @property int|null $pekerjaan_kode
 * @property int|null $jml_anak
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $penghasilan
 * @property int|null $suku_kode
 * @property int|null $kewarganegaraan_kode
 * @property string|null $rt
 * @property string|null $rw
 * @property string|null $created_by
 * @property string|null $created_at
 * @property string|null $updated_by
 * @property string|null $updated_at
 * @property string|null $ayah_no_rekam_medis
 * @property string|null $ibu_no_rekam_medis
 * @property string|null $jenis_identitas_kode
 */
class Pasien extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran.pasien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pendidikan_kode', 'anak_ke', 'istri_ke', 'agama_kode', 'pekerjaan_kode', 'jml_anak', 'deleted_by', 'penghasilan', 'suku_kode', 'kewarganegaraan_kode'], 'default', 'value' => null],
            [['pendidikan_kode', 'anak_ke', 'istri_ke', 'agama_kode', 'pekerjaan_kode', 'jml_anak', 'deleted_by', 'penghasilan', 'suku_kode', 'kewarganegaraan_kode'], 'integer'],
            [['tgl_lahir', 'deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['alergi', 'jkel', 'ayah_no_rekam_medis', 'ibu_no_rekam_medis', 'jenis_identitas_kode'], 'string'],
            [['kode'], 'required'],
            [['tempat_lahir', 'nama', 'alamat', 'nama_pasangan'], 'string', 'max' => 255],
            [['kelurahan_kode', 'jurusan_kode'], 'string', 'max' => 10],
            [['kedudukan_keluarga'], 'string', 'max' => 1],
            [['goldar', 'status_kawin_kode'], 'string', 'max' => 2],
            [['kode'], 'string', 'max' => 8],
            [['no_identitas', 'no_telp'], 'string', 'max' => 30],
            [['tempat_kerja', 'ayah_nama', 'ibu_nama'], 'string', 'max' => 50],
            [['alamat_tempat_kerja'], 'string', 'max' => 100],
            [['rt', 'rw'], 'string', 'max' => 3],
            [['created_by', 'updated_by'], 'string', 'max' => 20],
            [['kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pendidikan_kode' => 'Pendidikan Kode',
            'tempat_lahir' => 'Tempat Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'alergi' => 'Alergi',
            'kelurahan_kode' => 'Kelurahan Kode',
            'kedudukan_keluarga' => 'Kedudukan Keluarga',
            'anak_ke' => 'Anak Ke',
            'istri_ke' => 'Istri Ke',
            'goldar' => 'Goldar',
            'jurusan_kode' => 'Jurusan Kode',
            'kode' => 'Kode',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'no_identitas' => 'No Identitas',
            'no_telp' => 'No Telp',
            'jkel' => 'Jkel',
            'status_kawin_kode' => 'Status Kawin Kode',
            'tempat_kerja' => 'Tempat Kerja',
            'alamat_tempat_kerja' => 'Alamat Tempat Kerja',
            'ayah_nama' => 'Ayah Nama',
            'ibu_nama' => 'Ibu Nama',
            'nama_pasangan' => 'Nama Pasangan',
            'agama_kode' => 'Agama Kode',
            'pekerjaan_kode' => 'Pekerjaan Kode',
            'jml_anak' => 'Jml Anak',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'penghasilan' => 'Penghasilan',
            'suku_kode' => 'Suku Kode',
            'kewarganegaraan_kode' => 'Kewarganegaraan Kode',
            'rt' => 'Rt',
            'rw' => 'Rw',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'ayah_no_rekam_medis' => 'Ayah No Rekam Medis',
            'ibu_no_rekam_medis' => 'Ibu No Rekam Medis',
            'jenis_identitas_kode' => 'Jenis Identitas Kode',
        ];
    }

    public static function findByNoRekamMedisOrNoId($username)
    {
        return Pasien::find()
            ->where(['no_identitas' => $username])
            ->orWhere(['kode' => $username])
            ->one();
    }

    public static function findByNoRekamMedis($no_rekam_medis)
    {
        return static::findOne(['kode' => $no_rekam_medis]);
    }
}
