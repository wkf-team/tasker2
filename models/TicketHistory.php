<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ticket_history".
 *
 * @property integer $hist_id
 * @property string $hist_create_date
 * @property integer $hist_create_user_id
 * @property string $hist_reason
 * @property integer $id
 * @property string $subject
 * @property string $description
 * @property string $create_date
 * @property string $estimate_start_date
 * @property string $due_date
 * @property string $end_date
 * @property integer $estimate_time
 * @property integer $worked_time
 * @property integer $priority_id
 * @property integer $status_id
 * @property integer $resolution_id
 * @property integer $ticket_type_id
 * @property integer $author_user_id
 * @property integer $owner_user_id
 * @property integer $tester_user_id
 * @property integer $responsible_user_id
 * @property integer $parent_ticket_id
 * @property integer $iteration_id
 * @property integer $project_id
 *
 * @property User $histCreateUser
 * @property Iteration $iteration
 * @property Project $project
 * @property Priority $priority
 * @property Resolution $resolution
 * @property Status $status
 * @property TicketType $ticketType
 * @property User $authorUser
 * @property User $ownerUser
 * @property User $testerUser
 * @property User $responsibleUser
 */
class TicketHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hist_create_date', 'hist_create_user_id', 'hist_reason', 'id', 'subject', 'create_date', 'priority_id', 'status_id', 'resolution_id', 'ticket_type_id', 'author_user_id', 'owner_user_id', 'responsible_user_id', 'iteration_id', 'project_id'], 'required'],
            [['hist_create_date', 'create_date', 'estimate_start_date', 'due_date', 'end_date'], 'safe'],
            [['hist_create_user_id', 'id', 'estimate_time', 'worked_time', 'priority_id', 'status_id', 'resolution_id', 'ticket_type_id', 'author_user_id', 'owner_user_id', 'tester_user_id', 'responsible_user_id', 'parent_ticket_id', 'iteration_id', 'project_id'], 'integer'],
            [['hist_reason'], 'string', 'max' => 1024],
            [['subject'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 10000],
            [['hist_create_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['hist_create_user_id' => 'id']],
            [['iteration_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iteration::className(), 'targetAttribute' => ['iteration_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['priority_id'], 'exist', 'skipOnError' => true, 'targetClass' => Priority::className(), 'targetAttribute' => ['priority_id' => 'id']],
            [['resolution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resolution::className(), 'targetAttribute' => ['resolution_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['ticket_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TicketType::className(), 'targetAttribute' => ['ticket_type_id' => 'id']],
            [['author_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_user_id' => 'id']],
            [['owner_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_user_id' => 'id']],
            [['tester_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['tester_user_id' => 'id']],
            [['responsible_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['responsible_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hist_id' => 'Hist ID',
            'hist_create_date' => 'Hist Create Date',
            'hist_create_user_id' => 'Hist Create User ID',
            'hist_reason' => 'Hist Reason',
            'id' => 'ID',
            'subject' => 'Subject',
            'description' => 'Description',
            'create_date' => 'Create Date',
            'estimate_start_date' => 'Estimate Start Date',
            'due_date' => 'Due Date',
            'end_date' => 'End Date',
            'estimate_time' => 'Estimate Time',
            'worked_time' => 'Worked Time',
            'priority_id' => 'Priority ID',
            'status_id' => 'Status ID',
            'resolution_id' => 'Resolution ID',
            'ticket_type_id' => 'Ticket Type ID',
            'author_user_id' => 'Author User ID',
            'owner_user_id' => 'Owner User ID',
            'tester_user_id' => 'Tester User ID',
            'responsible_user_id' => 'Responsible User ID',
            'parent_ticket_id' => 'Parent Ticket ID',
            'iteration_id' => 'Iteration ID',
            'project_id' => 'Project ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistCreateUser()
    {
        return $this->hasOne(User::className(), ['id' => 'hist_create_user_id']);
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
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriority()
    {
        return $this->hasOne(Priority::className(), ['id' => 'priority_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResolution()
    {
        return $this->hasOne(Resolution::className(), ['id' => 'resolution_id']);
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
    public function getTicketType()
    {
        return $this->hasOne(TicketType::className(), ['id' => 'ticket_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorUser()
    {
        return $this->hasOne(User::className(), ['id' => 'author_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwnerUser()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTesterUser()
    {
        return $this->hasOne(User::className(), ['id' => 'tester_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsibleUser()
    {
        return $this->hasOne(User::className(), ['id' => 'responsible_user_id']);
    }
}
