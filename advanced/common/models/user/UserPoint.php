<?php

namespace common\models\user;

use api\lib\ModelErrors;
use Yii;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "user_point".
 *
 * @property int $user_id 用户ID
 * @property int $total 用户总积分
 *
 * @property User $user
 * @property UserPointHistory[] $history
 */
class UserPoint extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_point';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total'], 'required'],
            [['user_id', 'total'], 'integer'],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id'   => '用户ID',
            'total'     => '用户积分',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistory(){
        return $this->hasMany(UserPointHistory::className(), ['user_id' => 'user_id'])->orderBy('time DESC')->limit(10);
    }

    /**
     * 更变用户积分
     * @param $increment
     * @param string $remark
     * @return bool
     * @throws ServerErrorHttpException
     */
    public function changePoint($increment, $remark=""){
        //设置返回值
        $bool = true;

        //执行事务
        $tr = Yii::$app->db->beginTransaction();
        try {
            //修改积分总值
            $this->total += $increment;
            if(!$this->save())
                throw new ServerErrorHttpException(ModelErrors::getError($this));

            //记录变更历史
            $history = new UserPointHistory();
            $history->user_id = $this->user_id;
            $history->increment = $increment;
            $history->remark = $remark;
            $history->time = date("Y-m-d H:i:s");
            if(!$history->save())
                throw new ServerErrorHttpException(ModelErrors::getError($history));

            //提交
            $tr->commit();
        } catch (\Exception $e) {
            //修改返回值
            $bool = false;
            //回滚
            $tr->rollBack();
            //抛出错误
            throw new ServerErrorHttpException($e->getMessage());
        }

        //返回结果
        return $bool;
    }
}
