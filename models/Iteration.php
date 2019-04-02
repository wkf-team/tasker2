<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "iteration".
 *
 * @property integer $id
 * @property string $start_date
 * @property string $due_date
 * @property integer $project_id
 * @property integer $status_id
 * @property integer $number
 *
 * @property Project $project
 * @property Status $status
 * @property SubTicket[] $subTickets
 * @property Ticket[] $tickets
 * @property TicketHistory[] $ticketHistories
 */
class Iteration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'iteration';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_date', 'due_date', 'project_id', 'status_id', 'number'], 'required'],
            [['start_date', 'due_date'], 'safe'],
            [['project_id', 'status_id', 'number'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_date' => 'Start Date',
            'due_date' => 'Due Date',
            'project_id' => 'Project ID',
            'status_id' => 'Status ID',
            'number' => 'Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubTickets()
    {
        return $this->hasMany(SubTicket::className(), ['iteration_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['iteration_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketHistories()
    {
        return $this->hasMany(TicketHistory::className(), ['iteration_id' => 'id']);
    }
}
