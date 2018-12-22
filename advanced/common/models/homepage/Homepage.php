<?php

namespace common\models\homepage;

use Yii;

/**
 * This is the model class for table "homepage".
 *
 * @property int $id
 * @property string $title
 * @property string $abstract
 * @property string $image
 * @property string $content
 */
class Homepage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'homepage';
    }

    public function fields()
    {
        $parent = parent::fields();
        unset($parent["id"]);
        return $parent;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['abstract', 'content'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'abstract' => '简介',
            'image' => '背景',
            'content' => '内容',
        ];
    }

    /**
     * 获取Homepage模型
     * @return array|Homepage|null|\yii\db\ActiveRecord
     */
    static public function getModel(){
        $model = self::find()->one();
        $model = $model ?: new self();
        return $model;
    }
}
