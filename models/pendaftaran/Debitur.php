<?php

namespace app\models\pendaftaran;

use Yii;

/**
 * This is the model class for table "pendaftaran.debitur".
 *
 * @property string $kode
 * @property string $nama
 * @property int|null $created_by
 * @property string|null $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $aktif
 * @property int|null $deleted_by
 */
class Debitur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran.debitur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'nama'], 'required'],
            [['created_by', 'updated_by', 'aktif', 'deleted_by'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'aktif', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['kode'], 'string', 'max' => 10],
            [['nama'], 'string', 'max' => 255],
            [['kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode' => 'Kode',
            'nama' => 'Nama',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'aktif' => 'Aktif',
            'deleted_by' => 'Deleted By',
        ];
    }

    public static function findAllDebitur()
    {
        return Debitur::find()
            ->select([
                "kode",
                "nama"
            ])
            ->where(["aktif" => "1"])
            ->asArray()->all();
    }
}
