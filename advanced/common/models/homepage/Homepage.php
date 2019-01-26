<?php

namespace common\models\homepage;

use Yii;

/**
 * This is the model class for table "homepage".
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property string $abstract
 * @property string $abstract_en
 * @property string $image
 * @property string $content
 * @property string $content_en
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

    /**
     * @return array
     */
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
            [['abstract' ,'abstract_en' ,'content' ,'content_en'], 'string'],
            [['title', 'title_en'], 'string', 'max' => 50],
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
            'title_en' => '标题(英)',
            'abstract' => '简介',
            'abstract_en' => '简介(英)',
            'image' => '背景',
            'content' => '内容',
            'content_en' => '内容(英)',
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
