<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\admin\model\Post;

class Operation extends Controller
{
    //设置前置方法
    protected $beforeActionList = [
        'check_signin' => ['except' => '']
    ];

    public function publish()
    {
        $this->assign("class_of_operation", "active");
        $this->assign("class_of_publish", "active");
        return $this->fetch("publish");
    }

    public function manage()
    {
        //设置月历中的相关变量
        $calendar["hint"] = "输入月份：";
        $calendar["type"] = "month";
        $calendar["format_1"] = "yyyy mm";
        $calendar["format_2"] = "yyyy-mm";
                        
        //设置月份列表相关变量
        $now_date = date('Y-m', time());
        for ($i = 0; $i < 10; $i++) {
            $year = substr($now_date, 0, 4);
            $month = substr($now_date, 5, 2);
            if ($month - $i < 1) {
                $month = 12 + $month - $i;
                if ($month < 10) {
                    $month = "0" . $month;
                }
                $year--;
            } else {
                $month = $month - $i;
                if ($month < 10) {
                    $month = "0" . $month;
                }
            }
            $recent_date = $year . "-" . $month;
            $recent_dates[] = $recent_date;
        }

        //获取博文列表
        $title = "";
        $month = "";                //定义月份，用来保存要查找的月份
        if (isset($_GET["month"])) {
            if ($_GET["month"] == "") {
                $month = date("Y-m");
                $title = "本月博文记录";
            } else {
                $month = $_GET["month"];
                $title = substr($month, 0, 4) . "年" . substr($month, 5, 2) . "月的博文";
            }
        } else {
            $month = date("Y-m");
            $title = "本月博文记录";
        }

        $page = 0;                   //记录当前页数
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }

        $rows = 5;                 //定义每页显示数目

        $post = new Post();
        $posts = $post->whereTime("create_date", "between", [$month, $month . '-31'])->order("is_top desc,timestamp asc")->paginate($rows);
        $this->assign("title", $title);
        $this->assign("posts", $posts);
        $this->assign("page", $page);
        $this->assign("rows", $rows);
        $this->assign("recent_dates", $recent_dates);
        $this->assign("calendar", $calendar);
        $this->assign("class_of_operation", "active");
        $this->assign("class_of_manage", "active");
        return $this->fetch();
    }

    //处理上传博文以及内容的方法
    public function handle_publish_post()
    {
        $timestamp = $_POST["timestamp"];           //获取客户端时间戳
        $images_path = __DIR__ . '/../../../public/static/images/' . $timestamp . '/';   //组装要保存图片路径
        if (!is_dir($images_path)) {              //如果目录不存在
            mkdir($images_path);                //创建存放图片的目录
        }
        //处理上传的图片文件
        foreach ($_FILES as $key => $value) {
            if ($key === "image_preview") {             //如果是预览图片
                copy($value["tmp_name"], $images_path . "image_preview.jpg");         //默认预览图片都以jpg格式存储
                continue;
            } else {                              //如果不是预览图片
                $file_format = strtolower(substr($value["name"], strripos($value["name"], ".")));  //获取文件格式
                copy($value["tmp_name"], $images_path . $key . $file_format);
            }
        }
        //罗列需要的参数
        $title = "";
        $author = "";
        $category = "";
        $text_preview = "";
        $create_date = "'" . date('Y-m-d') . "'";           //创建时间
        $post_content = "";
        foreach ($_POST as $key => $value) {
            switch ($key) {
                case "title":
                    $title = "'" . $value . "'";
                    break;
                case "author":
                    $author = "'" . $value . "'";
                    break;
                case "category":
                    $category = "'" . $value . "'";
                    break;
                case "text_preview":
                    $text_preview = "'" . $value . "'";
                    break;
                case "post_content":
                    $post_content = "'" . $value . "'";
                    break;
            }
        }
        $sql = "insert into post(timestamp,author,create_date,category,title,preview,content) values(" . $timestamp . "," . $author . "," . $create_date . "," . $category . "," . $title . "," . $text_preview . "," . $post_content . ")";
        Db::execute($sql);
        return "发表成功";
    }

    //定义删除文件夹方法
    function deldir($dir)
    {
            //先删除目录下的文件：
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = $dir . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    deldir($fullpath);
                }
            }
        }

        closedir($dh);
            //删除当前文件夹：
        if (rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }

    //响应删除和（取消）置顶操作
    public function handle_manage()
    {
        switch ($_GET["manage"]) {
            case "top":
                Db::execute("update post set is_top = '1' where id = '" . $_GET["id"] . "'");
                return "置顶id为" . $_GET["id"] . "的博文成功！";
                break;
            case "un_top":
                Db::execute("update post set is_top = '0' where id = '" . $_GET["id"] . "'");
                return "取消置顶id为" . $_GET["id"] . "的博文成功！";
                break;
            case "delete":
                $post = Db::query("select timestamp from post where id = " . $_GET["id"]);
                $timestamp = $post[0]["timestamp"];
                $images_path = __DIR__ . '/../../../public/static/images/' . $timestamp . '/';   //获取保存图片路径
                $this->deldir($images_path);                   //删除文件夹
                Db::execute("delete from post where post.id = '" . $_GET["id"] . "'");
                return "删除id为" . $_GET["id"] . "的博文成功！";
                break;
        }
    }

    //前置方法，用于检测登录情况
    public function check_signin()
    {
        if (empty($_COOKIE['account']) || empty($_COOKIE['password'])) {                 //如果账号或密码为空
            $this->error('进入管理系统请先登录', '/admin/signin/signin.html', 3);               //跳转到登录界面
        }
    }
}