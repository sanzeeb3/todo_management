<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "todo".
 *
 * @property integer $todo_id
 * @property string $todo_name
 * @property integer $project_id
 * @property string $status
 * @property string $todocompleted_date
 */
class Todo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'todo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id'], 'required'],
            [['project_id'], 'integer'],
            [['todocompleted_date'], 'safe'],
            [['todo_name'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'todo_id' => 'Todo ID',
            'todo_name' => 'Todo Name',
            'project_id' => 'Project ID',
            'status' => 'Status',
            'todocompleted_date' => 'Todocompleted Date',
        ];
    }
}
