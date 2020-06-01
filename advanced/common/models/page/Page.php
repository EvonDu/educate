<?php

namespace common\models\page;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property string $name
 * @property string $title
 * @property string $content
 * @property string $content_en
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['content', 'content_en'], 'string'],
            [['name', 'title'], 'string', 'max' => 50],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'title' => 'Title',
            'content' => '中文',
            'content_en' => '英语',
        ];
    }

    /**
     * 获取页面模型
     * @param $name
     * @return Page|null|static
     */
    static public function getPage($name){
        $model = self::findOne($name);
        if(empty($model)){
            $map = self::getTitleMap();
            $model = new self();
            $model->name = $name;
            $model->title = isset($map[$name]) ? $map[$name] : $name;
        }
        return $model;
    }

    /**
     * 默认标题映射
     * @return array
     */
    static public function getTitleMap(){
        return [
            "AboutUs"           => "关于我们",
            "CompanyProfile"    => "公司介绍",
            "PaymentAgreement"  => "支付协议",
            "UserAgreement"     => "用户协议",
            "Tutorial"          => "学习教程",
            "Methods"           => "学习模式",
            "TermsOfUse"        => "使用条款",
            "Privacy"           => "私隐",
            "Support"           => "服务支持",
            "CopyrightPolicy"   => "版权政策",
        ];
    }
}
