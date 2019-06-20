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
        width: 320px;
        height: 180px;
        line-height: 180px;
        text-align: center;
    }
    .avatar {
        width: 320px;
        height: 180px;
        display: block;
    }
    /*update*/
    .el-upload__input{
        display: none !important;
    }
</style>

<component-template>
    <el-upload
        class="avatar-uploader"
        :action="uploadUrl"
        :on-success="upload">
        <img v-if="imageUrl" :src="imageUrl" class="avatar">
        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
    </el-upload>
</component-template>

<script>
    Vue.component('upload-img', {
        template: '{{component-template}}',
        model: { prop: 'value', event: 'change'},
        props:{
            'value':{ type: String, default: ""}
        },
        data:function(){
            return {
                uploadUrl:"<?=Url::to(["upload/file"],true)?>",
            }
        },
        computed: {
            imageUrl: function () {
                //return this.value ? this.value : null;
                return this.value ? "<?=Url::to(["upload/get",'src'=>''],true)?>" + "/" + this.value : null;
            }
        },
        methods: {
            upload:function(res, file) {
                if(res.state.code == 0 && res.data){
                    this.value = res.data;
                    this.$emit('change', this.value);
                }
            },
        }
    });
</script>