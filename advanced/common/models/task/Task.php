<?php

namespace common\models\task;

use Yii;
use common\models\course\Course;
use common\models\course\CourseLesson;
use yii\db\Query;

/**
 * This is the model class for table "task".
 *
 * @property int $id 作业ID
 * @property int $type 作业类型
 * @property int $course_id 课程ID
 * @property int $lesson_id 章节ID
 * @property string $title 作业标题
 * @property string $content 作业内容
 * @property string $file 作文文件
 * @property string $audio 作业音频
 * @property int $created_at 创建时间
 * @property int $finish_at 结束时间
 *
 * @property Course $course
 * @property CourseLesson $lesson
 * @property TaskSubmit[] $taskSubmits
 */
class Task extends \yii\db\ActiveRecord
{
    public function init()
    {
        // TODO: Change the autogenerated stub
        parent::init();

        //设置默认值
        if($this->className() == __CLASS__){
            $this->created_at = time();
            $this->type = 0;
        }
    }

    /**
     * @return array
     */
    public function fields()
    {
        // TODO: Change the autogenerated stub
        $parent = parent::fields();
        $parent['finish'] = 'finish';
        return $parent;
    }

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
            [['type', 'course_id', 'lesson_id', 'created_at', 'finish_at'], 'integer'],
            [['course_id', 'lesson_id', 'title', 'content'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['file', 'audio'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型',
            'typeName' => '类型',
            'course_id' => '课程',
            'lesson_id' => '章节',
            'title' => '标题',
            'content' => '内容',
            'file' => '文件',
            'audio' => '音频',
            'created_at' => '创建时间',
            'finish_at' => '结束时间',
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
    public function getLesson()
    {
        return $this->hasOne(CourseLesson::className(), ['id' => 'lesson_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskSubmits()
    {
        return $this->hasMany(TaskSubmit::className(), ['task_id' => 'id']);
    }

    /**
     * @return mixed|string
     */
    public function getTypeName(){
        $map = self::getTypeMap();
        return empty($map[$this->type]) ? "" : $map[$this->type];
    }

    /**
     * @return bool
     */
    public function getFinish(){
        if($this->finish_at > time())
            return false;
        else
            return true;
    }

    /**
     * @return array
     */
    static public function getTypeMap(){
        return [
            0=>"文本",
            1=>"音频",
            2=>"文本+音频"
        ];
    }

    /**
     * @param null $course_id
     * @param null $lesson_id
     * @return array|\yii\db\ActiveRecord[]
     */
    static public function getTasks($course_id=null, $lesson_id=null){
        $find = self::find();
        if($course_id != null)
            $find->andWhere(["course_id"=>$course_id]);
        if($lesson_id != null)
            $find->andWhere(["lesson_id"=>$lesson_id]);
        return $find->all();
    }

    /**
     * 获取用户作业
     * @param $user_id
     * @param null $course_id
     * @param null $lesson_id
     * @return array|\yii\db\ActiveRecord[]
     */
    static public function getUserTasks($user_id,$course_id=null, $lesson_id=null){
        $from1 = self::tableName();
        $from2 = TaskSubmit::tableName();
        $find = new Query();
        $find->distinct()->
            select([
                "$from1.*",
                "IFNULL($from2.status, 0) AS status"
            ])
            ->from($from1)
            ->leftJoin($from2,"$from1.id = $from2.task_id AND $from2.user_id='$user_id'");
        if($course_id != null)
            $find->andWhere(["$from1.course_id"=>$course_id]);
        if($lesson_id != null)
            $find->andWhere(["$from1.lesson_id"=>$lesson_id]);

        return $find->all();
    }
}
