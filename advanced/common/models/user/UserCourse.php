<?php

namespace common\models\user;

use Yii;
use common\models\course\Course;

/**
 * This is the model class for table "user_course".
 *
 * @property int $user_id
 * @property int $course_id
 * @property int $created_at
 *
 * @property Course $course
 * @property User $user
 */
class UserCourse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_course';
    }

    /**
     * @return array
     */
    public function fields()
    {
        $parent = parent::fields();
        $parent["course"] = "course";
        return $parent;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'course_id'], 'required'],
            [['user_id', 'course_id', 'created_at'], 'integer'],
            [['user_id', 'course_id'], 'unique', 'targetAttribute' => ['user_id', 'course_id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户',
            'course_id' => '课程',
            'created_at' => '添加时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
