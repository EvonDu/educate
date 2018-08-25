<?php
use yii\helpers\Url;
?>

<style>
    .el-tag{
        margin-right: 10px;
    }
    .button-new-tag {
        margin-right: 10px;
        height: 32px;
        line-height: 30px;
        padding-top: 0;
        padding-bottom: 0;
    }
    .input-new-tag {
        width: 90px;
        margin-left: 10px;
        vertical-align: bottom;
    }
</style>

<?php $template = function(){ ?>
    <span>
        <el-tag
            :key="tag"
            v-for="tag in dynamicTags"
            closable
            :disable-transitions="false"
            @close="handleClose(tag)">
            {{tag}}
        </el-tag>
        <el-input
            class="input-new-tag"
            v-if="inputVisible"
            v-model="inputValue"
            ref="saveTagInput"
            size="small"
            @keyup.enter.native="handleInputConfirm"
            @blur="handleInputConfirm">
        </el-input>
        <el-button v-else class="button-new-tag" size="small" @click="showInput">+ New Tag</el-button>
    </span>
<?php  }?>

<script>
    Vue.component('tags', {
        template: `<?= $template(); ?>`,
        model: { prop: 'value', event: 'change'},
        props:{
            'value':{ type: String, default: ""}
        },
        data:function(){
            return {
                dynamicTags: [],
                inputVisible: false,
                inputValue: '',
            }
        },
        created:function(){
            this.dynamicTags = this.value ? this.value.split(",") : [];
        },
        methods: {
            handleClose:function(tag) {
                //删除元素
                this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
                //触发更改
                this.$emit('change', this.dynamicTags.join(","));
            },
            showInput:function() {
                this.inputVisible = true;
                var _this  = this;
                this.$nextTick(function(){
                    return _this.$refs.saveTagInput.$refs.input.focus();
                });
            },
            handleInputConfirm:function() {
                //添加元素
                var inputValue = this.inputValue;
                if (inputValue) {
                    this.dynamicTags.push(inputValue);
                }
                this.inputVisible = false;
                this.inputValue = '';
                //触发更改
                this.$emit('change', this.dynamicTags.join(","));
            },
        }
    });
</script>


