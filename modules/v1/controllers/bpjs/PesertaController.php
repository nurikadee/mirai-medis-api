<?php

namespace app\modules\v1\controllers\bpjs;

use Yii;
use app\helpers\BehaviorsFromParamsHelper;
use app\models\Status;
use app\helpers\ResponseHelper;
use app\models\BpjsBridging;
use yii\rest\ActiveController;

class PesertaController extends ActiveController
{
    public $modelClass = "app\models\Bpjs";

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = BehaviorsFromParamsHelper::behaviors($behaviors);
        return $behaviors;
    }

    function actionGetPesertaByNokartu()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $nomor = $req->post('nomor');
            $m = new BpjsBridging();
            if ($m->setUp(['Peserta', 'nokartu', $nomor, 'tglSEP', date('Y-m-d')])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
    function actionGetPesertaByNik()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $nomor = $req->post('nomor');
            $m = new BpjsBridging();
            if ($m->setUp(['Peserta', 'nik', $nomor, 'tglSEP', date('Y-m-d')])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
}
