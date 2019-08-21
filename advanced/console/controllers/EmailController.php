<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\user\UserCourse;

class EmailController extends Controller
{
    public function actionIndex()
    {
        echo "email\n";
    }

    /**
     * 课程过期(试用)
     * @return bool
     */
    public function actionTryCourseExpire(){
        //获取当前时间
        $time_start = time();
        $time_end = $time_start + (24 * 60 * 60);

        //获取这个时间段内过期的试用课程
        $list_try = UserCourse::find()
            ->andWhere(["=","try",true])
            ->andWhere([">","tryed_at",$time_start])
            ->andWhere(["<=","tryed_at",$time_end])
            ->all();

        //遍历发送邮件
        if(!empty($list_try)){
            foreach ($list_try as $item){
                //参数设置
                $email = $item->user->email;
                $user_name = $item->user->nickname;
                $course_name = $item->course->name;

                //发送邮件
                $result = Yii::$app->mailer->compose('tryExpire-html.php', ['user_name'=>$user_name,'course_name'=>$course_name,])
                    ->setFrom("evon_auto@163.com")
                    ->setTo([$email])
                    ->setSubject('i-Link Education Register')
                    ->send();

                //发送结果
                return $result;
            }
        }
    }

    /**
     * 课程过期(购买)
     * @return bool
     */
    public function actionUseCourseExpire(){
        //获取当前时间
        $time_start = time();
        $time_end = $time_start + (24 * 60 * 60);

        //获取这个时间段内过期的试用课程
        $list_try = UserCourse::find()
            ->andWhere(["=","try",false])
            ->andWhere([">","used_at",$time_start])
            ->andWhere(["<=","used_at",$time_end])
            ->all();

        //遍历发送邮件
        if(!empty($list_try)){
            foreach ($list_try as $item){
                //参数设置
                $email = $item->user->email;
                $user_name = $item->user->nickname;
                $course_name = $item->course->name;

                //发送邮件
                $result = Yii::$app->mailer->compose('tryExpire-html.php', ['user_name'=>$user_name,'course_name'=>$course_name,])
                    ->setFrom("evon_auto@163.com")
                    ->setTo([$email])
                    ->setSubject('i-Link Education Register')
                    ->send();

                //发送结果
                return $result;
            }
        }
    }
}