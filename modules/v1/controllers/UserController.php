<?php

namespace app\modules\v1\controllers;

use Yii;
use app\helpers\BehaviorsFromParamsHelper;
use app\models\Status;
use app\helpers\ResponseHelper;
use app\models\Pasien;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = BehaviorsFromParamsHelper::behaviors($behaviors);
        return $behaviors;
    }

    public function actionGetUser()
    {
        $user = Yii::$app->user->identity;
        $pasien = Pasien::findByNoRekamMedis($user["no_rekam_medis"]);
        $data = [
            "user" => Yii::$app->user->identity,
            "pasien" => $pasien
        ];
        return ResponseHelper::success(Status::STATUS_OK, "Succeesfully", $data);
    }
}
