<?php
/* @var $this \yii\web\View */
/* @var $model common\models\task\TaskSubmit */

//引入类
use common\models\user\UserCourse;

//获取用户课程到期时间
$user_course = UserCourse::findOne(["user_id"=>$model->user->id,"course_id"=>$model->task->lesson->course->id]);
?>
<table bgcolor="#ffffff" width="100%" align="center" cellpadding="0" cellspacing="0" border="0" class="mktoModule tableCollapse" id="TextModuleBG" style="margin:0px auto; width:100%!important; min-width:100%!important;">
    <tbody>
    <tr>
        <td width="50" style="width:50px; font-size:0.0em; line-height:1px;">&nbsp;</td>
        <td class="mktEditable" id="MainTextBG1" style="font-family: Avenir, Montserrat, Helvetica, Arial, sans-serif; font-size: 14px; color: #111111; text-align:Left; line-height: 1.5em; font-weight:normal; text-transform: none;">
            <p>
                <br/><br/>
                <span style="color: #4c5960;">
                    尊敬的<?=$model->user->nickname?>：<br/><br/>
                    祝贺您成功完成了 <?=$model->task->lesson->course->name?> 课程！ 关于 <?=$model->task->lesson->title?> 的学习，我们给您一些课程提醒和近一步学习的提示。<br/><br/>
                    结束日期：<br/>
                    您的 <?=$model->task->lesson->course->name?> 的课程将于<?= $user_course->try ? Date("Y年m月d日",$user_course->tryed_at) : Date("Y-m-d",$user_course->used_at)?>到期。在此之前您可以随时访问并复习<?=$model->task->lesson->course->name?>的所有课程。 如果您需要更多时间复习，可以随时购买3个月的续订。 只需在课程中转到“个人中心”，然后单击“购买”选项卡，或者与我们联系。<br/><br/>
                    课程升级：<br/>
                    购买并学习更高级别的课程将您的语音提升到新的水平！ 您可以随时将课程升级到Level <?=$model->task->lesson->course->level + 1?>或Level <?=$model->task->lesson->course->level + 2?>，甚至整个 i-Link Phonics 课程。 在课程中单击您想购买的课程以查看可购买的级别。<br/><br/>
                    祝学习进步！<br/>
                    i-Link 英语团队<br/><br/>
                </span>
                <br/><br/>
            </p>
        </td>
        <td width="50" style="width:50px; font-size:0.0em; line-height:1px;">&nbsp;</td>
    </tr>
    </tbody>
</table>