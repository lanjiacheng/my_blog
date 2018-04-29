//下面代码用于设置发表博文页面的按钮监听

/*
先定义需要添加按钮需要用到的组件
*/

//小标题输入组件
var subtitle =
    '\
<li class="list-group-item">\
    <div class="row" >\
        <div class="col-md-12 col-xs-12">\
            <h4>\
                <span class="label label-primary">小标题</span>\
            </h4>\
        </div>\
        <div class="col-md-12 col-xs-12">\
            <div style="float: right;">\
                <button class="delete btn btn-danger btn-xs" type="button">删除</button>\
            </div>\
        </div>\
        <div class="col-md-12 col-xs-12">\
            <input type="text" class="post_content form-control">\
        </div>\
    </div>\
</li>\
';

//段落输入组件
var paragraph =
    '\
<li class="list-group-item">\
    <div class="row">\
        <div class="col-md-12 col-xs-12">\
            <h4>\
                <span class="label label-info">段落</span>\
            </h4>\
        </div>\
        <div class="col-md-12 col-xs-12">\
            <div style="float: right;">\
                <button class="delete btn btn-danger btn-xs">删除</button>\
            </div>\
        </div>\
        <div class="col-md-12 col-xs-12">\
            <textarea class="post_content form-control" rows="5" style="width: 100%;"></textarea>\
        </div>\
    </div>\
</li>\
';

//图片组件
var image =
    '\
<li class="list-group-item">\
    <div class="row">\
        <div class="col-md-12 col-xs-12">\
            <h4>\
                <span class="label label-primary">图片</span>\
            </h4>\
        </div>\
        <div class="col-md-12 col-xs-12">\
            <div style="float: right;">\
                <button class="delete btn btn-danger btn-xs">删除</button>\
            </div>\
        </div>\
        <div class="col-md-12 col-xs-12">\
            <input type="file" class="choose_image"/>\
            <img class="post_content" src=""/>\
        </div>\
    </div>\
</li>\
';

//设置添加小标题按钮的监听
$("#add_subtitle").click(function () {
    $("#add_btn_bar").before(subtitle);
    set_delete();
});

//设置添加段落按钮的监听
$("#add_paragraph").click(function () {
    $("#add_btn_bar").before(paragraph);
    set_delete();
});

//设置添加图片按钮的监听
$("#add_image").click(function () {
    $("#add_btn_bar").before(image);
    set_delete();
    set_choose_image();
});

//一个方法，用于给删除按钮设置监听
function set_delete() {
    //设置删除按钮监听
    $(".delete").click(function () {
        $(this).parents("li").remove();
    });
}

//一个方法，用于给选择图片输入框设置监听
function set_choose_image() {
    //给选择图片按钮设置监听
    $(".choose_image").on("change", function () {
        var filePath = $(this).val();         //获取到input的value，里面是文件的路径
        fileFormat = filePath.substring(filePath.lastIndexOf(".")).toLowerCase();
        // 检查是否是图片
        if (!fileFormat.match(".png|.jpg|.jpeg")) {
            alert('上传错误,文件格式必须为：png/jpg/jpeg');
            $(this).val("");                //添加错误文件，将输入值置空
            $(this).next().attr("src", "");
            return;
        };
        var src = window.URL.createObjectURL(this.files[0]);        //转成可以在本地预览的格式
        $(this).next().attr("src", src);
    });
}

//给添加预览图片的输入框设置监听
$(".choose_image_preview").on("change", function () {
    var filePath = $(this).val();         //获取到input的value，里面是文件的路径
    fileFormat = filePath.substring(filePath.lastIndexOf(".")).toLowerCase();
    // 检查是否是图片
    if (!fileFormat.match(".png|.jpg|.jpeg")) {
        alert('上传错误,文件格式必须为：png/jpg/jpeg');
        $(this).val("");                //添加错误文件，将输入值置空
        $(this).next().attr("src", "");
        return;
    };
    var src = window.URL.createObjectURL(this.files[0]);        //转成可以在本地预览的格式
    $(this).next().attr("src", src);
});

//下面给发表按钮添加监听事件
$("#send").click(function () {
    //创建表单，用于保存需要上传的图片和文字
    var form_data = new FormData();
    //获取时间戳
    var timestamp = new Date().getTime();
    //定义图片顺序，接下来将按图片顺序给图片命名
    var image_order = 0;
    //定义一个变量，用以记录需要上传的博文内容
    var post_content = "";
    var post_contents_input = $(".post_content");
    post_contents_input.each(function () {
        if ($(this).is("input")) {            //如果是输入框
            if ($(this).attr("id") == "title") {        //如果是标题
                if ($(this).val() == "") {
                    alert("请输入标题！");
                    return;
                }
                form_data.append("title", $(this).val());        //那就直接添加到表单
            } else if ($(this).attr("id") == "author") {             //如果是作者
                if ($(this).val() == "") {
                    alert("请输入作者！");
                    return;
                }
                form_data.append("author", $(this).val());     //直接添加
            } else {                                              //否则是小标题
                post_content = post_content + "<h3>" + $(this).val() + "</h3>";         //添加到内容中
            }
        } else if ($(this).is("textarea")) {
            if ($(this).attr("id") == "text_preview") {                //如果是预览文字
                if ($(this).val() == "") {
                    alert("请输入预览文字！");
                    return;
                }
                form_data.append("text_preview", $(this).val());       //以text_preview为键放到表单中
            } else {
                post_content = post_content + "<p>" + $(this).val() + "</p>";       //是普通段落
            }
        } else if ($(this).is("img")) {
            if ($(this).attr("id") == "image_of_preview") {            //如果是预览图片
                var input = $($(this).prev());
                if ($(this).attr("src") == "") {
                    alert("请选择预览图片！");
                    return;
                }
                form_data.append("image_preview", input[0].files[0]);
            } else {                                                  //如果是预览图片
                var input = $($(this).prev());
                var file_format = input.val().substring(input.val().lastIndexOf(".")).toLowerCase();  //获取文件格式
                post_content = post_content + '<img src="/static/images/' + timestamp + '/' + image_order + file_format + '">';
                form_data.append(image_order, input[0].files[0]);      //往表单添加图片，以顺序为键，以图片为值
                image_order++;                                      //添加之后，自动递增
            }
        }
    });
    form_data.append("post_content", post_content);              //添加博文内容的数据
    form_data.append("timestamp", timestamp);                 //添加时间戳

    //添加分类
    var category = $("input[name='category']:checked").val();       //获取选中的分类的值
    if(category == undefined){
        alert("请选择分类！");
        return;
    }
    form_data.append("category", category);

    $.ajax({
        url: "/admin/operation/handle_publish_post",
        type: "POST",
        data: form_data,
        processData: false,  // 告诉jQuery不要去处理发送的数据
        contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
        success: function (responseText) {
            alert(responseText);
        }
    });
});