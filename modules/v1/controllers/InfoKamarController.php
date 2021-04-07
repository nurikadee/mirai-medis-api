<?php

namespace app\modules\v1\controllers;

use Yii;
use app\helpers\BehaviorsFromParamsHelper;
use app\helpers\ResponseHelper;
use app\models\Status;
use app\models\pendaftaran\Registrasi;
use app\models\pendaftaran\KelompokUnitLayanan;
use yii\rest\Controller;

class InfoKamarController extends Controller
{
    public $modelClass = "app\models\Bpjs";

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = BehaviorsFromParamsHelper::behaviors($behaviors);
        return $behaviors;
    }

    function actionRiwayatRawatinap()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $riwayat = Registrasi::findRawatinapPasien($req);
            if ($riwayat != NULL) {
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $riwayat);
            }
            return ResponseHelper::error(Status::STATUS_NO_CONTENT, 'No Content');
        }
        return ResponseHelper::error(Status::STATUS_METHOD_NOT_ALLOWED, 'Method Not Allowed');
    }
    function actionListRuang()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $ruang = KelompokUnitLayanan::listRuangRawatInap($req);
            if ($ruang != NULL) {
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $ruang);
            }
            return ResponseHelper::error(Status::STATUS_NO_CONTENT, 'No Content');
        }
        return ResponseHelper::error(Status::STATUS_METHOD_NOT_ALLOWED, 'Method Not Allowed');
    }
    function actionBedPerRuang()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $kamar = KelompokUnitLayanan::bedPerRuang($req);
            if (count($kamar) > 0) {
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $kamar);
            }
            return ResponseHelper::error(Status::STATUS_NO_CONTENT, 'No Content');
        }
        return ResponseHelper::error(Status::STATUS_METHOD_NOT_ALLOWED, 'Method Not Allowed');
    }
}
