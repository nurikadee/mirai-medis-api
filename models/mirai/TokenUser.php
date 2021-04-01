<?php

namespace app\models\mirai;

use Yii;

/**
 * This is the model class for table "mirai.tb_token_user".
 *
 * @property int $id
 * @property string $no_rekam_medis
 * @property string $device_id
 * @property string $token
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class TokenUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mirai.tb_token_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_rekam_medis', 'device_id', 'token'], 'required'],
            [['no_rekam_medis', 'device_id', 'token', 'created_at', 'updated_at'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_rekam_medis' => 'No Rekam Medis',
            'device_id' => 'Device ID',
            'token' => 'Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findTokenByDeviceId($device_id)
    {
        return TokenUser::find()
            ->where(['device_id' => $device_id])
            ->one();
    }
}
