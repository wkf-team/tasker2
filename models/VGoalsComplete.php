<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "v_goals_complete".
 *
 * @property integer $id
 * @property string $subject
 * @property integer $project_id
 * @property string $total
 * @property string $closed
 * @property string $due_date
 */
class VGoalsComplete extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_goals_complete';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'total'], 'integer'],
            [['subject', 'project_id'], 'required'],
            [['closed'], 'number'],
            [['due_date'], 'safe'],
            [['subject'], 'string', 'max' => 255],
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
            'project_id' => 'Project ID',
            'total' => 'Total',
            'closed' => 'Closed',
            'due_date' => 'Due Date',
        ];
    }
}
