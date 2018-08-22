$(function() {
    //遍历相关插件
    $("*[role='image-input']").each(function(){
        init(this);
    });

    //初始化插件
    function init(source){
        //容器
        var parent = source.parentNode;

        //获取值
        var width = $(source).attr("data-width") || "";
        var height = $(source).attr("data-height") || "";
        var base_url = $(source).attr("data-base-url") || "";
        var value = $(source).val() || "";

        //plugin
        var plugin = document.createElement('div');
        $(plugin).addClass("image-input");
        $(source).after(plugin);

        //source
        $(source).attr("type","hidden");
        $(plugin).append(source);

        //loading
        var loading = '' +
            '<div class="image-input-loading">' +
            '<div class="image-input-loading-shade"></div>' +
            '<div class="image-input-loading-content">' +
            '<div class="image-input-loading-icon"></div>' +
            '</div>' +
            '</div>';

        //image
        var image = document.createElement('img');

        //input
        var input = $(source).clone();
        $(input).attr("id",$(source).attr("id")+"-upload");
        $(input).attr("role","");
        $(input).attr("name","upload");
        $(input).attr("type","file");
        $(input).attr("value",null);
        $(input).attr("accept","image/*");
        $(input).on("change",upload);

        //content
        var content = document.createElement('div');
        $(content).addClass("image-input-content");
        $(content).css("width",width+"px");
        $(content).css("height",height+"px");
        $(content).append(loading);
        $(content).append(input);
        $(content).append(image);
        $(plugin).append(content);

        //加载值
        if(value){
            var img_src =  (base_url?base_url+"/":"")+value;
            $(image).attr("src",img_src);
        }
    }

    //上传图片,上传后添加到content
    function upload(e){
        //获取input的id
        var input = e.target;
        var upload_type = $(input).attr("data-upload-type") || "";

        //按照Type选择上传方式
        if(upload_type == "base64")
            upload_base64(input);
        else
            upload_normal(input);
    }

    //ajax上传
    function upload_normal(input){
        //获取元素
        var plugin = $(input).closest(".image-input");

        //获取上传地址
        var base_url = $(input).attr("data-base-url") || "";
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
                    set(plugin,base_url,data.data);//设置图片
                else
                    alert("图片上传失败!");
                //隐藏加载中
                loading_hide(plugin);
            },
            error: function (data) {
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

    //base64上传
    function upload_base64(input){
        //获取元素
        var plugin = $(input).closest(".image-input");

        //获取上传地址
        var base_url = $(input).attr("data-base-url") || "";
        var upload_url = $(input).attr("data-upload-url") || "";

        //获取Base64后上传
        var file = input.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(file); // 读出 base64
        reader.onloadend = function () {
            //获取Base64
            var dataURL = reader.result;
            //开始上传
            loading_show(plugin);
            //上传Base64
            $.ajax({
                url: upload_url,
                type: 'post',
                data:{"base64":dataURL},
                dataType: 'json',
                success: function (data) {
                    //判断返回，设置图片
                    if(data.state.code == 0 && data.data)
                        set(plugin,base_url,data.data);//设置图片
                    else
                        alert("图片上传失败!");
                    //隐藏加载中
                    loading_hide(plugin);
                },
                error: function (data) {   //提交失败自动执行的处理函数
                    console.log(data);
                    alert("图片上传失败!");
                    //隐藏加载中
                    loading_hide(plugin);
                }
            })
        };
    }

    //设置图片
    function set(plugin,base_url,path){
        //获取src
        var src = base_url?base_url+"/"+path:path;

        //获取元素
        var img = $(plugin).find("img");
        var hidden = $(plugin).find("input[type='hidden']");

        //设置值
        $(img).attr("src",src);
        $(hidden).val(path);
    }

    //显示加载中
    function loading_show(plugin){
        var loading = $(plugin).find(".image-input-loading");
        //显示加载中框
        $(loading).css("visibility","visible");
    }

    //隐藏加载中
    function loading_hide(plugin){
        var loading = $(plugin).find(".image-input-loading");
        //隐藏加载中框
        $(loading).css("visibility","hidden");
    }
})