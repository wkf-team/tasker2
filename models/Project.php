<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string $name
 * @property string $start_date
 * @property integer $is_active
 * @property string $current_version
 * @property string $next_version
 *
 * @property Iteration[] $iterations
 * @property Ticket[] $tickets
 * @property TicketHistory[] $ticketHistories
 * @property UserHasProject[] $userHasProjects
 * @property User[] $users
 */
class Project extends \yii\db\ActiveRecord
{
	public static function GetSelected()
	{
		$selected = Project::find()->
			joinWith('userHasProjects')->
			where(['is_selected'=>true, 'user_id'=>Yii::$app->user->id])->one();
		if ($selected) return $selected;
		$user = Yii::$app->user->Identity;
		if ($user && count($user->projects) > 0) {
			return $user->projects[0];
		}
		return null;
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'start_date', 'is_active'], 'required'],
            [['start_date'], 'safe'],
            [['is_active'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['current_version', 'next_version'], 'string', 'max' => 25],
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
            'start_date' => 'Start Date',
            'is_active' => 'Is Active',
            'current_version' => 'Current Version',
            'next_version' => 'Next Version',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIterations()
    {
        return $this->hasMany(Iteration::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketHistories()
    {
        return $this->hasMany(TicketHistory::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserHasProjects()
    {
        return $this->hasMany(UserHasProject::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_has_project', ['project_id' => 'id']);
    }
}
