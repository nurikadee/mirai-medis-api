<?php

namespace app\models\mirai;

use Yii;

/**
 * This is the model class for table "mirai.tb_antrian".
 *
 * @property int $id
 * @property string $pendaftaran_id
 * @property string|null $nomor_antrian
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Antrian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mirai.tb_antrian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pendaftaran_id'], 'required'],
            [['pendaftaran_id', 'nomor_antrian'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pendaftaran_id' => 'Pendaftaran ID',
            'nomor_antrian' => 'Nomor Antrian',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
