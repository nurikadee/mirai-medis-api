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
}
