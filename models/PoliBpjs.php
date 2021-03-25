<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mirai.tb_poli_bpjs".
 *
 * @property int $id
 * @property string $poli_bpjs_id
 * @property string|null $poli_bpjs_nama
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class PoliBpjs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mirai.tb_poli_bpjs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poli_bpjs_id'], 'required'],
            [['poli_bpjs_id', 'poli_bpjs_nama', 'created_at', 'updated_at'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'poli_bpjs_id' => 'Poli Bpjs ID',
            'poli_bpjs_nama' => 'Poli Bpjs Nama',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
