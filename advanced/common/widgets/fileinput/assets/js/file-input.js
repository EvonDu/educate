$(function() {
    //遍历相关插件
    $("*[role='file-input']").each(function(){
        init(this);
    });

    //初始化插件
    function init(source){
        //容器
        var parent = source.parentNode;

        //获取参数
        var value = $(source).val() || "";
        var width = $(source).attr("data-width") || "";
        var height = $(source).attr("data-height") || "";

        //plugin
        var plugin = document.createElement('div');
        $(plugin).addClass("file-input");
        $(source).after(plugin);

        //source
        $(source).attr("type","hidden");
        $(plugin).append(source);

        //loading
        var loading = '' +
            '<div class="file-input-loading">' +
            '<div class="file-input-loading-shade"></div>' +
            '<div class="file-input-loading-content">' +
            '<div class="file-input-loading-icon"></div>' +
            '</div>' +
            '</div>';

        //input
        var input = $(source).clone();
        $(input).attr("id",$(source).attr("id")+"-upload");
        $(input).attr("role","");
        $(input).attr("name","upload");
        $(input).attr("type","file");
        $(input).attr("value",null);
        $(input).on("change",upload);

        //content
        var content = document.createElement('div');
        $(content).addClass("file-input-content");
        $(content).css("width",width+"px");
        $(content).css("height",height+"px");
        $(content).append(loading);
        $(content).append(input);
        $(plugin).append(content);

        //设置初始值
        if(value){
            $(content).attr("icon","file");
        }
    }

    //上传图片,上传后添加到content
    function upload(e){
        //获取input的id
        var input = e.target;
        var plugin = $(input).closest(".file-input");

        //获取上传地址
        var upload_url = $(input).attr("data-upload-url") || "";

        //获取id
        var id = $(input).attr("id");

        //上传文件
        loading_show(plugin);
        $.ajaxFileUpload({
            url: upload_url,                                //处理图片的脚本路径
            type: 'post',                                   //提交的方式
            secureuri: false,                              //是否启用安全提交
            fileElementId: id,                              //file控件ID
            dataType: 'json',                               //服务器返回的数据类型
            success: function (data) {
                //判断返回，设置图片
                if(data.state.code == 0 && data.data)
                    set(plugin,data.data);//设置图片
                else
                    alert("图片上传失败!");
                //隐藏加载中
                loading_hide(plugin);
            },
            error: function (data) {
                console.log(data);
                alert("图片上传失败!");
                //隐藏加载中
                loading_hide(plugin);
            }
        });

        //重新寻找，绑定事件
        $("#"+id).each(function(){
            console.log(this);
            $(this).on("change",upload);
            $(this).val(null);
        });
    }

    //设置图片
    function set(plugin,path){
        //获取元素
        var content = $(plugin).find(".file-input-content");
        var hidden = $(plugin).find("input[type='hidden']");

        //设置值
        $(content).attr("icon","file");
        $(hidden).val(path);
    }

    //显示加载中
    function loading_show(plugin){
        var loading = $(plugin).find(".file-input-loading");
        //显示加载中框
        $(loading).css("visibility","visible");
    }

    //隐藏加载中
    function loading_hide(plugin){
        var loading = $(plugin).find(".file-input-loading");
        //隐藏加载中框
        $(loading).css("visibility","hidden");
    }
})