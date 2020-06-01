<?php

namespace common\models\instructor;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "instructor".
 *
 * @property int $id
 * @property string $name
 * @property string $avatar
 * @property string $title
 * @property string $tags
 * @property string $abstract
 * @property int $created_at
 * @property int $updated_at
 */
class Instructor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instructor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['tags', 'abstract'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'title'], 'string', 'max' => 50],
            [['avatar'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '导师名称',
            'avatar' => '头像',
            'title' => '头衔',
            'tags' => '标签',
            'abstract' => '简介',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if($insert) $this->created_at = time();
        $this->updated_at = time();

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * @return array
     */
    static function getMap(){
        $all = self::find()->all();
        $map = ArrayHelper::map($all,'id','name');
        return $map;
    }
}
