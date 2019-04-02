<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "relation_type".
 *
 * @property integer $id
 * @property string $direct_name
 * @property string $reverse_name
 *
 * @property Relation[] $relations
 */
class RelationType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relation_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['direct_name', 'reverse_name'], 'required'],
            [['direct_name', 'reverse_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'direct_name' => 'Direct Name',
            'reverse_name' => 'Reverse Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelations()
    {
        return $this->hasMany(Relation::className(), ['relation_type_id' => 'id']);
    }
}
