<?php
namespace common\models\email;

use common\models\user\User;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Signup form
 * @property string $password
 */
class EmailPushForm extends Model
{
    /**
     * @var
     */
    public $content;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            ['content', 'required'],
            ['content', 'string', 'min' => 6],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'content' => '推送内容',
        ];
    }

    /**
     * 推送邮件
     * @return bool
     */
    public function push(){
        //获取发送列表
        $users = User::find()->all();
        $emails = ArrayHelper::getColumn($users,"email");

        //发送邮件
        $result = Yii::$app->mailer->compose('pushEmail-html.php', ['content'=>$this->content])
            ->setFrom("evon_auto@163.com")
            ->setTo($emails)
            ->setSubject('i-Link Education Register')
            ->send();

        //返回结果
        return $result;
    }
}
