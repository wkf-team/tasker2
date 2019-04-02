<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "v_terms_break".
 *
 * @property string $error_type
 * @property integer $ticket_id
 * @property string $subject
 * @property string $due_date
 * @property double $calc_date
 * @property integer $user_id
 * @property string $user_name
 */
class VTermsBreak extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_terms_break';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['error_type', 'ticket_id', 'user_id'], 'integer'],
            [['due_date'], 'safe'],
            [['calc_date'], 'number'],
            [['subject'], 'string', 'max' => 255],
            [['user_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'error_type' => 'Error Type',
            'ticket_id' => 'Ticket ID',
            'subject' => 'Subject',
            'due_date' => 'Due Date',
            'calc_date' => 'Calc Date',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
        ];
    }
}
