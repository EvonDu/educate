<?php

namespace common\models\preferential;

use Yii;

/**
 * This is the model class for table "preferential".
 *
 * @property int $id 活动编号
 * @property string $name 活动名称
 * @property string $remarks 活动备注
 * @property string $start_time 开始时间
 * @property string $end_time 结束时间
 */
class Preferential extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preferential';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['remarks'], 'string'],
            [['start_time', 'end_time'], 'required'],
            [['start_time', 'end_time'], 'safe'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => '活动编号',
            'name'          => '活动名称',
            'remarks'       => '活动备注',
            'start_time'    => '开始时间',
            'end_time'      => '结束时间',
        ];
    }
}
