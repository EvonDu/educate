<?php

namespace common\models\customer;

use common\models\course\Course;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "customer".
 *
 * @property int $id 客户ID
 * @property string $name 客户名称
 * @property int $quantity 发放数量
 * @property array $courses 相关课程(数组)
 * @property int $course_used_at 课程使用截止日期
 * @property int $expiry_at 客户兑换码过期日期(预留)
 * @property int $created_at 创建时间
 *
 * @property CustomerCode[] $codes 大客户激活码
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'quantity', 'courses', 'course_used_at'], 'required'],
            [['quantity', 'course_used_at', 'expiry_at', 'created_at'], 'integer'],
            [['courses'], 'safe'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'name'              => '客户名称',
            'quantity'          => '发放数量',
            'courses'           => '相关课程',
            'coursesName'       => '相关课程',
            'codesHtml'         => '兑换码',
            'course_used_at'    => '课程到期时间',
            'expiry_at'         => '过期时间',
            'created_at'        => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodes()
    {
        return $this->hasMany(CustomerCode::className(), ['customer_id' => 'id'])->orderBy('id');
    }

    /**
     * @return string
     */
    public function getCoursesName(){
        $str = "";
        $course_map = Course::getCourseMap();
        foreach ($this->courses as $courses_id){
            if(isset($course_map[$courses_id]))
                $str .= empty($str) ? "$course_map[$courses_id]" : ",$course_map[$courses_id]";
        }
        return $str;
    }

    /**
     * @return string
     */
    public function getCodesHtml(){
        $tr = [];
        foreach ($this->codes as $code){
            $td_code = Html::tag("td",$code->code);
            $td_state = Html::tag("td",$code->state === 1 ? '未激活' : '已激活', ['style'=>['color'=>'#3c8dbc', 'padding'=>'0 12px']]);
            $tr[] = Html::tag("tr",$td_code.$td_state);
        }
        $table = Html::tag("table",implode("\n",$tr));

        return $table;
    }
}
