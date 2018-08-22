<?php

namespace common\models\admin;

use Yii;

/**
 * This is the model class for table "admin_info".
 *
 * @property int $id
 * @property int $user_id
 * @property string $nickname
 * @property string $avatar
 * @property string $phone
 *
 * @property Admin $user
 */
class AdminInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['nickname', 'phone'], 'string', 'max' => 20],
            [['avatar'], 'string', 'max' => 256],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'nickname' => '昵称',
            'avatar' => '头像',
            'phone' => '联系电话',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Admin::className(), ['id' => 'user_id']);
    }
}
