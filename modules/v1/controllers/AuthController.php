<?php

namespace app\modules\v1\controllers;

use Yii;
use app\helpers\ResponseHelper;
use app\models\mirai\TokenUser;
use app\models\pendaftaran\Pasien;
use app\models\User;
use app\models\Status;
use yii\rest\Controller;

class AuthController extends Controller
{
    protected function verbs()
    {
        return [
            'signup' => ['POST'],
            'login' => ['POST'],
        ];
    }

    public static function actionSaveToken()
    {
        $params = Yii::$app->request->post();
        $no_rekam_medis = $params['no_rekam_medis'];
        $device_id = $params['device_id'];
        $token = $params['token'];

        if (empty($token) || empty($device_id)) {
            return ResponseHelper::error(
                Status::STATUS_BAD_REQUEST,
                "Inputan tidak lengkap"
            );
        }

        $device = TokenUser::find()->where(['device_id' => $device_id])->one();

        if (is_null($device)) {
            $model = new TokenUser();
            $model->no_rekam_medis = $no_rekam_medis;
            $model->device_id = $device_id;
            $model->token = $token;

            if ($model->save(false)) {
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", null);
            } else {
                return ResponseHelper::error(Status::STATUS_BAD_REQUEST, "Error Token");
            }
        } else {
            $device->no_rekam_medis = $no_rekam_medis;
            $device->device_id = $device_id;
            $device->token = $token;


            if ($device->save(false)) {
                return ResponseHelper::success(Status::STATUS_OK, "Successfully", null);
            } else {
                return ResponseHelper::error(Status::STATUS_BAD_REQUEST, "Error Token");
            }
        }

        return ResponseHelper::error(Status::STATUS_BAD_REQUEST, "Error Token");
    }

    public static function actionLogin()
    {
        $params = Yii::$app->request->post();
        $username = $params['username'];
        $tanggal_lahir = $params['tanggal_lahir'];

        if (empty($username) || empty($tanggal_lahir)) {
            return ResponseHelper::error(
                Status::STATUS_BAD_REQUEST,
                "Nomor MR / No Identitas dan tanggal lahir tidak boleh kosong."
            );
        }

        $pasien = Pasien::findByNoRekamMedisOrNoId($username);

        if ($pasien != null) {
            $user = User::findByNoRekamMedisOrNoId($username);
            if ($user != null) {
                if ($user->validateTanggalLahir($user['tanggal_lahir'], $tanggal_lahir)) {

                    if (isset($params['consumer'])) $user->consumer = $params['consumer'];
                    if (isset($params['access_given'])) $user->access_given = $params['access_given'];


                    Yii::$app->response->statusCode = Status::STATUS_OK;
                    $user->generateAuthKey();
                    $user->save();

                    return ResponseHelper::success(
                        Status::STATUS_OK,
                        "Login Succeed",
                        [
                            'user' => User::findByNoRekamMedis($user->no_rekam_medis),
                            'pasien' => Pasien::findByNoRekamMedis($user->no_rekam_medis)
                        ]
                    );
                } else {
                    return ResponseHelper::error(Status::STATUS_UNAUTHORIZED, "Tanggal lahir tidak sesuai");
                }
            } else {
                $params['no_rekam_medis'] = $pasien['kode'];
                $params['no_identitas'] = $pasien['no_identitas'];
                $params['tanggal_lahir'] = $pasien['tgl_lahir'];
                return AuthController::signup($params);
            }
        } else {
            return ResponseHelper::error(Status::STATUS_UNAUTHORIZED, "Nomor MR / No Identitas tidak terdaftar.");
        }
    }


    public static function signup($params)
    {
        $model = new User();
        $model->no_rekam_medis = $params['no_rekam_medis'];
        $model->no_identitas = $params['no_identitas'];
        $model->tanggal_lahir = $params['tanggal_lahir'];

        $userByNoRekamMedis = User::findByNoRekamMedis($params['no_rekam_medis']);
        $userByno_identitas = User::findByNoId($params['no_identitas']);

        if ($userByNoRekamMedis == null || $userByno_identitas == null) {
            $model->setPassword($params['password']);
            $model->generateAuthKey();
            $model->status = User::STATUS_ACTIVE;

            if ($model->save()) {
                $data = [
                    'user' => User::findByNoRekamMedis($model->no_rekam_medis),
                    'pasien' => Pasien::findByNoRekamMedis($model->no_rekam_medis)
                ];
                return ResponseHelper::success(
                    Status::STATUS_CREATED,
                    'Successfully',
                    $data
                );
            } else {
                return ResponseHelper::error(Status::STATUS_UNAUTHORIZED, "Nomor MR / No Identitas dan tanggal lahir tidak cocok!");
            }
        } else {
            return AuthController::actionLogin($params);
        }
    }

    public static function actionSignup()
    {
        $params = Yii::$app->request->post();
        $model = new User();
        $model->no_rekam_medis = $params['no_rekam_medis'];
        $model->no_identitas = $params['no_identitas'];
        $model->tanggal_lahir = $params['tanggal_lahir'];

        $userByNoRekamMedis = User::findByNoRekamMedis($params['no_rekam_medis']);
        $userByno_identitas = User::findByNoId($params['no_identitas']);

        if ($userByNoRekamMedis == null || $userByno_identitas == null) {
            $model->setPassword($params['password']);
            $model->generateAuthKey();
            $model->status = User::STATUS_ACTIVE;

            if ($model->save()) {
                $data = [
                    'user' => User::findByNoRekamMedis($model->no_rekam_medis),
                    'pasien' => Pasien::findByNoRekamMedis($model->no_rekam_medis)
                ];
                return ResponseHelper::success(
                    Status::STATUS_CREATED,
                    'Successfully',
                    $data
                );
            } else {
                return ResponseHelper::error(Status::STATUS_UNAUTHORIZED, "Nomor MR / No Identitas dan tanggal lahir tidak cocok!");
            }
        } else {
            return AuthController::actionLogin($params);
        }
    }
}
