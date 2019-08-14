<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>数据修改DEMO</title>
    <!-- vue -->
    <script type="text/javascript" src="assets/vue/vue.min.js"></script>
    <!-- axios -->
    <script type="text/javascript" src="assets/axios/axios.min.js"></script>
    <!-- element -->
    <link rel="stylesheet" href="assets/element/theme-chalk/index.css">
    <script type="text/javascript" src="assets/element/index.js"></script>
    <!-- components -->
    <script type="text/javascript" src="components/upload.js"></script>
</head>
<body>
    <div id="app">
        <h1>测试代码上传</h1>
        <el-form action="submit.php" enctype="multipart/form-data" method="post" label-width="230px">
            <el-form-item label="代码的ZIP压缩包">
                <input type="file" name="file"/>
                <div slot="tip">只能上传zip文件</div>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" native-type="submit">保存修改</el-button>
            </el-form-item>
        </el-form>
    </div>
</body>
</html>

<script>
    new Vue({
        el:"#app",
        data:{},
        created: function(){
            if(this.msg === "success"){
                this.$message({message: '修改成功', type: 'success'});
            }
            else if(this.msg === "errpsw") {
                this.$message.error({message: '密码错误'});
            }
        }
    });
</script>