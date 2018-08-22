<?php
namespace common\models\user;

use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ChangePasswordForm extends Model
{
    public $password;
    public $password_new;
    public $password_confirm;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['password', 'password_new', 'password_confirm'], 'required'],
            [['password' ,'password_new' ,'password_confirm'], 'string', 'min' => 6],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['password_confirm', 'validatePasswordRepeat'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '密码错误.');
            }
        }
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePasswordRepeat($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (($this->password_new != $this->password_confirm)) {
                $this->addError($attribute, '两次密码输入不一致.');
            }
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => '密码',
            'password_new' => '新密码',
            'password_confirm' => '再次输入密码',
        ];
    }

    /**
     * @return mixed
     */
    public function change(){
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUser();
        $user->setPassword($this->password_new);
        $user->removePasswordResetToken();

        if($user->save(false))
            return $user;
        else
            return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername(Yii::$app->user->identity->username);
        }

        return $this->_user;
    }

}
