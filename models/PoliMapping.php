<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mirai.tb_poli_mapping".
 *
 * @property int $id
 * @property string|null $poli_bpjs_id
 * @property string|null $poli_rs_id
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class PoliMapping extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mirai.tb_poli_mapping';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poli_bpjs_id', 'poli_rs_id', 'created_at', 'updated_at'], 'string'],
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
            'poli_rs_id' => 'Poli Rs ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
