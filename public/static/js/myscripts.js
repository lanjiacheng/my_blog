// 以下代码用于设置日历控件
$('.form_date').datetimepicker({
    language: 'zh-CN',
    format: "yyyy/mm",
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 3,
    minView: 3,
    forceParse: 0,
    pickerPosition: "bottom-left"
});

//给日历旁边的查找按钮设置监听
var submitBtn = document.getElementById("mysubmit");
submitBtn.onclick = function(event){
    if($("#dtp_input2").attr("value")==""&sessionStorage.getItem("lastmonth")==null){
        alert("请输入要查找的月份！");
        event.preventDefault();
        return;
    }
    if($("#dtp_input2").attr("value")==""){
        $("#dtp_input2").attr("value",sessionStorage.getItem("lastmonth"));
    }else{
        sessionStorage.setItem("lastmonth",$("#dtp_input2").attr("value"));
    }
};

//以下方法用于获取地址栏某参数的值
function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}

//动态修改页码标签的herf属性，在其后面添加"&month=xxx"(xxx为导航栏上的month值)
if (GetQueryString("month") != null|GetQueryString("category") != null) {
    var parent_of_li = $(".pagediv .pagination");
    var lis = parent_of_li.children();
    for (var i = 0; i < lis.length; i++) {
        li = lis[i];
        var children_of_li = $(li).children();
        if ($(children_of_li[0]).is('a')) {
            var href = $(children_of_li).attr('href');
            var new_href = "";
            if (GetQueryString("month")!=null){
                new_href = href + "&month=" + GetQueryString("month");
                $(children_of_li).attr('href',new_href);
            }
            if (GetQueryString("category")!=null){
                new_href = href + "&category=" + GetQueryString("category");
                $(children_of_li).attr('href',new_href);
            }
        }
    }
}