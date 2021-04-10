<?php

namespace app\models\pendaftaran;

use app\models\pegawai\UnitPenempatan;
use app\models\medis\Kamar;

class KelompokUnitLayanan extends \yii\db\ActiveRecord
{
    public $error_msg;
    public static function tableName()
    {
        return 'pendaftaran.kelompok_unit_layanan';
    }

    function getUnit()
    {
        return $this->hasOne(UnitPenempatan::className(), ['kode' => 'unit_id']);
    }

    function getKamar()
    {
        return $this->hasOne(Kamar::className(), ['unit_id' => 'unit_id']);
    }

    function getLayanan()
    {
        return $this->hasMany(Layanan::className(), ['unit_kode' => 'unit_id']);
    }

    static function findAllaKamar()
    {
        $kelasTemp = [];
        $kelasGroup = [];
        $kelas = Kelas::find()
            ->select([
                "kode as kode_kelas",
                "nama as nama_kelas",
            ])
            ->asArray()->all();

        foreach ($kelas as $value) {
            $kamarTemp = [];
            $kamarGroup = [];

            $kamar = Kamar::find()->alias("kam")
                ->select([
                    "kam.id as kamar_id",
                    "kam.unit_id as kode_ruang",
                    "tem.nama as nama_ruang",
                    "kam.no_kamar",
                    "kam.no_kasur"
                ])
                ->leftJoin(UnitPenempatan::tableName() . " as tem", "tem.kode::varchar = kam.unit_id::varchar")
                ->where(['kelas_rawat_kode' => $value["kode_kelas"]])
                ->asArray()->all();

            foreach ($kamar as $valueKam) {
                $lastUpdated = date("Y-m-d H:m:s");
                $availableBed = Layanan::find()
                    ->select([
                        "kamar_id",
                        "registrasi_kode",
                        "tgl_masuk",
                        "tgl_keluar",
                        "created_at",
                        "updated_at"
                    ])
                    ->where(["kamar_id" => $valueKam["kamar_id"]])
                    ->andWhere(["tgl_keluar" => null])
                    ->orderBy("updated_at desc")
                    ->asArray()->all();

                $createdDate = [];
                foreach ($availableBed as $last) {
                    if (empty($last["updated_at"])) {
                        $createdDate[] = $last["created_at"];
                    } else {
                        $createdDate[] = $last["updated_at"];
                    }
                }

                $kamarTemp[$valueKam["kode_ruang"]]["kode_ruang"] = $valueKam["kode_ruang"];
                $kamarTemp[$valueKam["kode_ruang"]]["nama_ruang"] = $valueKam["nama_ruang"];
                $kamarTemp[$valueKam["kode_ruang"]]["kamar"][] = [
                    "kamar_id" => $valueKam["kamar_id"],
                    "no_kamar" => $valueKam["no_kamar"],
                    "no_kasur" => $valueKam["no_kasur"],
                    "available" => empty($availableBed),
                    "last_updated" => empty($availableBed) ? $lastUpdated : $createdDate[0]
                ];
            }


            foreach ($kamarTemp as $a) {
                $kamarGroup[] = $a;
            }

            $kelasTemp[$value["kode_kelas"]] = $value;
            $kelasTemp[$value["kode_kelas"]]["ruangan"] = $kamarGroup;
        }

        foreach ($kelasTemp as $b) {
            $kelasGroup[] = $b;
        }
        return $kelasGroup;
    }

    static function listRuangRawatInap($req)
    {
        $ruang = $req->post('ruang'); // id ruang 

        $query = self::find()->alias('kul')->joinWith([
            'unit u'
        ], false)->where("kul.type=3 and u.is_deleted is null");
        if ($ruang != NULL) {
            $query->andWhere(['unit_id' => $ruang]);
        }
        $query->select(['unit_id as id', 'u.nama as ruang'])->asArray();
        if ($ruang != NULL) {
            return $query->limit(1)->one();
        }
        return $query->orderBy(['u.nama' => SORT_ASC])->all();
    }

    static function bedPerRuang($req)
    {
        $ruang = $req->post('ruang'); //id ruang
        $kelas = $req->post('kelas'); //id kelas
        $status = $req->post('status'); //1=tersedia,2=ditempati pasien

        $query = self::find()->alias('kul')->joinWith([
            'kamar' => function ($q) {
                $q->alias('kmr')->joinWith(['kelas kl'], false);
            }
        ], false)->where(['kul.type' => 3, 'kmr.aktif' => 1]);
        if ($ruang != NULL) {
            $query->andWhere(['kul.unit_id' => $ruang]);
        }
        if ($kelas != NULL) {
            $query->andWhere(['kmr.kelas_rawat_kode' => $kelas]);
        }
        $data = $query->with([
            'layanan' => function ($q) {
                $q->select('registrasi_kode,unit_kode')->andWhere('tgl_keluar is null and unit_tujuan_kode is null and deleted_at is null');
            }
        ])->select(['kmr.id as kamar_id', 'kul.unit_id as ruang_id', 'kmr.no_kamar', 'kmr.no_kasur', 'kl.nama', 'kul.unit_id'])->asArray()->all();

        $data = array_map(function ($q) use ($status) {
            return ['kamar_id' => $q['kamar_id'], 'ruang_id' => $q['ruang_id'], 'no_kamar' => $q['no_kamar'], 'no_kasur' => $q['no_kasur'], 'kelas' => $q['nama'], 'status' => count($q['layanan']) < 1 ? 'Tersedia' : 'Penuh'];
        }, $data);

        return array_filter($data, function ($q) use ($status) {
            if (isset($status)) {
                if ($status == 1 && $q['status'] == 'Tersedia') {
                    return $q;
                } elseif ($status == 2 && $q['status'] == 'Penuh') {
                    return $q;
                }
            } else {
                return $q;
            }
        });
    }
}
