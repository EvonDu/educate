<?php
use yii\helpers\Url;
?>

<style>
    .el-upload__input{
        display: none !important;
    }
    .el-upload__tip{
        margin-top: 0;
    }
</style>

<component-template>
    <span>
        <video id="video" controls="controls" v-if="videoUrl" style="max-width: 100%;width: 500px;">
            <source :src="videoUrl"/>
            你的浏览器不支持H5播放器
        </video>
        <el-upload :action="uploadUrl" :show-file-list="false" accept="audio/mpeg,audio/mp4,video/mpeg,video/mp4"
                   :before-upload="upload_before" :on-success="upload_success" :on-error="upload_error">
            <el-button size="small" type="success" v-if="value">重新上传</el-button>
            <el-button size="small" type="primary" v-else>点击上传</el-button>
            <div slot="tip" class="el-upload__tip">只能上传mp3/mp4文件</div>
        </el-upload>
    </span>
</component-template>

<script>
    Vue.component('upload-video', {
        template: '{{component-template}}',
        model: { prop: 'value', event: 'change'},
        props:{
            'value':{ type: String, default: ""},
            'path':{ type: String, default: ""},
        },
        data:function(){
            return {
                //uploadUrl:"<?=Url::to(["upload/file"],true)?>",
                uploadUrl:"<?=Url::to(["upload/qiniu","path"=>""],true)?>" + this.path,
            }
        },
        computed: {
            videoUrl: function () {
                return this.value ? this.value : null;
            }
        },
        methods: {
            upload_success:function(res, file) {
                if(res.state.code == 0 && res.data){
                    //设置属性
                    this.$emit('change', res.data);
                    //重新加载
                    var video = document.getElementById("video");
                    if(video) video.load();
                    //关闭Loading
                    this.$loading().close();
                }
            },
            upload_before:function(){
                this.$loading({lock: true, text: 'Uploading……'});
            },
            upload_error:function(file){
                this.$loading().close();
            }
        }
    });
</script>


