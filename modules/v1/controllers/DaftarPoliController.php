<?php

namespace app\modules\v1\controllers;

use Yii;
use app\helpers\BehaviorsFromParamsHelper;
use yii\rest\ActiveController;

class DaftarPoliController extends ActiveController
{
    public $modelClass = 'app\models\DaftarPoli';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = BehaviorsFromParamsHelper::behaviors($behaviors);
        return $behaviors;
    }

    public function actionAdd()
    {
        return Yii::$app->user->identity;
    }
}
