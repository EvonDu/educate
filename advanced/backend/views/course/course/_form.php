<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

vuelte\assets\PluginComponentsAsset::register($this);
print $this->render('@app/views/components/avatar');
/* @var $this yii\web\View */
/* @var $model common\models\course\Course */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $template = function($model){ ?>
<div class="course-form">

    <?php ActiveElementForm::begin(["options"=>[
        "label-width" => "120px",
        "status-icon" => true,
        ":rules" => "formRule"
    ]]); ?>

    <el-form-item prop="num"
                  label="<?= ActiveElementForm::getFieldLabel($model,"num")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"num")?>">
        <el-input v-model="data.num"></el-input>
    </el-form-item>

    <el-form-item prop="price"
                  label="<?= ActiveElementForm::getFieldLabel($model,"price")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"price")?>">
        <el-input v-model.number="price"></el-input>
    </el-form-item>

    <el-form-item prop="name"
                  label="<?= ActiveElementForm::getFieldLabel($model,"name")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"name")?>">
        <el-input v-model="data.name"></el-input>
    </el-form-item>

    <el-form-item prop="instructor"
                  label="<?= ActiveElementForm::getFieldLabel($model,"instructor")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"instructor")?>">
        <el-select v-model="data.instructor" placeholder="请选择">
            <el-option
                    v-for="(item,index) in instructorMap"
                    :key="index"
                    :label="item"
                    :value="parseInt(index)">
            </el-option>
        </el-select>
    </el-form-item> 

    <el-form-item prop="type"
                  label="<?= ActiveElementForm::getFieldLabel($model,"type")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"type")?>">
        <el-select v-model="data.type" placeholder="请选择">
            <el-option
                    v-for="(item,index) in typeMap"
                    :key="index"
                    :label="item"
                    :value="parseInt(index)">
            </el-option>
        </el-select>
    </el-form-item>

    <el-form-item prop="image"
                  label="<?= ActiveElementForm::getFieldLabel($model,"image")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"image")?>">
        <avatar v-model="data.image"></avatar>
    </el-form-item>

    <el-form-item prop="level"
                  label="<?= ActiveElementForm::getFieldLabel($model,"level")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"level")?>">
        <el-select v-model="data.level" placeholder="请选择">
            <el-option
                    v-for="index in 5"
                    :key="index"
                    :label="index"
                    :value="parseInt(index)">
            </el-option>
        </el-select>
    </el-form-item> 

    <el-form-item prop="abstract"
                  label="<?= ActiveElementForm::getFieldLabel($model,"abstract")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"abstract")?>">
        <summernote v-model="data.abstract"></summernote>
    </el-form-item> 

    <el-form-item prop="content"
                  label="<?= ActiveElementForm::getFieldLabel($model,"content")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"content")?>">
        <summernote v-model="data.content"></summernote>
    </el-form-item> 

    <el-form-item prop="requirements_prerequisites"
                  label="<?= ActiveElementForm::getFieldLabel($model,"requirements_prerequisites")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"requirements_prerequisites")?>">
        <summernote v-model="data.requirements_prerequisites"></summernote>
    </el-form-item> 

    <el-form-item prop="requirements_textbooks"
                  label="<?= ActiveElementForm::getFieldLabel($model,"requirements_textbooks")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"requirements_textbooks")?>">
        <summernote v-model="data.requirements_textbooks"></summernote>
    </el-form-item> 

    <el-form-item prop="requirements_software"
                  label="<?= ActiveElementForm::getFieldLabel($model,"requirements_software")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"requirements_software")?>">
        <summernote v-model="data.requirements_software"></summernote>
    </el-form-item> 

    <el-form-item prop="requirements_hardware"
                  label="<?= ActiveElementForm::getFieldLabel($model,"requirements_hardware")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"requirements_hardware")?>">
        <summernote v-model="data.requirements_hardware"></summernote>
    </el-form-item> 

    <el-form-item prop="next_term_at"
                  label="<?= ActiveElementForm::getFieldLabel($model,"next_term_at")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"next_term_at")?>">
        <el-date-picker
                v-model="nextTerm"
                type="date"
                placeholder="选择日期">
        </el-date-picker>
    </el-form-item>

    <el-form-item>
        <lte-btn type="info" @click="submit"><i class='glyphicon glyphicon-floppy-disk'></i> 保存</lte-btn>
    </el-form-item>

    <?php ActiveElementForm::end(); ?>

</div>
<?php  }?>

<script>
    Vue.component('model-form', {
        template: `<?= $template($model); ?>`,
        props:{
            data:{ type: Object, default: function(){ return {}; }},
        },
        data:function(){
            //认证规则
            var _this = this;
            var checkPrice = function(rule,value,callback){
                console.log(_this.price);
                var regPos = /^\d+(\.\d+)?$/; //非负浮点数
                if(!regPos.test(_this.price)){
                    callback(new Error("价格不合法"));
                }
            };

            return {
                nextTerm:null,
                instructorMap:<?= json_encode(\common\models\instructor\Instructor::getMap())?>,
                typeMap:<?= json_encode(\common\models\course\CourseType::getMap())?>,
                price:0,
                formRule:{
                    price: [
                        { validator: checkPrice, trigger: 'blur' }
                    ]
                },

            }
        },
        created:function(){
            if(this.data.next_term_at)
                this.nextTerm = new Date(this.data.next_term_at * 1000);
            if(this.data.price)
                this.price = this.data.price/100;
        },
        methods: {
            submit: function (event) {
                if(this.nextTerm)
                    this.data.next_term_at = Date.parse(this.nextTerm)/1000;
                if(this.data.price)
                    this.data.price = this.price * 100;

                YiiFormSubmit(this.data, "Course");
            }
        }
    });
</script>


