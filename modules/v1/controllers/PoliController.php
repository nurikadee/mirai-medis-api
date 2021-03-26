<?php

namespace app\modules\v1\controllers;

use Yii;
use app\helpers\ResponseHelper;
use app\models\Poli;
use app\models\Status;
use yii\rest\Controller;

class PoliController extends Controller
{

    public function actionGetPoli()
    {
        $poli = Poli::findAllPoli();

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $poli);
    }

    public function actionGetPoliMappingBpjs()
    {
        $poli = Poli::findAllPoliMappingBpjs();

        $poliGroup = [];
        $poliList = [];
        foreach ($poli as $value) {
            $poli_rs = [
                "poli_rs_id" => $value["poli_rs_id"],
                "poli_rs_nama" => $value["poli_rs_nama"],
            ];

            $poliGroup[$value["poli_bpjs_id"]]["poli_bpjs_id"] = $value["poli_bpjs_id"];
            $poliGroup[$value["poli_bpjs_id"]]["poli_bpjs_nama"] = $value["poli_bpjs_nama"];
            $poliGroup[$value["poli_bpjs_id"]]["poli_rs"][] = $poli_rs;
        }

        foreach ($poliGroup as $poli) {
            $poliList[] = $poli;
        }

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $poliList);
    }

    public function actionGetPoliRsByPoliBpjs()
    {
        $params = Yii::$app->request->post();
        $poli_bpjs_id = $params['poli_bpjs_id'];

        $poli = Poli::findAllPoliRsByPoliBpjs($poli_bpjs_id);

        $poliGroup = [];
        $poliList = [];
        foreach ($poli as $value) {
            $poli_rs = [
                "poli_rs_id" => $value["poli_rs_id"],
                "poli_rs_nama" => $value["poli_rs_nama"],
            ];

            $poliGroup[$value["poli_bpjs_id"]]["poli_bpjs_id"] = $value["poli_bpjs_id"];
            $poliGroup[$value["poli_bpjs_id"]]["poli_bpjs_nama"] = $value["poli_bpjs_nama"];
            $poliGroup[$value["poli_bpjs_id"]]["poli_rs"][] = $poli_rs;
        }

        foreach ($poliGroup as $poli) {
            if ($poli["poli_bpjs_nama"] != null) {
                $poliList = $poli;
            }
        }

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $poliList);
    }
}
