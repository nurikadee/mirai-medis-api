<?php

namespace app\modules\v1\controllers;

use Yii;
use app\helpers\ResponseHelper;
use app\models\Debitur;
use app\models\Poli;
use app\models\Status;
use yii\rest\Controller;

class DebiturController extends Controller
{

    public function actionGetDebitur()
    {
        $debitur = Debitur::findAllDebitur();

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $debitur);
    }
}
