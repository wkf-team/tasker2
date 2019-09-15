<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property integer $id
 * @property string $subject
 * @property string $description
 * @property string $create_date
 * @property string $estimate_start_date
 * @property string $due_date
 * @property string $end_date
 * @property double $estimate_time
 * @property double $worked_time
 * @property integer $story_points
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
 * @property string $initial_version
 * @property string $resolved_version
 * @property integer $order_num
 *
 * @property Attachment[] $attachments
 * @property Comment[] $comments
 * @property Relation[] $relations
 * @property Relation[] $relations0
 * @property SpentTime[] $spentTimes
 * @property SubTicket[] $subTickets
 * @property Iteration $iteration
 * @property Project $project
 * @property Priority $priority
 * @property Resolution $resolution
 * @property Status $status
 * @property TicketType $ticketType
 * @property Ticket $parentTicket
 * @property Ticket[] $tickets
 * @property User $authorUser
 * @property User $ownerUser
 * @property User $testerUser
 * @property User $responsibleUser
 */
class Ticket extends \yii\db\ActiveRecord
{
	public static function create()
	{
		$ticket = new Ticket();
		$ticket->status_id = 1;
		$ticket->ticket_type_id = 2;
		$ticket->priority_id = 2;
		$ticket->author_user_id = Yii::$app->user->id;
		$ticket->owner_user_id = Yii::$app->user->id;
		$ticket->responsible_user_id = Yii::$app->user->id;
		$ticket->project_id = Project::GetSelected()->id;
		$ticket->order_num = Ticket::find()->select(['order_num'=>'IFNULL(max(order_num),0)'])->scalar();
		return $ticket;
	}
    
    public static function getFilterByStatus()
    {
        return 'status_id < 6 OR status_id = 6 AND `end_date` >= (NOW() - INTERVAL 14 DAY)';
    }
	
	public function getWorkflowActions()
	{
		return WorkflowStep::GetListOfActions($this);
	}
	
	public function makeWorkflowAction($action)
	{
		WorkflowStep::GetAction($this->status_id, $action)->PerformStep($this);
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'priority_id', 'status_id', 'ticket_type_id', 'author_user_id', 'owner_user_id', 'responsible_user_id', 'project_id', 'order_num'], 'required'],
            [['estimate_start_date', 'due_date', 'end_date'], 'safe'],
            [['estimate_time', 'worked_time'], 'number'],
            [['story_points', 'priority_id', 'status_id', 'resolution_id', 'ticket_type_id', 'author_user_id', 'owner_user_id', 'tester_user_id', 'responsible_user_id', 'parent_ticket_id', 'iteration_id', 'project_id', 'order_num'], 'integer'],
            [['subject'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 10000],
            [['initial_version', 'resolved_version'], 'string', 'max' => 25],
            [['iteration_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iteration::className(), 'targetAttribute' => ['iteration_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['priority_id'], 'exist', 'skipOnError' => true, 'targetClass' => Priority::className(), 'targetAttribute' => ['priority_id' => 'id']],
            [['resolution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resolution::className(), 'targetAttribute' => ['resolution_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['ticket_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TicketType::className(), 'targetAttribute' => ['ticket_type_id' => 'id']],
            [['parent_ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['parent_ticket_id' => 'id']],
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
            'id' => 'ID',
            'subject' => 'Subject',
            'description' => 'Description',
            'create_date' => 'Create Date',
            'estimate_start_date' => 'Estimate Start Date',
            'due_date' => 'Due Date',
            'end_date' => 'End Date',
            'estimate_time' => 'Estimate Time',
            'worked_time' => 'Worked Time',
            'story_points' => 'Story Points',
            'priority_id' => 'Priority',
            'status_id' => 'Status',
            'resolution_id' => 'Resolution',
            'ticket_type_id' => 'Ticket Type',
            'author_user_id' => 'Author User',
            'owner_user_id' => 'Owner User',
            'tester_user_id' => 'Tester User',
            'responsible_user_id' => 'Responsible User',
            'parent_ticket_id' => 'Parent Ticket',
            'iteration_id' => 'Iteration',
            'project_id' => 'Project',
            'initial_version' => 'Initial Version',
            'resolved_version' => 'Resolved Version',
            'order_num' => 'Order Num',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['ticket_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['ticket_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelations()
    {
        return $this->hasMany(Relation::className(), ['ticket_from_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelations0()
    {
        return $this->hasMany(Relation::className(), ['ticket_to_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpentTimes()
    {
        return $this->hasMany(SpentTime::className(), ['ticket_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubTickets()
    {
        return $this->hasMany(SubTicket::className(), ['ticket_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIteration()
    {
        return $this->hasOne(Iteration::className(), ['id' => 'iteration_id']);
    }
	
	public function getIterationDictionary()
    {
        return Iteration::find()->
			where(['<', 'status_id', 7])->
			andWhere(['project_id' => $this->project_id])->
			select('due_date, id')->indexBy('id')->column();
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
    public function getUserHasProjects()
    {
        return $this->hasMany(UserHasProject::className(), ['project_id' => 'project_id']);
    }
	
	public function getProjectDictionary()
    {
		return Project::find()->joinWith('userHasProjects')->where(['user_id'=>Yii::$app->user->Identity->id, 'is_active'=>true])->select('name, id')->indexBy('id')->column();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriority()
    {
        return $this->hasOne(Priority::className(), ['id' => 'priority_id']);
    }
	
	public function getPriorityDictionary()
	{
		return Priority::find()->select('name, id')->indexBy('id')->column();
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResolution()
    {
        return $this->hasOne(Resolution::className(), ['id' => 'resolution_id']);
    }
	
    public function getResolutionDictionary()
    {
        return Resolution::find()->select('name, id')->indexBy('id')->column();
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
	
	public function getTicketTypeDictionary()
    {
        return TicketType::find()->select('name, id')->indexBy('id')->column();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentTicket()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'parent_ticket_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['parent_ticket_id' => 'id']);
    }
	
	public function getTicketDictionary()
	{
		return Ticket::find()->
			joinWith('project')->
			joinWith('userHasProjects')->
			where($this->project_id ?
			['ticket.project_id' => $this->project_id] :
			[
				'user_has_project.user_id' => Yii::$app->user->id,
				'project.is_active' => true,
			])->
			andWhere(['<', 'status_id', 6])->
			andWhere(['<>', 'ticket_type_id', 4])->
			select(['subject'=>"CONCAT(ticket.id, '. ', ticket.subject)", 'ticket.id'])->indexBy('id')->column();
			
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
	
	public function getUserDictionary()
	{
		return User::find()->where(['is_active'=>true])->select('name, id')->indexBy('id')->column();
	}
}
