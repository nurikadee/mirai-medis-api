<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran.kelompok_unit_layanan".
 *
 * @property int $id
 * @property int $unit_id fk ke pegawaqi.dm_unit_penepatan
 * @property int $type 1=> IGD; 2=> RJ;3=>RAWATINAP;4=>PENUNJANG
 * @property int|null $tarif_tindakan_id
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class KelompokUnitLayanan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran.kelompok_unit_layanan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id', 'type'], 'required'],
            [['unit_id', 'type', 'tarif_tindakan_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['unit_id', 'type', 'tarif_tindakan_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit ID',
            'type' => 'Type',
            'tarif_tindakan_id' => 'Tarif Tindakan ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
}
