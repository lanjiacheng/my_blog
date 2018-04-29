// 以下代码用于设置日历控件

var form_date = $(".form_date");
var format_value = form_date.attr("data-link-format");
var startView_value;
var minView_value;
switch (format_value) {
    case "yyyy-mm-dd": format_value = "yyyy/mm/dd"; startView_value = 2; minView_value = 2; break;
    case "yyyy-mm": format_value = "yyyy/mm"; startView_value = 3; minView_value = 3; break;
    case "yyyy": format_value = "yyyy"; startView_value = 4; minView_value = 4; break;
}
$('.form_date').datetimepicker({
    language: 'zh-CN',
    format: format_value,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: startView_value,
    minView: minView_value,
    forceParse: 0,
    pickerPosition: "bottom-left"
});

//给日历旁边的查找按钮设置监听
var submitBtn = document.getElementById("mysubmit");
submitBtn.onclick = function (event) {
    if ($("#dtp_input2").attr("value") == "" & sessionStorage.getItem("lastmonth") == null) {
        alert("请输入要查找的月份！");
        event.preventDefault();
        return;
    }
    if ($("#dtp_input2").attr("value") == "") {
        $("#dtp_input2").attr("value", sessionStorage.getItem("lastmonth"));
    } else {
        sessionStorage.setItem("lastmonth", $("#dtp_input2").attr("value"));
    }
};

//给阅读博文篇数字样设置点击事件监听
$(".get_visit_posts").each(function(){
    $(this).click(function(event){
        event.preventDefault();
        var url = $(this).attr("href");
        $.get(url,function(data){
            alert(data);
        })
    });
});