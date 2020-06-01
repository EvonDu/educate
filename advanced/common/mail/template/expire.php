<?php
/* @var $model common\models\user\UserCourse */
?>
<table bgcolor="#ffffff" width="100%" align="center" cellpadding="0" cellspacing="0" border="0" class="mktoModule tableCollapse" id="TextModuleBG" style="margin:0px auto; width:100%!important; min-width:100%!important;">
    <tbody>
        <tr>
            <td width="50" style="width:50px; font-size:0.0em; line-height:1px;">&nbsp;</td>
            <td class="mktEditable" id="MainTextBG1" style="font-family: Avenir, Montserrat, Helvetica, Arial, sans-serif; font-size: 14px; color: #111111; text-align:Left; line-height: 1.5em; font-weight:normal; text-transform: none;">
                <p>
                    <span style="color: #4c5960;">
                        <br/><br/>
                        尊敬的<?=$model->user->nickname?>：<br/><br/>
                        我们希望您的 i-Link Phonics 课程学习进展顺利！关于您的课程我们给您以下重要提醒。<br/><br/>
                        结束日期：<br/>
                        您应该在<?= $model->try ? Date("Y年m月d日",$model->tryed_at) : Date("Y年m月d日",$model->used_at)?>之前访问并完成 <?=$model->course->name?> 的所有课程。 别担心 - 如果您需要更多时间，可以随时购买3个月的续订。 只需在课程中转到“个人中心”，然后单击“购买”选项卡，或者与我们联系。<br/><br/>
                        课程升级：<br/>
                        购买并学习更高级别的课程将您的语音提升到新的水平！ 您可以随时将课程升级到Level <?=$model->course->level + 1?>或Level <?=$model->course->level + 2?>，甚至整个i-Link Phonics 课程。 在课程中单击您想购买的课程以查看可购买的级别。<br/><br/><br/>
                        祝学习进步！<br/>
                        i-Link 英语团队
                        <br/><br/>
                    </span>
                </p>
            </td>
            <td width="50" style="width:50px; font-size:0.0em; line-height:1px;">&nbsp;</td>
        </tr>
    </tbody>
</table>