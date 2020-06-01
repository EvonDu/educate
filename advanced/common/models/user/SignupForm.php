<?php
namespace common\models\user;

use Yii;
use yii\base\Model;

/**
 * Signup form
 * @property string $password
 */
class SignupForm extends User
{
    private $password;

    /**
     * @return string
     */
    public function getPassword(){
        return $this->password;
    }

    /**
     * @param $value
     */
    public function setPassword($value){
        $this->password = $value;
        $this->password_hash = Yii::$app->security->generatePasswordHash($value);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => '密码',
        ];
    }
}
