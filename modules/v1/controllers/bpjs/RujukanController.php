<?php

namespace app\modules\v1\controllers\bpjs;

use Yii;
use app\helpers\BehaviorsFromParamsHelper;
use app\models\Status;
use app\helpers\ResponseHelper;
use app\models\BpjsBridging;
use yii\rest\ActiveController;

class RujukanController extends ActiveController
{
    public $modelClass = "app\models\Bpjs";
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = BehaviorsFromParamsHelper::behaviors($behaviors);
        return $behaviors;
    }

    function actionGetRujukanByNomor()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $nomor = $req->post('nomor');
            $type = $req->post('type'); //tingkat faskes : 1 atau 2

            $url = ['Rujukan'];
            if ($type == 2) {
                $url[] = 'RS';
            }
            $url[] = $nomor;

            $m = new BpjsBridging();
            if ($m->setUp($url)->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }

    function actionGetRujukanByKartu()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $nomor = $req->post('nomor');
            $type = $req->post('type'); //tingkat faskes : 1 atau 2
            $multi = $req->post('multi'); //1 : multi record, 0 : 1 record

            $url = ['Rujukan'];
            if ($type == 2) {
                $url[] = 'RS';
            }

            if ($multi == 1) {
                $url[] = 'List';
            }

            $url[] = 'Peserta';
            $url[] = $nomor;

            $m = new BpjsBridging();
            if ($m->setUp($url)->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }

    function actionInsert()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $data = $req->post('data');
            $m = new BpjsBridging();
            if ($m->setUp(['Rujukan', 'insert'], [
                'request' => [
                    't_rujukan' => $data
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
            if ($m->setUp(['Rujukan', 'update'], [
                'request' => [
                    't_rujukan' => $data
                ]
            ], 'PUT')->exec()) {
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
            if ($m->setUp(['Rujukan', 'delete'], [
                'request' => [
                    't_rujukan' => $data
                ]
            ], 'DELETE')->exec()) {
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
}
