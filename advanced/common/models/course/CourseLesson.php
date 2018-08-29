<?php

namespace common\models\course;

use Yii;

/**
 * This is the model class for table "course_lesson".
 *
 * @property int $id 聚集索引
 * @property int $course_id 课程ID
 * @property int $lesson 课号
 * @property string $title 标题
 * @property string $abstract 简介
 * @property string $video 视频
 * @property string $doc 课件
 * @property bool $is_public 是否公开
 * @property bool $is_homework 是否有作业
 *
 * @property Course $course
 */
class CourseLesson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_lesson';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'title'], 'required'],
            [['course_id', 'lesson'], 'integer'],
            [['abstract'], 'string'],
            [['is_public', 'is_homework'], 'boolean'],
            [['title'], 'string', 'max' => 120],
            [['video', 'doc'], 'string', 'max' => 250],
            [['course_id', 'lesson'], 'unique', 'targetAttribute' => ['course_id', 'lesson']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => '课程',
            'lesson' => '章节',
            'title' => '标题',
            'abstract' => '简介',
            'video' => '教程',
            'doc' => '课件',
            'is_public' => '是否免费',
            'is_homework' => '是否有作业',
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
     * 从数据库中获取最新章节号
     */
    public function autoGetLesson(){
        if($this->course_id){
            //查询数据库
            $sql = "SELECT MAX(lesson) as lesson FROM `".self::tableName()."` WHERE course_id = '$this->course_id'";
            $connection = Yii::$app->db;
            $command = $connection->createCommand($sql);
            $result = $command->queryAll();

            //获取最新章节号
            if(isset($result[0]["lesson"]) && $result[0]["lesson"] != null)
                $num = ++ $result[0]["lesson"];
            else
                $num = 1;

            //设置章节
            $this->lesson = $num;

            //DEBUG
            //var_dump($num);
            //die;
        }
        return;
    }
}
