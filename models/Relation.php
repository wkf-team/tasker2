<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "relation".
 *
 * @property integer $id
 * @property integer $ticket_from_id
 * @property integer $ticket_to_id
 * @property integer $relation_type_id
 *
 * @property RelationType $relationType
 * @property Ticket $ticketFrom
 * @property Ticket $ticketTo
 */
class Relation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ticket_from_id', 'ticket_to_id', 'relation_type_id'], 'required'],
            [['ticket_from_id', 'ticket_to_id', 'relation_type_id'], 'integer'],
            [['relation_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RelationType::className(), 'targetAttribute' => ['relation_type_id' => 'id']],
            [['ticket_from_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket_from_id' => 'id']],
            [['ticket_to_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket_to_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ticket_from_id' => 'Ticket From ID',
            'ticket_to_id' => 'Ticket To ID',
            'relation_type_id' => 'Relation Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationType()
    {
        return $this->hasOne(RelationType::className(), ['id' => 'relation_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketFrom()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'ticket_from_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketTo()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'ticket_to_id']);
    }
}
