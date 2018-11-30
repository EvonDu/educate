<?php

namespace common\models\course;

use Yii;
use common\models\user\User;
use common\models\course\CourseLesson;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $user_id
 * @property int $lesson_id
 * @property string $content
 * @property string $reply
 * @property int $status
 * @property int $submit_at
 * @property int $reply_at
 *
 * @property CourseLesson $lesson
 * @property User $user
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'lesson_id'], 'required'],
            [['user_id', 'lesson_id', 'status', 'submit_at', 'reply_at'], 'integer'],
            [['content', 'reply'], 'string'],
            [['lesson_id'], 'exist', 'skipOnError' => true, 'targetClass' => CourseLesson::className(), 'targetAttribute' => ['lesson_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'lesson_id' => 'Lesson ID',
            'content' => 'Content',
            'reply' => 'Reply',
            'status' => 'Status',
            'submit_at' => 'Submit At',
            'reply_at' => 'Reply At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLesson()
    {
        return $this->hasOne(CourseLesson::className(), ['id' => 'lesson_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * 章节作业
     * @param $lesson_id
     * @return array|\yii\db\ActiveRecord[]
     */
    static public function getTasks($user_id = null, $lesson_id = null, $status = null){
        $find = self::find();
        if(!empty($lesson_id))
            $find->andWhere(["lesson_id"=>$lesson_id]);
        if(!empty($user_id))
            $find->andWhere(["user_id"=>$user_id]);
        if(!empty($status))
            $find->andWhere(["status"=>$status]);
        $find->orderBy("submit_at desc");
        $list = $find->all();
        return $list;
    }
}
