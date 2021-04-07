<?php
namespace app\models\pendaftaran;
use Yii;
use app\models\pegawai\UnitPenempatan;
use app\models\medis\Kamar;
use yii\db\Query;
class KelompokUnitLayanan extends \yii\db\ActiveRecord
{
    public $error_msg;
    public static function tableName()
    {
        return 'pendaftaran.kelompok_unit_layanan';
    }
    public function rules()
    {
        return [
            [['unit_id', 'type'], 'required'],
            [['unit_id', 'type', 'tarif_tindakan_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['unit_id', 'type', 'tarif_tindakan_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit ID',
            'type' => 'Type',
            'tarif_tindakan_id' => 'Tarif Tindakan ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
    function getUnit()
    {
        return $this->hasOne(UnitPenempatan::className(),['kode'=>'unit_id']);
    }
    function getKamar()
    {
        return $this->hasOne(Kamar::className(),['unit_id'=>'unit_id']);
    }
    function getLayanan()
    {
        return $this->hasMany(Layanan::className(),['unit_kode'=>'unit_id']);
    }
    static function listRuangRawatInap($req)
    {
        $ruang=$req->post('ruang'); // id ruang 

        $query = self::find()->alias('kul')->joinWith([
            'unit u'
        ],false)->where("kul.type=3 and u.is_deleted is null");
        if($ruang!=NULL){
            $query->andWhere(['unit_id'=>$ruang]);
        }
        $query->select(['unit_id as id','u.nama as ruang'])->asArray();
        if($ruang!=NULL){
            return $query->limit(1)->one();
        }
        return $query->orderBy(['u.nama'=>SORT_ASC])->all();
    }
    static function bedPerRuang($req)
    {
        $ruang=$req->post('ruang'); //id ruang
        $kelas=$req->post('kelas'); //id kelas
        $status=$req->post('status'); //1=tersedia,2=ditempati pasien

        $query = self::find()->alias('kul')->joinWith([
            'kamar'=>function($q){
                $q->alias('kmr')->joinWith(['kelas kl'],false);
            }
        ],false)->where(['kul.type'=>3,'kmr.aktif'=>1]);
        if($ruang!=NULL){
            $query->andWhere(['kul.unit_id'=>$ruang]);
        }
        if($kelas!=NULL){
            $query->andWhere(['kmr.kelas_rawat_kode'=>$kelas]);
        }
        $data=$query->with([
            'layanan'=>function($q){
                $q->select('registrasi_kode,unit_kode')->andWhere('tgl_keluar is null and unit_tujuan_kode is null and deleted_at is null');
            }
        ])->select(['kmr.id as kamar_id','kul.unit_id as ruang_id','kmr.no_kamar','kmr.no_kasur','kl.nama','kul.unit_id'])->asArray()->all();
        
        $data = array_map(function($q) use($status){
            return ['kamar_id'=>$q['kamar_id'],'ruang_id'=>$q['ruang_id'],'no_kamar'=>$q['no_kamar'],'no_kasur'=>$q['no_kasur'],'kelas'=>$q['nama'],'status'=>count($q['layanan'])<1 ? 'Tersedia' : 'Penuh' ];
        },$data);

        return array_filter($data,function($q) use($status){
            if(isset($status)){
                if($status==1 && $q['status']=='Tersedia'){
                    return $q;
                }elseif($status==2 && $q['status']=='Penuh'){
                    return $q;
                }
            }else{
                return $q;
            }
        });
    }
}
