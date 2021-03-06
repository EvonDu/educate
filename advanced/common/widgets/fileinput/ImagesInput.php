<?php
namespace common\widgets\fileinput;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class ImagesInput extends Widget
{
    //参数
    public $model;                      //绑定模型
    public $attribute;                  //绑定字段名
    public $uploadPath = '';            //上传地址
    public $label = "";                 //绑定字段的label
    public $uploadType = 'normal';      //上传方式 normal/base64
    public $itemWidth = 96;             //宽度
    public $itemHeight = 96;            //高度
    public $basePath = "";              //基础路径
    public $template = '{input}';
    //变量
    private $id;
    private $name;
    private $value;

    public function init()
    {
        //调用父类初始化方法
        parent::init();

        //加载资源
        PluginAsset::register($this->view);

        //设置input
        $this->name = Html::getInputName($this->model, $this->attribute);
        $this->id = Html::getInputId($this->model, $this->attribute);
        $this->value = Html::getAttributeValue($this->model,$this->attribute);

        //设置label
        if($this->model && empty($this->label)){
            $this->label = $this->model->getAttributeLabel($this->attribute);
        }
    }

    public function run()
    {
        //获取内容
        $input = $this->renderInput();

        //替换模板内容
        $target = str_replace("{input}",$input,$this->template);

        //输出
        echo $target;
    }

    protected function renderInput(){
        $options = [
            'id'=>$this->id,
            'role'=>'images-input',
            'data-item-width'=>$this->itemWidth,
            'data-item-height'=>$this->itemHeight,
            'data-base-url'=>empty($this->basePath)?\yii\helpers\Url::to('@web',true):$this->basePath,
            'data-upload-url'=>$this->uploadPath,
            'data-upload-type'=>$this->uploadType
        ];

        $input = Html::input("hidden",$this->name,$this->value,$options);

        return $input;
    }
}
?>