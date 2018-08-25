<?php
    use yii\helpers\Url;
?>

<style>
    /*avatar*/
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 78px;
        height: 78px;
        line-height: 78px;
        text-align: center;
    }
    .avatar {
        width: 78px;
        height: 78px;
        display: block;
    }
    /*update*/
    .el-upload__input{
        display: none !important;
    }
</style>

<?php $template = function(){ ?>
    <el-upload
        class="avatar-uploader"
        :action="uploadUrl"
        :on-success="upload">
        <img v-if="imageUrl" :src="imageUrl" class="avatar">
        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
    </el-upload>
<?php  }?>

<script>
    Vue.component('avatar', {
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
            imageUrl: function () {
                if(this.value)
                    return this.baseUrl + "/" + this.value;
                else
                    return null;
            }
        },
        methods: {
            //头像相关方法
            upload:function(res, file) {
                if(res.state.code == 0 && res.data){
                    this.value = res.data;
                    this.$emit('change', this.value);
                }
            },
        }
    });
</script>


