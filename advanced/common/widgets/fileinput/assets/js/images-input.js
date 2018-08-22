$(function() {
    //遍历相关插件
    $("*[role='images-input']").each(function(){
        init(this);
    });

    //初始化插件
    function init(source){
        //容器
        var parent = source.parentNode;

        //获取值
        var base_url = $(source).attr("data-base-url") || "";
        var item_width = $(source).attr("data-item-width") || 96;
        var item_height = $(source).attr("data-item-height") || 96;
        var value = $(source).val() || "[]";

        //plugin
        var plugin = document.createElement('div');
        $(plugin).addClass("images-input");
        $(source).after(plugin);

        //source
        $(source).attr("type","hidden");
        $(plugin).append(source);

        //loading
        var loading = '' +
            '<div class="images-input-loading">' +
            '<div class="images-input-loading-shade"></div>' +
            '<div class="images-input-loading-content">' +
            '<div class="images-input-loading-icon"></div>' +
            '</div>' +
            '</div>';

        //items
        var items = document.createElement('div');
        $(items).addClass("images-input-items");

        //content
        var content = document.createElement('div');
        $(content).addClass("images-input-content");
        $(content).append(loading);
        $(content).append(items);
        $(plugin).append(content);

        //items
        var items = document.createElement('div');
        $(items).addClass("images-input-items");

        //input
        var input = $(source).clone();
        $(input).attr("id",$(source).attr("id")+"-upload");
        $(input).attr("role","");
        $(input).attr("name","upload");
        $(input).attr("type","file");
        $(input).attr("value",null);
        $(input).attr("accept","image/*");
        $(input).on("change",upload);

        //btn
        var btn = document.createElement('a');
        $(btn).attr("type","button");
        $(btn).attr("class","images-input-btn btn btn-info");
        $(btn).append('<span>上传图片</span>');
        $(btn).append(input);
        $(plugin).append(btn);

        //加载值
        try{ value = JSON.parse(value); } catch (e){ value = [] }
        for(var key in value){
            var item = value[key];
            load(plugin,base_url,item_width,item_height,item);
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
        var plugin = $(input).closest(".images-input");

        //获取上传地址
        var base_url = $(input).attr("data-base-url") || "";
        var upload_url = $(input).attr("data-upload-url") || "";
        var item_width = $(input).attr("data-item-width") || 96;
        var item_height = $(input).attr("data-item-height") || 96;

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
                    add(plugin,base_url,item_width,item_height,data.data);//设置图片
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

    //base64上传
    function upload_base64(input){
        //获取元素
        var plugin = $(input).closest(".images-input");

        //获取上传地址
        var base_url = $(input).attr("data-base-url") || "";
        var upload_url = $(input).attr("data-upload-url") || "";
        var item_width = $(input).attr("data-item-width") || 96;
        var item_height = $(input).attr("data-item-height") || 96;

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
                        add(plugin,base_url,item_width,item_height,data.data);//设置图片
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

    //加载图片到content
    function load(plugin,base_url,item_width,item_height,path){
        //获取src
        var src = base_url?base_url+"/"+path:path;

        //容器
        var items = $(plugin).find(".images-input-items");

        //close
        var close = document.createElement('span');
        $(close).attr("class","images-input-item-shade-btn glyphicon glyphicon-remove");
        $(close).attr("aria-hidden","true");
        $(close).on("click",remove);

        //shade-content
        var content = document.createElement('div');
        $(content).attr("class","images-input-item-shade-content");
        $(content).append(close);

        //shade
        var shade = document.createElement('div');
        $(shade).attr("class","images-input-item-shade");
        $(shade).append('<div class="images-input-item-shade-background"></div>');
        $(shade).append(content);

        //img
        var img = document.createElement('img');
        $(img).attr("src",src);
        $(img).css("width",item_width+"px");
        $(img).css("height",item_height+"px");

        //item
        var item = document.createElement('div');
        $(item).attr("class","images-input-item");
        $(item).append(img);
        $(item).append(shade);
        $(items).append(item);
    }

    //添加图片到content
    function add(plugin,base_url,item_width,item_height,path){
        //加载item
        load(plugin,base_url,item_width,item_height,path);

        //获取input取值
        var hidden = $(plugin).find("input[type='hidden']");
        var values = null;
        try{ values = JSON.parse(hidden.val()); } catch (e){ values = [] }

        //添加值并JSON化回input
        values.push(path);
        hidden.val(JSON.stringify(values));
    }

    //移除图片
    function remove(e){
        //获取元素
        var _this = e.target;

        //获取结点和input元素
        var item = $(_this).closest(".images-input-item");
        var plugin = $(_this).closest(".images-input");
        var hidden = $(plugin).find("input[type='hidden']");
        var base_url = $(hidden).attr("data-base-url") || "";

        //获取移除结点值
        var path = $(item).find("img").attr("src");
        if(base_url)
            path = path.replace(base_url+"/", '');         //删除BaseUrl

        //移除结点
        $(item).remove();

        //获取input取值
        var values = null;
        try{ values = JSON.parse(hidden.val()); } catch (e){ values = [] }

        //移除值并JSON化回input
        var index = values.indexOf(path);
        if (index > -1) values.splice(index, 1);
        hidden.val(JSON.stringify(values));
    }

    //显示加载中
    function loading_show(plugin){
        var loading = $(plugin).find(".images-input-loading");
        //显示加载中框
        $(loading).css("visibility","visible");
    }

    //隐藏加载中
    function loading_hide(plugin){
        var loading = $(plugin).find(".images-input-loading");
        //隐藏加载中框
        $(loading).css("visibility","hidden");
    }
})