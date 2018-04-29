<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\View;
use app\index\model\Post;
use think\Db;

class Index extends Controller
{
    //定义一个visit_id，用于记录本次访问的id
    protected $visit_id = null;

    //定义一个视图变量，每次调用这个控制器的任何方法来渲染模板，都会用此变量来引用渲染方法，
    //目的是统一一次请求中触发的不同方法所用于渲染模板的视图变量，让不同方法渲染同一模板
    protected $view;
    //自定义前置方法
    protected $beforeActionList = [
        'init_other_bar' => ['except' => 'author'],
        'init_slider' => ['only' => 'index'],
        'handle_visit' => ['except' => '']
    ];

    //默认方法，功能是显示首页
    public function index()
    {
        $post = new Post();
        $posts = $post->where("")->order("timestamp", "desc")->paginate(5);
        $view = $this->view;
        $view->assign("posts", $posts);
        $view->class_of_nav_item_home = "active";
        return $view->fetch("index");
    }

    //分类方法，功能是根据请求参数返回相应分类页面
    public function category()
    {
        $post = new Post();
        $view = $this->view;
        $request = Request::instance();
        $category = $request->get("category");
        $view->{"class_of_nav_item_" . $category} = "active";
        $posts = $post->where("category", $category)->order("timestamp", "desc")->paginate(2);
        $view->assign("posts", $posts);
        return $view->fetch("category");
    }

    //post方法，功能是显示博客的post（博文），根据get方式传递过来的博文id参数的值决定显示哪篇博文
    public function post()
    {
        $request = Request::instance();
        $post_id = $request->get("post_id");
        $result = Db::query("select * from post where id = " . $post_id);
        $record_of_visits = Db::query("select visit_posts,visit_posts_count from visit where id = " . $this->visit_id);
        $visit_posts = $record_of_visits[0]["visit_posts"];
        $visit_posts_count = $record_of_visits[0]["visit_posts_count"];
        // if (strpos($visit_posts, $post_id) == false) {       //如果先前没有阅读过该博文
        if (!in_array($post_id, explode(',', $visit_posts))) {       //如果先前没有阅读过该博文
                //那么这个博文阅读次数加1
            Db::execute("update post set post_click_count = " . ($result[0]["post_click_count"] + 1) . " where id = " . $post_id);
                //然后往访问记录表的visit_posts字段中添加访问过的博文的id，并且该访客记录的阅读博文篇数加1
            $visit_posts = "'" . $visit_posts . "," . $post_id . "'";
            $visit_posts_count = $visit_posts_count + 1;
            Db::execute("update visit set visit_posts = " . $visit_posts . ",visit_posts_count = " . $visit_posts_count . " where id = " . $this->visit_id);
                //先自增1再赋值给模板，因为查询点击次数之后，进行的这次点击操作也算是一次点击量，应该在之前查询到的基础上加1
            $result[0]["post_click_count"] = $result[0]["post_click_count"] + 1;
        }
        $category = $result[0]["category"];
        $view = $this->view;
        $view->assign("post", $result[0]);
        $view->{"class_of_nav_item_" . $category} = "active";
        return $view->fetch("post");
    }

    //author方法，功能是显示博主介绍页面
    public function author()
    {
        $view = new View();
        Db::execute("update visit set visit_author = 1 where id = " . $this->visit_id);       //访问过博主介绍
        $result = Db::query("select * from author");
        $author = $result[0];
        $view->assign("author", $author);
        return $view->fetch("author");
    }

    //category_by_month方法，按时间分类，返回指定月份的博文
    public function category_by_month()
    {
        $view = $this->view;
        $post = new Post();
        $request = Request::instance();
        $month = $request->get("month");
        $posts = $post->whereTime("create_date", "between", [$month, $month . '-31'])->order("timestamp", "asc")->paginate(3);
        $view->assign("posts", $posts);
        return $view->fetch("category");
    }

    //前置方法，自定义控制器内某些方法执行前先调用此方法
    public function init_other_bar()
    {
        $view = $this->view;

        //给博主介绍板块变量赋值
        $result = Db::query("select * from author");
        $author = $result[0];
        $view->assign("author", $author);

        //给推荐博文板块变量赋值
        $result = Db::query("select * from post order by post_click_count desc limit 5");
        $view->assign("recommended_posts", $result);

        //给时间查找板块变量赋值
        $recent_months;
        for ($i = 0; $i < 12; $i++) {
            $now_month = date('Y-m', time());
            $month = substr($now_month, 5, 2);
            $year = substr($now_month, 0, 4);
            if ($month - $i < 1) {
                $month = 12 + $month - $i;
                $year = $year - 1;
            } else {
                $month = $month - $i;
            }
            if ($month < 10) {
                $month = "0" . $month;
            }
            $recent_month = array(
                "str" => $year . "-" . $month,
                "year" => $year,
                "month" => $month
            );
            $recent_months[$i] = $recent_month;
        }
        $view->assign("recent_months", $recent_months);
    }

    //前置方法，给滑动图片控件赋值
    public function init_slider()
    {
        $view = $this->view;

        $top_posts = Db::query("select * from post where is_top = 1 order by timestamp desc limit 3");
        $view->assign("top_posts", $top_posts);
    }

    //前置方法，判断客户端浏览器是否是近期初次访问网站，如果是就作出相应处理
    public function handle_visit()
    {
        $visit_id = "none";
        if (empty($_COOKIE['lastVisit'])) {       //判空则初次访问
            //访问网站人数加1，并记录访问主机的ip地址
            $ip = $_SERVER["REMOTE_ADDR"];
            $ip = ip2long($ip);     //此处对ip进行转换，以方便进行数据库存储，取出时使用long2ip($ip)方法进行反向转换
            $visit_time = "'" . date('Y-m-d H:i:s') . "'";
            $sql = "INSERT INTO visit (ip,visit_time,visit_posts,visit_author) VALUES(" . $ip . "," . $visit_time . ",NULL,0)";
            // $sql = "INSERT INTO visit (ip) VALUES($ip)";
            Db::execute($sql);
            $visit_id = (Db::query("select id from visit where visit_time = " . $visit_time))[0]["id"];
        }
        setcookie('lastVisit', date('Y-m-d H:i:s'), time() + 3600, "/");     //设置cookie字段有效期
        if ($visit_id != "none") {
            setcookie('visit_id', $visit_id, time() + 3600, "/");
            //生成的visit_id要同步到本类中的visit_id，以方便其他方法使用
            $this->visit_id = $visit_id;
        } else {
            setcookie('visit_id', $_COOKIE['visit_id'], time() + 3600, "/");
            //生成的visit_id要同步到本类中的visit_id，以方便其他方法使用
            $this->visit_id = $_COOKIE['visit_id'];
        }
    }

    //初始化方法，调用控制器时会调用
    public function _initialize()
    {
        $this->view = new View();
        //定义一个空变量，在查找不到数据的时候显示
        $empty = '<div class="alert alert-warning" role="alert">暂时查找不到您想看的数据，请先看看别的内容吧。</div>';
        $this->view->assign("empty",$empty);
    }
}