<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "spent_time".
 *
 * @property integer $id
 * @property string $create_date
 * @property integer $hours_count
 * @property integer $ticket_id
 * @property integer $user_id
 *
 * @property Ticket $ticket
 * @property User $user
 */
class SpentTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'spent_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'hours_count', 'ticket_id', 'user_id'], 'required'],
            [['create_date'], 'safe'],
            [['hours_count', 'ticket_id', 'user_id'], 'integer'],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'create_date' => 'Create Date',
            'hours_count' => 'Hours Count',
            'ticket_id' => 'Ticket ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'ticket_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
