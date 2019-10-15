<?php
vuelte\lib\Import::component($this, '@app/views/components/input-price');
?>
<component-template>
    <div>
        <el-table :data="value" style="width: 100%">
            <el-table-column prop="course_id" label="课程ID"></el-table-column>
            <el-table-column prop="course_name" label="课程名"></el-table-column>
            <el-table-column prop="price_original" label="课程原价">
                <template slot-scope="scope">
                    {{scope.row.price_original/100}}
                </template>
            </el-table-column>
            <el-table-column prop="price" label="活动价格">
                <template slot-scope="scope">
                    {{scope.row.price_preferential/100}}
                </template>
            </el-table-column>
            <el-table-column fixed="right" label="操作" width="100">
                <template slot-scope="scope">
                    <el-button type="text" size="small" @click="update(scope.row)">修改</el-button>
                    <el-button type="text" size="small" @click="remove(scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-button type="primary" @click="add" style="margin-top: 12px">添加课程</el-button>
        <el-dialog title="添加优惠课程" width="30%" :visible.sync="dialogVisible">
            <el-form ref="form" label-width="80px" v-if="item">
                <el-form-item label="课程">
                    <el-select v-model="item.course_id" @change="selectd">
                        <el-option v-for="item in courses" :key="item.id" :label="item.name" :value="item.id"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="课程原价">
                    <input-price v-model="item.price_original" disabled></input-price>
                </el-form-item>
                <el-form-item label="活动价格">
                    <input-price v-model="item.price_preferential"></input-price>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="submit">确定</el-button>
                <el-button @click="dialogVisible = false">取消</el-button>
            </span>
        </el-dialog>
    </div>
</component-template>

<script>
    Vue.component('input-preferential-items', {
        template: '{{component-template}}',
        model: {
            prop: 'value', event: 'change'
        },
        data:function(){
            return {
                dialogVisible : false,
                defaultValue:{"course_id":null,"course_name":null,"price_original":null,"price_preferential":null},
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
            'courses':{ type: Array, "default": function(){ return [] }},
        },
        methods: {
            selectd:function (value) {
                for(var i in courses){
                    var course = courses[i];
                    if(value === course.id){
                        this.item.course_name = course.name;
                        this.item.price_original = course.price;
                        return;
                    }
                }
            },
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
                this.$confirm('此操作将移除此优惠, 是否继续?', '提示', {
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
                if(!this.item.course_id || !this.item.price_preferential)
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