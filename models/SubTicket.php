<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_ticket".
 *
 * @property integer $id
 * @property string $text
 * @property integer $order_num
 * @property integer $is_done
 * @property integer $iteration_id
 * @property integer $ticket_id
 * @property integer $owner_user_id
 *
 * @property Iteration $iteration
 * @property Ticket $ticket
 * @property User $ownerUser
 */
class SubTicket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sub_ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'order_num', 'is_done', 'ticket_id', 'owner_user_id'], 'required'],
            [['order_num', 'is_done', 'iteration_id', 'ticket_id', 'owner_user_id'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['iteration_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iteration::className(), 'targetAttribute' => ['iteration_id' => 'id']],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket_id' => 'id']],
            [['owner_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'order_num' => 'Order Num',
            'is_done' => 'Is Done',
            'iteration_id' => 'Iteration ID',
            'ticket_id' => 'Ticket ID',
            'owner_user_id' => 'Owner User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIteration()
    {
        return $this->hasOne(Iteration::className(), ['id' => 'iteration_id']);
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
    public function getOwnerUser()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_user_id']);
    }
}
