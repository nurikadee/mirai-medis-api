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

        $response = [
            "weekdays" => $twoWeekDays,
            "debitur" => $debitur
        ];

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $response);
    }

    public function actionGetDays()
    {
        $twoWeekDays = DateHelper::getTwoWeekDays();

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $twoWeekDays);
    }
}
