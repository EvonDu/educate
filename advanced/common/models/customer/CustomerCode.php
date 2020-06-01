<?php

namespace common\models\customer;

use common\models\user\UserCourse;
use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "customer_code".
 *
 * @property int $id ID
 * @property int $customer_id 所属客户
 * @property string $code 兑换码
 * @property array $courses 兑换课程(数组,冗余优化查询)
 * @property int $course_used_at 课程使用截止时间(冗余优化查询)
 * @property int $state 兑换券状态
 * @property int $redeem_user_id 兑换用户ID
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
            [['customer_id', 'course_used_at', 'state', 'redeem_user_id', 'expiry_at', 'created_at'], 'integer'],
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
            'redeem_user_id'    => 'Redeem User Id',
            'courses'           => 'Courses',
            'course_used_at'    => 'Course Used At',
            'expiry_at'         => 'Expiry At',
            'created_at'        => 'Created At',
        ];
    }

    //使用兑换码兑换课程
    public function redeem($user_id){
        //判断使用状态
        if($this->state != 1)
            throw new Exception("兑换码已使用");

        //执行事务
        $tr = Yii::$app->db->beginTransaction();
        try {
            //遍历处理所有课程
            foreach ($this->courses as $course_id){
                //获取用户课程
                $user_course = UserCourse::findOne(["user_id"=>$user_id, "course_id"=>$course_id]);
                if(empty($user_course)){
                    $user_course            = new UserCourse();
                    $user_course->user_id   = $user_id;
                    $user_course->course_id = $course_id;
                }

                //设置属性
                $user_course->try       = false;
                $user_course->used_at   = max($user_course->tryed_at, $user_course->used_at, $this->course_used_at);
                $user_course->tryed_at  = $user_course->used_at;

                //保存信息
                if(!$user_course->save())
                    throw new Exception("保存用户课程信息失败");
            }
            //修改使用状态
            $this->state = 2;
            $this->redeem_user_id = $user_id;
            if (!$this->save())
                throw new Exception("修改兑换码状态失败");
            //提交
            $tr->commit();
        } catch (Exception $e) {
            //回滚
            $tr->rollBack();
            //抛出错误
            throw new \Exception($e->getMessage());
        }

        //返回结果
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
