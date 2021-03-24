<?php

namespace app\modules\v1\controllers\bpjs;

use Yii;
use app\helpers\BehaviorsFromParamsHelper;
use app\models\Status;
use app\helpers\ResponseHelper;
use app\models\Pasien;
use app\models\BpjsBridging;
use yii\rest\ActiveController;

class SepController extends ActiveController
{
    public $modelClass = "app\models\Bpjs";

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = BehaviorsFromParamsHelper::behaviors($behaviors);
        return $behaviors;
    }

    function actionSave()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $data = $req->post('data');
            $m = new BpjsBridging();
            if ($m->setUp(['SEP', '1.1', 'insert'], [
                'request' => [
                    't_sep' => $data
                ]
            ])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
    function actionUpdate()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $data = $req->post('data');
            $m = new BpjsBridging();
            if ($m->setUp(['SEP', '1.1', 'Update'], [
                'request' => [
                    't_sep' => $data
                ]
            ])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
    function actionDelete()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $data = $req->post('data');
            $m = new BpjsBridging();
            if ($m->setUp(['SEP', '1.1', 'Update', [
                'request' => [
                    't_sep' => $data
                ]
            ]], [
                'request' => [
                    't_sep' => $data
                ]
            ])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
}
