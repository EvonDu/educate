<?php

namespace common\models\course;

use Yii;
use common\models\instructor\Instructor;

/**
 * This is the model class for table "course".
 *
 * @property int $id 聚集索引
 * @property string $num 课程号
 * @property int $price 课程价格
 * @property int $price_dollar 课程价格(美金)
 * @property int $instructor_id 课程导师
 * @property int $type_id 课程等级
 * @property string $name 课程名称
 * @property string $name_en 课程名称(英)
 * @property string $image 课程封面
 * @property int $level 课程难度
 * @property int $period 课程课时
 * @property string $synopsis 课程摘要
 * @property string $synopsis_en 课程摘要(英)
 * @property string $abstract 课程简介
 * @property string $abstract_en 课程简介(英)
 * @property string $requirements_prerequisites 前提
 * @property string $requirements_textbooks 教科书
 * @property string $requirements_software 软件要求
 * @property string $requirements_hardware 硬件要求
 * @property string $requirements_prerequisites_en 前提(英)
 * @property string $requirements_textbooks_en 教科书(英)
 * @property string $requirements_software_en 软件要求(英)
 * @property string $requirements_hardware_en 硬件要求(英)
 * @property int $next_term_at 下学期
 * @property bool $try 支持试用
 * @property int $try_day 试用天数
 * @property int $buy_day 购买天数(购买后可以使用的天数)
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 *
 * @property CourseType $type
 * @property Instructor $instructor
 * @property CourseLesson[] $courseLessons
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * init
     */
    public function init()
    {
        //初始值
        $this->buy_day = 180;
        $this->try_day = 30;
        $this->period = 18;
        //父函数
        parent::init(); // TODO: Change the autogenerated stub
    }

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
            [['price', 'price_dollar', 'instructor_id', 'type_id', 'level', 'period', 'next_term_at', 'try_day', 'buy_day', 'created_at', 'updated_at'], 'integer'],
            [['synopsis', 'synopsis_en', 'abstract', 'abstract_en'], 'string'],
            [['requirements_prerequisites', 'requirements_textbooks', 'requirements_software', 'requirements_hardware'], 'string'],
            [['requirements_prerequisites_en', 'requirements_textbooks_en', 'requirements_software_en', 'requirements_hardware_en'], 'string'],
            [['try'], 'boolean'],
            [['num', 'name', 'name_en'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 256],
            [['num'], 'unique'],
            [['num'], 'ruleCheckLegitimate' ,'params'=>[]],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CourseType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['instructor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Instructor::className(), 'targetAttribute' => ['instructor_id' => 'id']],
            [['price', 'price_dollar'], 'compare', 'compareValue' => 10000000, 'operator' => '<='],
        ];
    }

    /**
     * @return array
     */
    public function fields()
    {
        $parent = parent::fields();
        $parent["instructor"] = "instructor";
        $parent["courseCatalog"] = "courseCatalog";
        return $parent;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num' => '编号',
            'type_id' => '类型',
            'instructor_id' => '导师ID',
            'price' => '价格',
            'price_dollar' => '价格（美金）',
            'name' => '名称',
            'name_en' => '名称（英）',
            'image' => '封面',
            'level' => '难度',
            'period' => '课时',
            'synopsis' => '摘要',
            'synopsis_en' => '摘要(英)',
            'abstract' => '简介',
            'abstract_en' => '简介(英)',
            'requirements_prerequisites' => '课程要求 - 前提',
            'requirements_textbooks' => '课程要求 - 教材',
            'requirements_software' => '课程要求 - 软件',
            'requirements_hardware' => '课程要求 - 硬件',
            'requirements_prerequisites_en' => '课程要求 - 前提(英)',
            'requirements_textbooks_en' => '课程要求 - 教材(英)',
            'requirements_software_en' => '课程要求 - 软件(英)',
            'requirements_hardware_en' => '课程要求 - 硬件(英)',
            'next_term_at' => '下学期开课时间',
            'try' => '试用',
            'try_day' => '试用天数',
            'buy_day' => '购买天数',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(CourseType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructor()
    {
        return $this->hasOne(Instructor::className(), ['id' => 'instructor_id']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if($insert){
            $this->created_at = time();
        }
        $this->updated_at = time();

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseLessons()
    {
        return $this->hasMany(CourseLesson::className(), ['course_id' => 'id'])->orderBy('lesson');
    }

    /**
     * @return array
     */
    public function getCourseCatalog(){
        $result = [];
        $lessons = $this->courseLessons;
        if($lessons){
            foreach($lessons as $item){
                $result[] = [
                    "id" => $item->id,
                    "title" => $item->title
                ];
            }
        }
        return $result;
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function ruleCheckLegitimate($attribute, $params){
        if(preg_match("/[\s]/",$this->$attribute))
            $this->addError($attribute, "请勿使用空格等特殊符号");
        if(preg_match("/[-]/",$this->$attribute))
            $this->addError($attribute, "请勿使用空格等特殊符号");
    }
}
