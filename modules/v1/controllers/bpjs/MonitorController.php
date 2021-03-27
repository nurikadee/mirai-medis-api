<?php

namespace app\modules\v1\controllers\bpjs;

use Yii;
use app\helpers\BehaviorsFromParamsHelper;
use app\models\Status;
use app\helpers\ResponseHelper;
use app\models\Pasien;
use app\models\BpjsBridging;
use yii\rest\ActiveController;

class MonitorController extends ActiveController
{
    public $modelClass = "app\models\Bpjs";
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = BehaviorsFromParamsHelper::behaviors($behaviors);
        return $behaviors;
    }
    function actionRiwayatPelayanan()
    {
        $req = Yii::$app->request;
        if($req->isPost){
            $no_kartu = $req->post('no_kartu');
            $tgl_mulai = $req->post('tgl_mulai');
            $tgl_akhir = $req->post('tgl_akhir');
            $m = new BpjsBridging();
            if($m->setUp(['monitoring','HistoriPelayanan','NoKartu',$no_kartu,'tglAwal',date('Y-m-d',strtotime($tgl_mulai)),'tglAkhir',date('Y-m-d',strtotime($tgl_akhir))])->exec()){
                $result = $m->getResponse();
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", $result);
            }
            return ResponseHelper::error(Status::STATUS_BAD_REQUEST, $m->error_msg);
        }
    }
}