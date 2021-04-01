<?php

namespace app\modules\v1\controllers\bpjs;

use Yii;
use app\helpers\BehaviorsFromParamsHelper;
use app\models\Status;
use app\helpers\ResponseHelper;
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

    function actionSearch()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $sep = $req->post('sep');
            $m = new BpjsBridging();
            if ($m->setUp(['SEP', $sep])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
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
            ], 'POST')->exec()) {
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
            ], 'POST')->exec()) {
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
            if ($m->setUp(['SEP', 'Delete'], [
                'request' => [
                    't_sep' => $data
                ]
            ], 'DELETE')->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }

    function actionSuplesi()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $tgl_pelayanan = $req->post('tgl_pelayanan');
            $no_kartu = $req->post('no_kartu');
            $m = new BpjsBridging();
            if ($m->setUp(['sep', 'JasaRaharja', 'Suplesi', $no_kartu, 'tglPelayanan', date('Y-m-d', strtotime($tgl_pelayanan))])->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }

    function actionPengajuanSep()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $data = $req->post('data');
            $m = new BpjsBridging();
            if ($m->setUp(['Sep', 'pengajuanSEP'], [
                'request' => [
                    't_sep' => $data
                ]
            ], 'POST')->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }

    function actionApprovalPengajuanSep()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $data = $req->post('data');
            $m = new BpjsBridging();
            if ($m->setUp(['Sep', 'aprovalSEP'], [
                'request' => [
                    't_sep' => $data
                ]
            ], 'POST')->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }

    function actionCheckout()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $data = $req->post('data');
            $m = new BpjsBridging();
            if ($m->setUp(['Sep', 'updtglplg'], [
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
