<?php

namespace common\models\user;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $auth_key
 * @property string $login_token
 * @property string $password_hash
 * @property string $password_reset_token
 * @property int $status
 * @property int $sex 性别
 * @property string $nickname 名
 * @property string $avatar 头像
 * @property string $phone 电话
 * @property string $country 国家
 * @property string $city 城市
 * @property string $adderss_1 地址1
 * @property string $adderss_2 地址2
 * @property string $customer 所属大客户(名称)
 * @property int $created_at
 * @property int $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'nickname'], 'required'],
            [['status', 'sex', 'created_at', 'updated_at'], 'integer'],
            [['email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['nickname', 'phone'], 'string', 'max' => 20],
            [['avatar', 'adderss_1', 'adderss_2', 'customer'], 'string', 'max' => 256],
            [['country', 'city'], 'string', 'max' => 50],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['login_token'], 'string', 'max' => 128],
        ];
    }

    /**
     * @return array
     */
    public function fields()
    {
        $parent = parent::fields();
        unset($parent["auth_key"]);
        unset($parent["password_hash"]);
        unset($parent["password_reset_token"]);
        return $parent;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_key' => 'Auth Key',
            'login_token' => 'Login Token',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮箱',
            'status' => '状态',
            'statusName' => '状态',
            'sex' => '性别',
            'sexName' => '性别',
            'nickname' => '昵称',
            'avatar' => '头像',
            'phone' => '电话',
            'country' => '国家',
            'city' => '城市',
            'adderss_1' => '地址1',
            'adderss_2' => '地址2',
            'customer' => '所属客户',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if($insert){
            $this->auth_key = Yii::$app->security->generateRandomString();
            $this->created_at = time();
        }
        $this->updated_at = time();

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * @return mixed
     */
    public function getStatusName(){
        $map = self::getStatusMap();
        return $map[$this->status];
    }

    /**
     * @return string
     */
    public function getSexName(){
        if($this->sex == 1)
            return "男";
        else if($this->sex == 0)
            return "女";
        else
            return "未设置";
    }

    /**
     * @return string
     */
    public function getAvatarUrl(){
        return $this->avatar;
    }

    /**
     * 刷新登录Token(注意:会造成保存)
     */
    public function refreshLoginToken(){
        $this->login_token = uniqid();
        $this->save();
    }

    /**
     * @return array
     */
    static public function getStatusMap(){
        return [
            0 => '冻结',
            1 => '正常',
        ];
    }
}
