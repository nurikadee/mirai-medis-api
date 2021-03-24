<?php

namespace app\modules\v1\controllers\bpjs;

use Yii;
use app\helpers\BehaviorsFromParamsHelper;
use app\models\Status;
use app\helpers\ResponseHelper;
use app\models\Pasien;
use app\models\BpjsBridging;
use yii\rest\ActiveController;

class ReferensiController extends ActiveController
{
    public $modelClass = "app\models\Bpjs";

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = BehaviorsFromParamsHelper::behaviors($behaviors);
        return $behaviors;
    }

    function actionGetDiagnosa()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $diagnosa = $req->post('diagnosa');
            $m = new BpjsBridging();
            if ($m->setUp(['referensi', 'diagnosa', $diagnosa])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
    function actionGetPoli()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $poli = $req->post('poli');
            $m = new BpjsBridging();
            if ($m->setUp(['referensi', 'poli', $poli])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
    function actionGetFaskes()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $faskes = $req->post('faskes');
            $tingkat = $req->post('tingkat');
            $m = new BpjsBridging();
            if ($m->setUp(['referensi', 'faskes', $faskes, $tingkat])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
    function actionGetDpjp()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $jenis = $req->post('jenis');
            $dpjp = $req->post('dpjp');
            $m = new BpjsBridging();
            if ($m->setUp(['referensi', 'dokter', 'pelayanan', $jenis, 'tglPelayanan', date('Y-m-d'), 'Spesialis', $dpjp])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
    function actionGetProvinsi()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $m = new BpjsBridging();
            if ($m->setUp(['referensi', 'propinsi'])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
    function actionGetKabupaten()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $provinsi = $req->post('provinsi');
            $m = new BpjsBridging();
            if ($m->setUp(['referensi', 'kabupaten', 'propinsi', $provinsi])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
    function actionGetKecamatan()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $kabupaten = $req->post('kabupaten');
            $m = new BpjsBridging();
            if ($m->setUp(['referensi', 'kecamatan', 'kabupaten', $kabupaten])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
}
