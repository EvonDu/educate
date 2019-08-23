<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\user\UserCourse;

class EmailController extends Controller
{
    /**
     * @var int 检测过期的天数
     */
    public $checkDays = 1;

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        echo "email cmd.\n";
    }

    /**
     * 试用过期
     * @return bool
     */
    public function actionTryExpire(){
        //获取当前时间
        $time_start = time();
        $time_end = $time_start + ( $this->checkDays* 24 * 60 * 60 );

        //获取这个时间段内过期的试用课程
        $list_try = UserCourse::find()
            ->andWhere(["=","try",true])
            ->andWhere([">","tryed_at",$time_start])
            ->andWhere(["<=","tryed_at",$time_end])
            ->all();

        //遍历发送邮件
        if(!empty($list_try)){
            foreach ($list_try as $item){
                //发送邮件
                Yii::$app->mailer->compose('template/expire.php', ["model"=>$item])
                    ->setFrom(Yii::$app->params["supportEmail"])
                    ->setTo([$item->user->email])
                    ->setSubject('i-Link 课程试用到期')
                    ->send();
            }
        }

        //发送完毕
        return true;
    }

    /**
     * 课程过期
     * @return bool
     */
    public function actionCourseExpire(){
        //获取当前时间
        $time_start = time();
        $time_end = $time_start + ( $this->checkDays* 24 * 60 * 60 );

        //获取这个时间段内过期的试用课程
        $list_try = UserCourse::find()
            ->andWhere(["=","try",false])
            ->andWhere([">","used_at",$time_start])
            ->andWhere(["<=","used_at",$time_end])
            ->all();

        //遍历发送邮件
        if(!empty($list_try)){
            foreach ($list_try as $item){
                //发送邮件
                Yii::$app->mailer->compose('template/expire.php', ["model"=>$item])
                    ->setFrom(Yii::$app->params["supportEmail"])
                    ->setTo([$item->user->email])
                    ->setSubject('i-Link 课程使用到期')
                    ->send();
            }
        }

        //发送完毕
        return true;
    }
}