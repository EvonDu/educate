<?php
$upload_url = \yii\helpers\Url::to(["/upload"],true);
?>
<component-template>
    <div>
        <el-table :data="value" style="width: 100%">
            <el-table-column prop="time[0]" label="开始时间"></el-table-column>
            <el-table-column prop="time[1]" label="结束时间"></el-table-column>
            <el-table-column prop="content" label="内容"></el-table-column>
            <el-table-column fixed="right" label="操作" width="100">
                <template slot-scope="scope">
                    <el-button type="text" size="small" @click="update(scope.row)">修改</el-button>
                    <el-button type="text" size="small" @click="remove(scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-button type="primary" @click="add" style="margin-top: 12px">添加字幕</el-button>
        <el-dialog title="添加字幕" width="30%" :visible.sync="dialogVisible">
            <el-form ref="form" label-width="80px" v-if="item">
                <el-form-item label="时间">
                    <el-time-picker is-range v-model="item.time" range-separator="-" start-placeholder="开始时间" end-placeholder="结束时间" placeholder="选择时间范围" value-format="HH:mm:ss"></el-time-picker>
                </el-form-item>
                <el-form-item label="内容">
                    <el-input v-model="item.content"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="submit">确定</el-button>
                <el-button @click="centerDialogVisible = false">取消</el-button>
            </span>
        </el-dialog>
    </div>
</component-template>

<script>
    Vue.component('input-subtitles', {
        template: '{{component-template}}',
        model: {
            prop: 'value', event: 'change'
        },
        data:function(){
            return {
                dialogVisible : false,
                defaultValue:{"time":["00:00:00","00:00:10"], "content":""},
                item : null,
                isNew : false,
            };
        },
        created:function () {
            if(this.value === null){
                this.$emit('change', []);
            }
        },
        props:{
            'value':{ type: Array, "default": function(){ return [] }},
        },
        methods: {
            add:function(){
                //初始化值
                this.isNew = true;
                this.item = JSON.parse(JSON.stringify(this.defaultValue));
                //显示窗口
                this.dialogVisible = true;
            },
            update(item){
                //初始化值
                this.isNew = false;
                this.item = item;
                //显示窗口
                this.dialogVisible = true;
            },
            remove(item){
                //询问操作
                var self = this;
                this.$confirm('此操作将移除此字幕, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(function(){
                    //获取数组索引
                    let index = null;
                    for (let i = 0; i < self.value.length; i++){
                        if(self.value[i] === item){
                            index = i;
                            break;
                        }
                    }
                    //移除数组项
                    self.value.splice(index,1);
                });
            },
            submit:function(){
                //判断输入
                if(this.item.name === "")
                    return;
                //关闭窗口
                this.dialogVisible = false;
                //设置新值
                if(this.isNew){
                    if(typeof this.value !== "object") return;
                    this.value.push(this.item);
                }
            }
        }
    });
</script>