<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $token
 * @property integer $position
 * @property integer $status
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position', 'status'], 'integer'],
            [['username', 'email'], 'string', 'max' => 30],
            [['password', 'token'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'token' => 'Token',
            'position' => 'Position',
            'status' => 'Status',
        ];
    }
}
