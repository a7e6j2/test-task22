<?php

namespace api\modules\v1\models;

use Yii;
use api\modules\v1\models\Service;
/**
 * This is the model class for table "user".
 *
 * @property int $id Id
 * @property string $display_name Display Name
 * @property int $created_at Created Date
 * @property int $updated_at Update Date
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['display_name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['display_name'], 'string', 'max' => 120],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'display_name' => 'Display Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
