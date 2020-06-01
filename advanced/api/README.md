# yii-admin2-api

#### 应用介绍
这是负责编写项目RESTful API应用，API文档工具目前支持swagger和apidoc。

#### Swagger
使用方法：
1. 添加swagger-php依赖：`composer require zircote/swagger-php`
2. 编写控制器中相关接口的swagger注释
3. 执行脚本`swagger-put.bat`生成swagger的json文件
4. 浏览器打开`/api/web/swagger`查看文档

注意：
- swagger-php是可以独立部署，其是作为一个独立的注释解析工具使用而不是项目中的一部分。
- 在本应用中默认使用的就是独立部署的形式，swagger脚本位置在`E:\swagger-php\bin\swagger`。
- 所以使用时需要把`swagger-put.bat`中swagger脚本的路径改成本地环境中的路径。
- 如果是使用上面composer的方式引入到项目中的话，其路径为`../vendor/zircote/swagger-php/bin/swagger`。

#### ApiDoc
使用方法：
1. 安装nodejs
2. 本机中全局安装apidoc：`npm install apidoc -g`
3. 配置`/apidoc.json`信息
4. 编写控制器中相关接口的apidoc注释
5. 执行脚本`apidoc-put.bat`生成文档
6. 浏览器中打开`/api/web/doc`查看文档

#### 项目架构
```
api
    config/                     API配置目录
    controllers/                入口控制器目录
    modules
        v1/                     API的v1版本目录(包含了独立的MVC目录)
    web
        swagger                 swagger-ui的API文档
        doc                     apidoc的API文档
    apidoc.json                 apidoc的基础配置文件
    apidoc-put.bat              生成apidoc文档脚本
    swagger-put.bat             生成swagger-ui中json文件的脚本
```

#### 参与贡献
1. Fork 本项目
2. 新建 Feat_xxx 分支
3. 提交代码
4. 新建 Pull Request