<?php
use yii\helpers\Url;
?>

<style>
    .el-upload__input{
        display: none !important;
    }
</style>

<?php $template = function(){ ?>
    <span>
        <a v-if="fileUrl" :href="fileUrl" target="_black"><i class="el-icon-document">{{fileUrl}}</i></a>
        <el-upload
            :action="uploadUrl"
            :on-success="upload">
            <el-button size="small" type="success" v-if="value">重新上传</el-button>
            <el-button size="small" type="primary" v-else>点击上传</el-button>
        </el-upload>
    </span>
<?php  }?>

<script>
    Vue.component('upload-file', {
        template: `<?= $template(); ?>`,
        model: { prop: 'value', event: 'change'},
        props:{
            'value':{ type: String, default: ""}
        },
        data:function(){
            return {
                baseUrl:"<?=Url::to(["upload/get",'src'=>''],true)?>",
                uploadUrl:"<?=Url::to(["upload/file",'src'=>''],true)?>",
            }
        },
        computed: {
            fileUrl: function () {
                if(this.value)
                    return this.baseUrl + "/" + this.value;
                else
                    return null;
            }
        },
        methods: {
            upload:function(res, file) {
                if(res.state.code == 0 && res.data){
                    //设置属性
                    //this.value = res.data;
                    this.$emit('change', res.data);
                }
            },
        }
    });
</script>


