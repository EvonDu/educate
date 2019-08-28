<?php

namespace common\models\customer;

use Yii;

/**
 * This is the model class for table "customer_code".
 *
 * @property int $id ID
 * @property int $customer_id 所属客户
 * @property string $code 兑换码
 * @property array $courses 兑换课程(数组,冗余优化查询)
 * @property int $course_used_at 课程使用截止时间(冗余优化查询)
 * @property int $state 兑换券状态
 * @property int $expiry_at 兑换码有效期(预留)
 * @property int $created_at 创建时间
 *
 * @property Customer $customer 大客户
 */
class CustomerCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'code', 'courses', 'course_used_at'], 'required'],
            [['customer_id', 'course_used_at', 'state', 'expiry_at', 'created_at'], 'integer'],
            [['courses'], 'safe'],
            [['code'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'customer_id'       => 'Customer ID',
            'code'              => 'Code',
            'state'             => 'State',
            'courses'           => 'Courses',
            'course_used_at'    => 'Course Used At',
            'expiry_at'         => 'Expiry At',
            'created_at'        => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
