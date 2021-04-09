<?php

namespace app\modules\v1\controllers;

use Yii;
use app\helpers\ResponseHelper;
use app\models\pendaftaran\Debitur;
use app\models\Status;
use yii\rest\Controller;

class DebiturController extends Controller
{

    public function actionGetDebitur()
    {
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

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $detailDebitur);
    }
}
