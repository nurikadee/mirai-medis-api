<?php

namespace app\modules\v1\controllers;

use Yii;
use Exception;
use app\helpers\DateHelper;
use app\helpers\BehaviorsFromParamsHelper;
use app\helpers\ResponseHelper;
use app\models\mirai\Pendaftaran;
use app\models\pendaftaran\Debitur;
use app\models\Status;
use yii\base\Model;
use yii\rest\ActiveController;

class PendaftaranController extends ActiveController
{
    public $modelClass = 'app\models\mirai\Pendaftaran';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = BehaviorsFromParamsHelper::behaviors($behaviors);
        return $behaviors;
    }

    public function actionInit()
    {
        $twoWeekDays = DateHelper::getTwoWeekDays();

        $debitur = Debitur::findAllDebitur();

        $debiturGroup = [];
        $detailDebitur = [];
        foreach ($debitur as $value) {
            $debiturGroup[$value["kode_debitur"]]["kode_debitur"] = $value["kode_debitur"];
            $debiturGroup[$value["kode_debitur"]]["nama_debitur"] = $value["nama_debitur"];

            $data = [
                "kode_debitur_detail" => $value["kode_debitur_detail"],
                "nama_debitur_detail" => $value["nama_debitur_detail"]
            ];
            $debiturGroup[$value["kode_debitur"]]["detail"][] = $data;
        }

        foreach ($debiturGroup as $debiturKode) {
            $detailDebitur[] = $debiturKode;
        }


        $response = [
            "weekdays" => $twoWeekDays,
            "debitur" => $detailDebitur
        ];

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $response);
    }

    public function actionGetDays()
    {
        $twoWeekDays = DateHelper::getTwoWeekDays();

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $twoWeekDays);
    }

    public function actionDaftarPoli()
    {
        $params = Yii::$app->request->post();
        $no_rekam_medis = $params['no_rekam_medis'];
        $poli_rs_id = $params['poli_rs_id'];
        $tanggal_kunjungan = $params['tanggal_kunjungan'];
        $debitur_id = $params['debitur_id'];
        $no_kartu_bpjs = $params['no_kartu_bpjs'];
        $no_rujukan_bpjs = $params['no_rujukan_bpjs'];

        if (empty($no_rekam_medis)) {
            return $this->writeResponse(false, "Nomor rekam medis tidak boleh kosong", []);
        }
        if (empty($poli_rs_id)) {
            return $this->writeResponse(false, "Poli tujuan tidak boleh kosong", []);
        }
        if (empty($tanggal_kunjungan)) {
            return $this->writeResponse(false, "Tanggal Kunjungan tidak boleh kosong", []);
        }
        if (empty($debitur_id)) {
            return $this->writeResponse(false, "Debitur tidak boleh kosong", []);
        }
        if (empty($no_kartu_bpjs)) {
            $no_kartu_bpjs = null;
        }
        if (empty($no_rujukan_bpjs)) {
            $no_rujukan_bpjs = null;
        }

        try {
            $pendaftaran = Pendaftaran::getPendaftaran($no_rekam_medis, $poli_rs_id, $tanggal_kunjungan);

            if (!$pendaftaran) {
                $model = new Pendaftaran();
                $model->no_rekam_medis = $no_rekam_medis;
                $model->poli_rs_id = $poli_rs_id;
                $model->tanggal_kunjungan = $tanggal_kunjungan;
                $model->debitur_id = $debitur_id;
                $model->no_kartu_bpjs = $no_kartu_bpjs;
                $model->no_rujukan_bpjs = $no_rujukan_bpjs;

                if ($model->save(false)) {
                    $pendaftaran = Pendaftaran::getPendaftaran($no_rekam_medis, $poli_rs_id, $tanggal_kunjungan);
                    $successMsg = 'Pendaftaran poli telah berhasil, harap melakukan konfirmasi pada tanggal hari kujungan poli di mesin APM RSUD Arifin Achmad';
                    return ResponseHelper::success(Status::STATUS_OK, $successMsg, $pendaftaran);
                } else {
                    return ResponseHelper::success(
                        Status::STATUS_BAD_REQUEST,
                        "Gagal melakukan pendaftaran poli, ulangi beberapa saat lagi",
                        null
                    );
                }
            } else {
                return ResponseHelper::success(
                    Status::STATUS_BAD_REQUEST,
                    "Gagal melakukan pendaftaran poli, anda telah terdaftar pada poli dan tanggal kunjungan yang sama",
                    null
                );
            }
        } catch (Exception $e) {
            return ResponseHelper::success(Status::STATUS_BAD_REQUEST, $e, null);
        }
    }

    public function actionCancelPoli()
    {
        $params = Yii::$app->request->post();
        $pendaftaran_id = $params['pendaftaran_id'];

        if (empty($pendaftaran_id)) {
            return $this->writeResponse(false, "Kode Pendaftaran tidak boleh kosong", []);
        }

        try {
            $pendaftaran = Pendaftaran::find()->where(["id" => $pendaftaran_id])->one();

            if (is_null($pendaftaran)) {
                return ResponseHelper::success(Status::STATUS_BAD_REQUEST, "Pendaftaran tidak ditemukan", null);
            } else {
                $pendaftaran->status_pembatalan = 1;
                if ($pendaftaran->save(false)) {
                    $successMsg = 'Pendaftaran poli telah berhasil dibatalkan';
                    return ResponseHelper::success(Status::STATUS_OK, $successMsg, null);
                } else {
                    return ResponseHelper::success(Status::STATUS_BAD_REQUEST, "Gagal melakukan pembatalan pendaftaran poli", null);
                }
            }
        } catch (Exception $e) {
            return ResponseHelper::success(Status::STATUS_BAD_REQUEST, $e, null);
        }
    }

    public function actionPendaftaranDetail()
    {
        $params = Yii::$app->request->post();
        $no_rekam_medis = $params['no_rekam_medis'];
        $poli_rs_id = $params['poli_rs_id'];
        $tanggal_kunjungan = $params['tanggal_kunjungan'];

        $pendaftaran = Pendaftaran::getPendaftaran($no_rekam_medis, $poli_rs_id, $tanggal_kunjungan);

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $pendaftaran);
    }
}
