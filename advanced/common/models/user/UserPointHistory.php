<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_point_history".
 *
 * @property int $id ID
 * @property int $user_id 用户ID
 * @property int $increment 积分变动
 * @property string $remark 积分变动内容
 * @property string $time 积分变动时间
 *
 * @property User $user
 */
class UserPointHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_point_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'increment', 'remark', 'time'], 'required'],
            [['user_id', 'increment'], 'integer'],
            [['time'], 'safe'],
            [['remark'], 'string', 'max' => 128],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'increment' => 'Increment',
            'remark' => 'Remark',
            'time' => 'Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
