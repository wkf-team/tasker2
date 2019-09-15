<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_active
 * @property string $mail
 * @property string $password
 * @property integer $work_time_per_week
 * @property integer $usergroup_id
 * @property integer $notification_enabled
 * @property integer $digest_enabled
 *
 * @property Attachment[] $attachments
 * @property Comment[] $comments
 * @property SpentTime[] $spentTimes
 * @property SubTicket[] $subTickets
 * @property Ticket[] $tickets
 * @property Ticket[] $tickets0
 * @property Ticket[] $tickets1
 * @property Ticket[] $tickets2
 * @property TicketHistory[] $ticketHistories
 * @property TicketHistory[] $ticketHistories0
 * @property TicketHistory[] $ticketHistories1
 * @property TicketHistory[] $ticketHistories2
 * @property TicketHistory[] $ticketHistories3
 * @property Usergroup $usergroup
 * @property UserHasProject[] $userHasProjects
 * @property Project[] $projects
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
	public static function CheckLevel($level)
	{
		if ($level == 0) return true;
		if (Yii::$app->user->isGuest) return false;
		return Yii::$app->user->Identity->usergroup->level >= $level;
	}
	
	public static function findIdentity($id)
	{
        return static::findOne($id);
    }
	
	public static function findByUsername($name)
	{
		return static::findOne(['name' => $name]);
	}

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['name' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->password;
    }

    public function validateAuthKey($auth_key)
    {
        return $this->password === $auth_key;
    }
	
	public function validatePassword($password)
	{
		return $this->password === crypt($password, $this->password) && ($this->usergroup->level >= 20);
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'usergroup_id', 'notification_enabled', 'digest_enabled'], 'required'],
            [['is_active', 'work_time_per_week', 'usergroup_id', 'notification_enabled', 'digest_enabled'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['mail', 'password'], 'string', 'max' => 255],
            [['usergroup_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usergroup::className(), 'targetAttribute' => ['usergroup_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'is_active' => 'Is Active',
            'mail' => 'Mail',
            'password' => 'Password',
            'work_time_per_week' => 'Work Time Per Week',
            'usergroup_id' => 'Usergroup ID',
            'notification_enabled' => 'Notification Enabled',
            'digest_enabled' => 'Digest Enabled',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpentTimes()
    {
        return $this->hasMany(SpentTime::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubTickets()
    {
        return $this->hasMany(SubTicket::className(), ['owner_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['author_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets0()
    {
        return $this->hasMany(Ticket::className(), ['owner_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets1()
    {
        return $this->hasMany(Ticket::className(), ['tester_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets2()
    {
        return $this->hasMany(Ticket::className(), ['responsible_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketHistories()
    {
        return $this->hasMany(TicketHistory::className(), ['hist_create_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketHistories0()
    {
        return $this->hasMany(TicketHistory::className(), ['author_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketHistories1()
    {
        return $this->hasMany(TicketHistory::className(), ['owner_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketHistories2()
    {
        return $this->hasMany(TicketHistory::className(), ['tester_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketHistories3()
    {
        return $this->hasMany(TicketHistory::className(), ['responsible_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsergroup()
    {
        return $this->hasOne(Usergroup::className(), ['id' => 'usergroup_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserHasProjects()
    {
        return $this->hasMany(UserHasProject::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])->viaTable('user_has_project', ['user_id' => 'id']);
    }
}
