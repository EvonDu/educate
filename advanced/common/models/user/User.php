<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property int $status
 * @property string $firstname 名
 * @property string $lastname 姓
 * @property string $avatar 头像
 * @property string $phone 电话
 * @property string $country 国家
 * @property string $city 城市
 * @property string $adderss_1 地址1
 * @property string $adderss_2 地址2
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
            [['email', 'auth_key', 'password_hash', 'firstname', 'lastname', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['firstname', 'lastname', 'phone'], 'string', 'max' => 20],
            [['avatar', 'adderss_1', 'adderss_2'], 'string', 'max' => 256],
            [['country', 'city'], 'string', 'max' => 50],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮箱',
            'status' => '状态',
            'statusName' => '状态',
            'firstname' => '名',
            'lastname' => '姓',
            'avatar' => '头像',
            'phone' => '电话',
            'country' => '国家',
            'city' => '城市',
            'adderss_1' => '地址1',
            'adderss_2' => '地址2',
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
        if($insert)
            $this->created_at = time();
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
     * @return array
     */
    static public function getStatusMap(){
        return [
            0 => '冻结',
            1 => '正常',
        ];
    }
}
