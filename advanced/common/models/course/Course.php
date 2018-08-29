<?php

namespace common\models\course;

use Yii;
use common\models\instructor\Instructor;
//use common\mo

/**
 * This is the model class for table "course".
 *
 * @property int $id 聚集索引
 * @property string $num 课程号
 * @property int $price 课程价格
 * @property int $instructor 课程导师
 * @property int $type 课程等级
 * @property string $name 课程名称
 * @property string $image 课程封面
 * @property int $level 课程难度
 * @property string $abstract 课程简介
 * @property string $content 课程内容
 * @property string $requirements_prerequisites 前提
 * @property string $requirements_textbooks 教科书
 * @property string $requirements_software 软件要求
 * @property string $requirements_hardware 硬件要求
 * @property int $next_term_at 下学期
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 *
 * @property CourseType $type0
 * @property Instructor $instructor0
 * @property CourseLesson[] $courseLessons
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num'], 'required'],
            [['price', 'instructor', 'type', 'level', 'next_term_at', 'created_at', 'updated_at'], 'integer'],
            [['abstract', 'content', 'requirements_prerequisites', 'requirements_textbooks', 'requirements_software', 'requirements_hardware'], 'string'],
            [['num', 'name'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 256],
            [['num'], 'unique'],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => CourseType::className(), 'targetAttribute' => ['type' => 'id']],
            [['instructor'], 'exist', 'skipOnError' => true, 'targetClass' => Instructor::className(), 'targetAttribute' => ['instructor' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num' => '编号',
            'price' => '价格',
            'instructor' => '导师',
            'type' => '类型',
            'name' => '名称',
            'image' => '封面',
            'level' => '难度',
            'abstract' => '简介',
            'content' => '内容',
            'requirements_prerequisites' => '课程要求 - 前提',
            'requirements_textbooks' => '课程要求 - 教材',
            'requirements_software' => '课程要求 - 软件',
            'requirements_hardware' => '课程要求 - 硬件',
            'next_term_at' => '下学期开课时间',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(CourseType::className(), ['id' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructor0()
    {
        return $this->hasOne(Instructor::className(), ['id' => 'instructor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseLessons()
    {
        return $this->hasMany(CourseLesson::className(), ['course_id' => 'id']);
    }
}
