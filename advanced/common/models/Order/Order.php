<?php

namespace common\models\order;

use Yii;
use common\models\user\User;
use common\models\course\Course;

/**
 * This is the model class for table "order".
 *
 * @property string $order_no
 * @property int $channel
 * @property string $type
 * @property string $openid
 * @property string $body
 * @property int $amount_fee
 * @property string $trade_no
 * @property int $user_id
 * @property int $course_id
 * @property string $datetime
 *
 * @property User $user
 * @property Course $course
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_no', 'openid', 'body', 'trade_no', 'user_id', 'course_id', 'datetime'], 'required'],
            [['channel', 'amount_fee', 'user_id', 'course_id'], 'integer'],
            [['datetime'], 'safe'],
            [['order_no', 'openid', 'trade_no'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 10],
            [['body'], 'string', 'max' => 250],
            [['order_no'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_no' => 'Order No',
            'channel' => 'Channel',
            'type' => 'Type',
            'openid' => 'Openid',
            'body' => 'Body',
            'amount_fee' => 'Amount Fee',
            'trade_no' => 'Trade No',
            'user_id' => 'User ID',
            'course_id' => 'Course ID',
            'datetime' => 'Datetime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
