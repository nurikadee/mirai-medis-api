<?php

namespace app\modules\v1\controllers;

use Yii;
use app\helpers\BehaviorsFromParamsHelper;
use app\helpers\ResponseHelper;
use app\models\mirai\Pendaftaran;
use app\models\Status;
use yii\rest\ActiveController;

class RiwayatController extends ActiveController
{
    public $modelClass = 'app\models\mirai\Pendaftaran';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = BehaviorsFromParamsHelper::behaviors($behaviors);
        return $behaviors;
    }

    public function actionPasien()
    {
        $params = Yii::$app->request->post();
        $no_rekam_medis = $params['no_rekam_medis'];

        if (empty($no_rekam_medis)) {
            return $this->writeResponse(false, "Nomor rekam medis tidak boleh kosong", []);
        }

        $mirai = Pendaftaran::getTransactionMirai($no_rekam_medis);
        $web = Pendaftaran::getTransactionLayanan($no_rekam_medis);

        foreach ($mirai as $value) {
            $data[] = $value;
        }

        foreach ($web as $value) {
            $data[] = $value;
        }

        return ResponseHelper::success(Status::STATUS_OK, "Successfully", $data);
    }
}
