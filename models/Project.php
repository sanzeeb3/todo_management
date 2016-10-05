<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $project_id
 * @property string $project_name
 * @property integer $profile_id
 * @property string $deadline
 * @property string $project_status
 * @property string $completed_date
 */
class Project extends \yii\db\ActiveRecord
{
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
            [['profile_id'], 'integer'],
            [['deadline', 'completed_date'], 'safe'],
            [['project_name', 'project_status'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_id' => 'Project ID',
            'project_name' => 'Project Name',
            'profile_id' => 'Profile ID',
            'deadline' => 'Deadline',
            'project_status' => 'Project Status',
            'completed_date' => 'Completed Date',
        ];
    }
}
