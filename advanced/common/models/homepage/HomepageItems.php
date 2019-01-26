<?php

namespace common\models\homepage;

use Yii;

/**
 * This is the model class for table "homepage_items".
 *
 * @property int $id
 * @property int $order
 * @property string $image
 * @property string $content
 * @property string $content_en
 */
class HomepageItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'homepage_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order'], 'integer'],
            [['content', 'content_en'], 'string'],
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
            'order' => '排序',
            'image' => '图片',
            'content' => '内容',
            'content_en' => '内容(英)',
        ];
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    static public function getAll(){
        return self::find()->orderBy("order")->all();
    }
}
