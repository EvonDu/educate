$(function() {
    //遍历相关插件
    $("*[role='video-input']").each(function(){
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
        var base_url = $(source).attr("data-base-url") || "";

        //plugin
        var plugin = document.createElement('div');
        $(plugin).addClass("video-input");
        $(source).after(plugin);

        //source
        $(source).attr("type","hidden");
        $(plugin).append(source);

        //loading
        var loading = '' +
            '<div class="video-input-loading">' +
            '<div class="video-input-loading-shade"></div>' +
            '<div class="video-input-loading-content">' +
            '<div class="video-input-loading-icon"></div>' +
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

        //video
        var video = document.createElement('video');
        var video_source = document.createElement('source');
        $(video).attr("controls","controls");
        //$(video).attr("autoplay","autoplay");
        $(video).css("max-width",width+"px");
        $(video).css("max-height",height+"px");
        //$(video_source).attr("src","");
        $(video).append(video_source);
        $(plugin).append(video);

        //btn
        var btn = document.createElement('button');
        $(btn).addClass("btn btn-info");
        $(btn).append(loading);
        $(btn).append("上传视频");
        $(btn).append(input);

        //action
        var action = document.createElement('div');
        $(action).addClass("video-input-actions");
        $(action).append(btn);
        $(plugin).append(action);

        //载入值
        if(value){
            var src = base_url?base_url+"/"+value:value;
            $(video_source).attr("src",src);
            $(video).attr("data-show","true");
            $(video).load();
        }
    }

    //上传图片,上传后添加到content
    function upload(e){
        //获取input的id
        var input = e.target;
        var plugin = $(input).closest(".video-input");

        //获取上传地址
        var upload_url = $(input).attr("data-upload-url") || "";
        var base_url = $(input).attr("data-base-url") || "";

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
                    set(plugin,base_url,data.data);//设置图片
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
            },
        });

        //重新寻找，绑定事件
        $("#"+id).each(function(){
            $(this).on("change",upload);
            $(this).val(null);
        });
    }

    //设置图片
    function set(plugin,base_url,path){
        //获取src
        var src = base_url?base_url+"/"+path:path;

        //获取元素
        var video = $(plugin).find("video");
        var source = $(video).find("source");
        var hidden = $(plugin).find("input[type='hidden']");

        //设置值
        $(source).attr("src",src);
        $(video).attr("data-show","true");
        $(video).load();
        $(hidden).val(path);
    }

    //显示加载中
    function loading_show(plugin){
        var loading = $(plugin).find(".video-input-loading");
        //显示加载中框
        $(loading).css("visibility","visible");
    }

    //隐藏加载中
    function loading_hide(plugin){
        var loading = $(plugin).find(".video-input-loading");
        //隐藏加载中框
        $(loading).css("visibility","hidden");
    }
})