<?php

namespace app\modules\v1\controllers;

use app\helpers\DateHelper;
use app\helpers\BehaviorsFromParamsHelper;
use app\helpers\ResponseHelper;
use app\models\Status;
use yii\rest\ActiveController;

class PendaftaranPoliController extends ActiveController
{
    public $modelClass = 'app\models\Pendaftaran';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = BehaviorsFromParamsHelper::behaviors($behaviors);
        return $behaviors;
    }

    public function actionGetDays()
    {
        $twoWeekDays = DateHelper::getTwoWeekDays();

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $twoWeekDays);
    }
}
