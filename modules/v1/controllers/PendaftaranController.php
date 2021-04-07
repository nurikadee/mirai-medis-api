<?php

namespace app\modules\v1\controllers;

use app\helpers\DateHelper;
use app\helpers\BehaviorsFromParamsHelper;
use app\helpers\ResponseHelper;
use app\models\pendaftaran\Debitur;
use app\models\Status;
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
}
