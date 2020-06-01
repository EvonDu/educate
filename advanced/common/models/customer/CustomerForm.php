<?php
namespace common\models\customer;

use Yii;
use yii\db\Exception;

/**
 * Signup form
 * @property string $password
 */
class CustomerForm extends Customer
{
    //执行创建大客户
    public function create(){
        //验证表单
        if(!$this->validate())
            return false;

        //事务处理
        $bool = true;
        $tr = Yii::$app->db->beginTransaction();
        try {
            //保存大客户信息
            $model                  = new Customer();
            $model->name            = $this->name;
            $model->quantity        = $this->quantity;
            $model->courses         = $this->courses;
            $model->course_used_at  = $this->course_used_at/1000;
            $model->expiry_at       = $model->course_used_at;
            $model->created_at      = time();
            if(!$model->save())
                throw new Exception("创建大客户失败");

            //发放注册码
            if($model->quantity > 0){
                for($i=0;$i<$model->quantity;$i++){
                    $code                   = new CustomerCode();
                    $code->customer_id      = $model->id;
                    $code->code             = uniqid().rand(1000,9999);
                    $code->courses          = $model->courses;
                    $code->course_used_at   = $model->course_used_at;
                    $code->state            = 1;
                    $code->expiry_at        = $model->course_used_at;
                    $code->created_at       = time();
                    if(!$code->save())
                        throw new Exception("发放优惠码失败");
                }
            }

            //提交
            $tr->commit();
        } catch (\Exception $e) {
            //回滚
            $tr->rollBack();

            //设置
            $bool = false;
        }

        //根据结果处理
        if($bool){
            //回存id到form模型
            $this->id = $model->id;
        }

        //返回结果
        return $bool;
    }
}
