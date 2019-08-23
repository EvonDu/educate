<?php
/* @var $model common\models\order\Order */
/* @var $user_course common\models\user\UserCourse */
?>
<table bgcolor="#ffffff" width="100%" align="center" cellpadding="0" cellspacing="0" border="0" class="mktoModule tableCollapse" id="TextModuleBG" style="margin:0px auto; width:100%!important; min-width:100%!important;">
    <tbody>
        <tr>
            <td width="50" style="width:50px; font-size:0.0em; line-height:1px;">&nbsp;</td>
            <td class="mktEditable" id="MainTextBG1" style="font-family: Avenir, Montserrat, Helvetica, Arial, sans-serif; font-size: 14px; color: #111111; text-align:Left; line-height: 1.5em; font-weight:normal; text-transform: none;">
                <p>
                    <span style="color: #4c5960;">
                        <br/><br/>
                        尊敬的 <?=$user_course->user->nickname?> ：<br/><br/>
                        感谢您选择i-Link在线英语课程, 我们已经收到您支付 <?=$user_course->course->name?> 的费用 ¥<?=round($model->amount_fee/100,2)?>。您现在可以访问完整的 <?=$user_course->course->name?> 课程，包括<?=count($user_course->course->getCourseLessons())?>个单元及所有材料，按照您自己的进度开始学习吧！<br/><br/>
                        用户名：<?=$user_course->user->email?><br/>
                        开始日期：<?= Date("Y年m月d日")?><br/>
                        结束日期：<?= $user_course->try ? Date("Y年m月d日",$user_course->tryed_at) : Date("Y年m月d日",$user_course->used_at)?><br/><br/><br/>
                        请注意：您的专职老师将会在您提交作业后的5个工作日内批改您的作业。一旦您收到您的老师的作业评语您将进行下一课时的学习。<br/>
                        如果您在学习起见有任何疑问，请点击 帮助中心（Support） 或者发送邮件至<?=isset(Yii::$app->params["supportEmail"]) ? Yii::$app->params["supportEmail"] : "" ?>。我们将竭诚为您服务！<br/><br/>
                        祝学习进步！<br/>
                        i-Link 英语团队<br/><br/><br/>
                        <br/>
                    </span>
                </p>
            </td>
            <td width="50" style="width:50px; font-size:0.0em; line-height:1px;">&nbsp;</td>
        </tr>
    </tbody>
</table>