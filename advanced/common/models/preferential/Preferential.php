<?php

namespace common\models\preferential;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "preferential".
 *
 * @property int $id 活动编号
 * @property string $name 活动名称
 * @property string $remarks 活动备注
 * @property string $start_time 开始时间
 * @property string $end_time 结束时间
 *
 * @property PreferentialItem[] $items
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
    public function fields(){
        $parent = parent::fields();
        $parent['items'] = 'items';
        return $parent;
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
            'items'         => '活动内容',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(PreferentialItem::className(), ['preferential_id' => 'id']);
    }

    /**
     * 保存模型全部内容，包含items
     * @param $params
     * @param null $formName
     * @return bool
     */
    public function saveAll($params, $formName = null){
        $scope = $formName === null ? $this->formName() : $formName;
        $tr = Yii::$app->db->beginTransaction();
        try {
            //保存模型
            $this->load(Yii::$app->request->post(), $scope);
            if(!$this->save())
                throw new Exception("save fail");
            //删除所有子项目
            PreferentialItem::deleteAll(["preferential_id" => $this->id]);
            //保存子项目
            if(!empty($params[$scope]['items'])){
                foreach ($params[$scope]['items'] as $item){
                    $model_item = new PreferentialItem();
                    $model_item->load($item, "");
                    $model_item->preferential_id = $this->id;
                    if(!$model_item->save())
                        throw new Exception("save fail");
                }
            }
            //提交
            $tr->commit();
            return true;
        } catch (Exception $e) {
            //回滚
            $tr->rollBack();
            return false;
        }
    }
}
