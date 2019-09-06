<?php

namespace common\models\setting;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property string $key
 * @property string $value
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['value'], 'string'],
            [['key'], 'string', 'max' => 128],
            [['key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => 'Key',
            'value' => 'Value',
        ];
    }

    /**
     * @param $key
     * @param null $default
     * @return null|string
     */
    static public function getItem($key, $default=null){
        $model = self::findOne($key);
        if($model)
            return $model->value;
        else
            return $default;
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    static public function setItem($key,$value){
        $model = self::findOne($key);
        if(!$model){
            $model = new self();
            $model->key = $key;
        }
        $model->value = $value;

        if($model->save())
            return true;
        else
            return false;
    }
}
