<?php

namespace common\models\preferential;

use Yii;

/**
 * This is the model class for table "preferential_items".
 *
 * @property int $id 活动项编号
 * @property int $preferential_id 所属活动
 * @property int $course_id 活动课程
 * @property string $course_name 课程名称
 * @property int $price_original 课程原价
 * @property int $price 活动价格
 *
 * @property Preferential $preferential
 */
class PreferentialItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preferential_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preferential_id', 'course_id', 'course_name', 'price', 'price_original'], 'required'],
            [['preferential_id', 'course_id', 'price', 'price_original'], 'integer'],
            [['course_name'], 'string', 'max' => 50],
            [['preferential_id'], 'exist', 'skipOnError' => true, 'targetClass' => Preferential::className(), 'targetAttribute' => ['preferential_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => '活动项编号',
            'preferential_id'   => '所属活动',
            'course_id'         => '活动课程',
            'course_name'       => '课程名称',
            'price_original'    => '课程原价',
            'price'             => '活动价格',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreferential()
    {
        return $this->hasOne(Preferential::className(), ['id' => 'preferential_id']);
    }
}
