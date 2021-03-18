<?php

namespace app\modules\v1\controllers;

use Yii;
use app\helpers\ResponseHelper;
use app\models\Dokter;
use app\models\Status;
use yii\rest\Controller;

class DokterController extends Controller
{

    public function actionGetDokter()
    {
        $dokter = Dokter::findAllDokter();

        $dokterGroup = [];
        $poliList = [];
        foreach ($dokter as $value) {
            $dokterGroup[$value["unit_kerja"]]["unit_kerja"] = $value["unit_kerja"];
            $dokterGroup[$value["unit_kerja"]]["nama"] = $value["nama"];
            $dokterGroup[$value["unit_kerja"]]["data"][] = $value;
        }

        foreach ($dokterGroup as $poli) {
            $poliList[] = $poli;
        }

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $poliList);
    }

    public function actionGetJadwalDokter()
    {
        $params = Yii::$app->request->post();
        $id_dokter = $params['id_dokter'];

        $jadwalDokter = Dokter::findAllJadwalDokter($id_dokter);

        $jadwalDokterGroup = [];
        $jadwal = [];
        foreach ($jadwalDokter as $value) {
            $jadwalDokterGroup[$value["tanggal"]]["unit_kode"] = $value["unit_kode"];
            $jadwalDokterGroup[$value["tanggal"]]["pegawai_id"] = $value["pegawai_id"];
            $jadwalDokterGroup[$value["tanggal"]]["tanggal"] = $value["tanggal"];

            $data = [
                "jam" => $value["jam_mulai"] . " - " . $value["jam_akhir"],
                "keterangan" => $value["keterangan"],
                "status_datang" => $value["status_datang"]
            ];
            $jadwalDokterGroup[$value["tanggal"]]["jadwal_praktik"][] = $data;
        }

        foreach ($jadwalDokterGroup as $tanggal) {
            $jadwal[] = $tanggal;
        }

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $jadwal);
    }
}
