<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "v_users_balance".
 *
 * @property integer $owner_user_id
 * @property string $user_name
 * @property string $total
 * @property double $sum_time
 */
class VUsersBalance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_users_balance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_user_id'], 'required'],
            [['owner_user_id', 'total'], 'integer'],
            [['sum_time'], 'number'],
            [['user_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'owner_user_id' => 'Owner User ID',
            'user_name' => 'User Name',
            'total' => 'Total',
            'sum_time' => 'Sum Time',
        ];
    }
}
