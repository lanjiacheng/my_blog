<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\View;
use think\paginator\driver\Bootstrap;

class Overview extends Controller
{
    //设置前置方法
    protected $beforeActionList = [
        'init_nav' => ['except' => ''],          //将init_nav设置为本控制器所有方法的前置方法，已设置导航栏属性
        'check_signin' => ['except' => '']
    ];

    //day方法，返回某日的概览信息
    public function day()
    {
        //先列出需要赋值的变量
        $title = "";                //标题
        $summa = array();             //汇总信息
        $click_posts = array();       //今日被点击过的博文
        $visit_records = array();     //访客记录
        $date;             //本次查询的日期
        $recent_dates = array();        //最近日期列表
        $calendar = array();          //日历控件中的相关变量

        //先判断请求中是否有date参数，没有默认返回的是当天的信息
        $request = Request::instance();
        //给date赋值
        if ($request->get("date") != null) {
            $date = $request->get("date");
        } else {
            $date = date('Y-m-d');

        }

        //给标题赋值
        if ($date == date('Y-m-d')) {
            $title = "今日访问记录";
        } else {
            $title = substr($date, 0, 4) . "年" . substr($date, 5, 2) . "月" . substr($date, 8, 2) . "日" . "访问记录";
        }

        //查询某日的访问记录
        $visit_records_of_day = Db::query("select * from visit where DATE_FORMAT(visit_time,'%Y-%m-%d')=" . "'" . $date . "' order by id desc");

        //统计某日访问总次数
        $summa["total_visit_count"] = sizeof($visit_records_of_day);

        //统计某日访问博文总数和内访客访问博主简介页面次数
        $total_post_read_count = 0;
        $total_introduction_click_count = 0;
        //记录某日所有访问博文记录的博文id，博文每被访问一次，该变量就包含该博文id的一个副本
        $visit_posts = "";
        for ($i = 0; $i < sizeof($visit_records_of_day); $i++) {
            $total_post_read_count += $visit_records_of_day[$i]["visit_posts_count"];
            if ($visit_records_of_day[$i]["visit_author"] == 1) {
                $total_introduction_click_count += 1;
            }
            $visit_posts = $visit_posts . $visit_records_of_day[$i]["visit_posts"];
        }
        $summa["total_post_read_count"] = $total_post_read_count;
        $summa["total_introduction_click_count"] = $total_introduction_click_count;

        //统计博文点击量排行的相关信息
        $click_posts_no_order = array();
        $visit_posts_array = explode(',', $visit_posts);
        //下面从某日所有访问记录中统计出被访问的博文和其对应的访问次数，以博文id为键、点击次数为值记录在$click_posts_no_order变量中
        for ($i = 0; $i < sizeof($visit_posts_array); $i++) {       //遍历某日被访问的所有博文的所有id
            if ($visit_posts_array[$i] != "") {     //如果非空，也就是有效博文id
                $key = $visit_posts_array[$i];
                if (isset($click_posts_no_order[$key])) {       //如果用于记录的数组的键中包含该博文id
                    $click_posts_no_order[$key]++;          //那么这个这个数组中以该博文id为键对应的值+1，也就是点击次数+1
                } else {                                          //如果数组中还没有以该博文id为名字的键
                    $click_posts_no_order[$key] = 1;            //那么往该数组添加以该博文id为名字的键并赋值为1
                }
            }
        }

        //将原来的记录进行修改，放进新的数组中
        foreach ($click_posts_no_order as $key => $value) {
            $result = Db::query("select title from post where id = " . $key);
            if (count($result) > 0) {                           //如果访问过的博文还存在，就添加该条访问信息
                $visit_post["title"] = $result[0]["title"];
                $visit_post["id"] = $key;
                $visit_post["click_count"] = $value;
                $click_posts[] = $visit_post;
            } else {                                            //如果不存在，跳过
                break;
            }
        }

        //接下来对被访问的博文按访问次数进行降序排序，冒泡排序
        for ($i = 0; $i < sizeof($click_posts); $i++) {
            for ($j = 0; $j < (sizeof($click_posts) - $i - 1); $j++) {
                if ($click_posts[$j]["click_count"] < $click_posts[$j + 1]["click_count"]) {
                    $tmp = $click_posts[$j];
                    $click_posts[$j] = $click_posts[$j + 1];
                    $click_posts[$j + 1] = $tmp;
                }
            }
        }
        //限制最多返回10条博客访问记录
        if (sizeof($visit_posts) > 10) {
            $visit_posts = array_slice($visit_posts, 0, 10);
        }

        //统计访问记录，限制最多返回10条
        if (sizeof($visit_records_of_day) > 10) {
            $visit_records = array_slice($visit_records_of_day, 0, 10);
        } else {
            $visit_records = $visit_records_of_day;
        }

        //设置日历中的相关变量
        $calendar["hint"] = "输入日期：";
        $calendar["type"] = "day";
        $calendar["format_1"] = "yyyy mm dd";
        $calendar["format_2"] = "yyyy-mm-dd";

        //设置日期列表相关变量
        $now_date = date('Y-m-d', time());
        for ($i = 0; $i < 10; $i++) {
            $recent_date = date('Y-m-d', time() - ($i * 86400));              //1天=86400秒
            $recent_dates[] = $recent_date;
        }

        //给模板赋值
        $view = $this;
        $view->assign("title", $title);
        $view->assign("summa", $summa);
        $view->assign("click_posts", $click_posts);
        $view->assign("visit_records", $visit_records);
        $view->assign("date", $date);
        $view->assign("recent_dates", $recent_dates);
        $view->assign("calendar", $calendar);
        return $view->fetch("day");
    }

    //month方法，返回某月的概览信息
    public function month()
    {
            //先列出需要赋值的变量
        $title = "";                //标题
        $summa = array();             //汇总信息
        $click_posts = array();       //本月被点击过的博文
        $visit_records = array();     //访客记录
        $date;             //本次查询的月期或月份月份
        $recent_dates = array();        //最近月份列表
        $calendar = array();          //月历控件中的相关变量
    
            //先判断请求中是否有date参数，没有默认返回的是当天的信息
        $request = Request::instance();
            //给date赋值
        if ($request->get("date") != null) {
            $date = $request->get("date");
        } else {
            $date = date('Y-m');

        }
    
            //给标题赋值
        if ($date == date('Y-m')) {
            $title = "本月访问记录";
        } else {
            $title = substr($date, 0, 4) . "年" . substr($date, 5, 2) . "月" . "访问记录";
        }
    
            //查询某月的访问记录
        $visit_records_of_month = Db::query("select * from visit where DATE_FORMAT(visit_time,'%Y-%m')=" . "'" . $date . "' order by id desc");
            // return dump($visit_records_of_month);
    
            //统计某月访问总次数
        $summa["total_visit_count"] = sizeof($visit_records_of_month);
    
            //统计某月访问博文总数和内访客访问博主简介页面次数
        $total_post_read_count = 0;
        $total_introduction_click_count = 0;
            //记录某月所有访问博文记录的博文id，博文每被访问一次，该变量就包含该博文id的一个副本
        $visit_posts = "";
        for ($i = 0; $i < sizeof($visit_records_of_month); $i++) {
            $total_post_read_count += $visit_records_of_month[$i]["visit_posts_count"];
            if ($visit_records_of_month[$i]["visit_author"] == 1) {
                $total_introduction_click_count += 1;
            }
            $visit_posts = $visit_posts . $visit_records_of_month[$i]["visit_posts"];
        }
        $summa["total_post_read_count"] = $total_post_read_count;
        $summa["total_introduction_click_count"] = $total_introduction_click_count;
    
            //统计博文点击量排行的相关信息
        $click_posts_no_order = array();
        $visit_posts_array = explode(',', $visit_posts);
            //下面从某月所有访问记录中统计出被访问的博文和其对应的访问次数，以博文id为键、点击次数为值记录在$click_posts_no_order变量中
        for ($i = 0; $i < sizeof($visit_posts_array); $i++) {       //遍历某月被访问的所有博文的所有id
            if ($visit_posts_array[$i] != "") {     //如果非空，也就是有效博文id
                $key = $visit_posts_array[$i];
                if (isset($click_posts_no_order[$key])) {       //如果用于记录的数组的键中包含该博文id
                    $click_posts_no_order[$key]++;          //那么这个这个数组中以该博文id为键对应的值+1，也就是点击次数+1
                } else {                                          //如果数组中还没有以该博文id为名字的键
                    $click_posts_no_order[$key] = 1;            //那么往该数组添加以该博文id为名字的键并赋值为1
                }
            }
        }
    
            //将原来的记录进行修改，放进新的数组中
        foreach ($click_posts_no_order as $key => $value) {
            $result = Db::query("select title from post where id = " . $key);
            if (count($result) > 0) {                           //如果访问过的博文还存在，就添加该条访问信息
                $visit_post["title"] = $result[0]["title"];
                $visit_post["id"] = $key;
                $visit_post["click_count"] = $value;
                $click_posts[] = $visit_post;
            } else {                                            //如果不存在，跳过
                break;
            }
        }
    
            //接下来对被访问的博文按访问次数进行降序排序，冒泡排序
        for ($i = 0; $i < sizeof($click_posts); $i++) {
            for ($j = 0; $j < (sizeof($click_posts) - $i - 1); $j++) {
                if ($click_posts[$j]["click_count"] < $click_posts[$j + 1]["click_count"]) {
                    $tmp = $click_posts[$j];
                    $click_posts[$j] = $click_posts[$j + 1];
                    $click_posts[$j + 1] = $tmp;
                }
            }
        }
            //限制最多返回10条博客访问记录
        if (sizeof($visit_posts) > 10) {
            $visit_posts = array_slice($visit_posts, 0, 10);
        }
    
            //统计访问记录，限制最多返回10条
        if (sizeof($visit_records_of_month) > 10) {
            $visit_records = array_slice($visit_records_of_month, 0, 10);
        } else {
            $visit_records = $visit_records_of_month;
        }
    
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
    
            //给模板赋值
        $view = $this;
        $view->assign("title", $title);
        $view->assign("summa", $summa);
        $view->assign("click_posts", $click_posts);
        $view->assign("visit_records", $visit_records);
        $view->assign("date", $date);
        $view->assign("recent_dates", $recent_dates);
        $view->assign("calendar", $calendar);
        return $view->fetch("month");
    }

    //year方法，返回某年的概览信息
    public function year()
    {
            //先列出需要赋值的变量
        $title = "";                //标题
        $summa = array();             //汇总信息
        $click_posts = array();       //本年被点击过的博文
        $visit_records = array();     //访客记录
        $date;             //本次查询的年期或年份年份
        $recent_dates = array();        //最近年份列表
        $calendar = array();          //日历控件中的相关变量
    
            //先判断请求中是否有date参数，没有默认返回的是当天的信息
        $request = Request::instance();
            //给date赋值
        if ($request->get("date") != null) {
            $date = $request->get("date");
        } else {
            $date = date('Y');
        }
    
        //给标题赋值
        if ($date == date('Y')) {
            $title = "本年访问记录";
        } else {
            $title = substr($date, 0, 4) . "年" . "访问记录";
        }
    
        //查询某年的访问记录
        $visit_records_of_year = Db::query("select * from visit where DATE_FORMAT(visit_time,'%Y')=" . "'" . $date . "' order by id desc");
    
        //统计某年访问总次数
        $summa["total_visit_count"] = sizeof($visit_records_of_year);
    
        //统计某年访问博文总数和内访客访问博主简介页面次数
        $total_post_read_count = 0;
        $total_introduction_click_count = 0;
            //记录某年所有访问博文记录的博文id，博文每被访问一次，该变量就包含该博文id的一个副本
        $visit_posts = "";
        for ($i = 0; $i < sizeof($visit_records_of_year); $i++) {
            $total_post_read_count += $visit_records_of_year[$i]["visit_posts_count"];
            if ($visit_records_of_year[$i]["visit_author"] == 1) {
                $total_introduction_click_count += 1;
            }
            $visit_posts = $visit_posts . $visit_records_of_year[$i]["visit_posts"];
        }
        $summa["total_post_read_count"] = $total_post_read_count;
        $summa["total_introduction_click_count"] = $total_introduction_click_count;
    
            //统计博文点击量排行的相关信息
        $click_posts_no_order = array();
        $visit_posts_array = explode(',', $visit_posts);
            //下面从某年所有访问记录中统计出被访问的博文和其对应的访问次数，以博文id为键、点击次数为值记录在$click_posts_no_order变量中
        for ($i = 0; $i < sizeof($visit_posts_array); $i++) {       //遍历某年被访问的所有博文的所有id
            if ($visit_posts_array[$i] != "") {     //如果非空，也就是有效博文id
                $key = $visit_posts_array[$i];
                if (isset($click_posts_no_order[$key])) {       //如果用于记录的数组的键中包含该博文id
                    $click_posts_no_order[$key]++;          //那么这个这个数组中以该博文id为键对应的值+1，也就是点击次数+1
                } else {                                          //如果数组中还没有以该博文id为名字的键
                    $click_posts_no_order[$key] = 1;            //那么往该数组添加以该博文id为名字的键并赋值为1
                }
            }
        }
    
            //将原来的记录进行修改，放进新的数组中
        foreach ($click_posts_no_order as $key => $value) {
            $result = Db::query("select title from post where id = " . $key);
            if (count($result) > 0) {                           //如果访问过的博文还存在，就添加该条访问信息
                $visit_post["title"] = $result[0]["title"];
                $visit_post["id"] = $key;
                $visit_post["click_count"] = $value;
                $click_posts[] = $visit_post;
            } else {                                            //如果不存在，跳过
                break;
            }
        }
    
            //接下来对被访问的博文按访问次数进行降序排序，冒泡排序
        for ($i = 0; $i < sizeof($click_posts); $i++) {
            for ($j = 0; $j < (sizeof($click_posts) - $i - 1); $j++) {
                if ($click_posts[$j]["click_count"] < $click_posts[$j + 1]["click_count"]) {
                    $tmp = $click_posts[$j];
                    $click_posts[$j] = $click_posts[$j + 1];
                    $click_posts[$j + 1] = $tmp;
                }
            }
        }
            //限制最多返回10条博客访问记录
        if (sizeof($visit_posts) > 10) {
            $visit_posts = array_slice($visit_posts, 0, 10);
        }
    
            //统计访问记录，限制最多返回10条
        if (sizeof($visit_records_of_year) > 10) {
            $visit_records = array_slice($visit_records_of_year, 0, 10);
        } else {
            $visit_records = $visit_records_of_year;
        }
    
            //设置年历中的相关变量
        $calendar["hint"] = "输入年份：";
        $calendar["type"] = "year";
        $calendar["format_1"] = "yyyy";
        $calendar["format_2"] = "yyyy";
    
            //设置年份列表相关变量
        $now_date = date('Y-m', time());
        for ($i = 0; $i < 10; $i++) {
            $year = $now_date;
            $year = $now_date - $i;
            $recent_date = $year;
            $recent_dates[] = $recent_date;
        }
    
            //给模板赋值
        $view = $this;
        $view->assign("title", $title);
        $view->assign("summa", $summa);
        $view->assign("click_posts", $click_posts);
        $view->assign("visit_records", $visit_records);
        $view->assign("date", $date);
        $view->assign("recent_dates", $recent_dates);
        $view->assign("calendar", $calendar);
        return $view->fetch("year");
    }
    //root方法，返回的是博客发布至今的所有数据的概览信息
    public function root()
    {
            //先列出需要赋值的变量
        $title = "";                //标题
        $summa = array();             //汇总信息
        $click_posts = array();       //本年被点击过的博文
        $visit_records = array();     //访客记录

        //给标题赋值
        $title = "系统所有访问记录概览";

        //查询某年的访问记录
        $visit_records_of_root = Db::query("select * from visit order by id desc");
    
        //统计某全部访问总次数
        $summa["total_visit_count"] = sizeof($visit_records_of_root);
    
        //统计全部访问博文总数和内访客访问博主简介页面次数
        $total_post_read_count = 0;
        $total_introduction_click_count = 0;
            //记录所有访问博文记录的博文id，博文每被访问一次，该变量就包含该博文id的一个副本
        $visit_posts = "";
        for ($i = 0; $i < sizeof($visit_records_of_root); $i++) {
            $total_post_read_count += $visit_records_of_root[$i]["visit_posts_count"];
            if ($visit_records_of_root[$i]["visit_author"] == 1) {
                $total_introduction_click_count += 1;
            }
            $visit_posts = $visit_posts . $visit_records_of_root[$i]["visit_posts"];
        }
        $summa["total_post_read_count"] = $total_post_read_count;
        $summa["total_introduction_click_count"] = $total_introduction_click_count;
    
            //统计博文点击量排行的相关信息
        $click_posts_no_order = array();
        $visit_posts_array = explode(',', $visit_posts);
            //下面从所有访问记录中统计出被访问的博文和其对应的访问次数，以博文id为键、点击次数为值记录在$click_posts_no_order变量中
        for ($i = 0; $i < sizeof($visit_posts_array); $i++) {       //遍历被访问的所有博文的所有id
            if ($visit_posts_array[$i] != "") {     //如果非空，也就是有效博文id
                $key = $visit_posts_array[$i];
                if (isset($click_posts_no_order[$key])) {       //如果用于记录的数组的键中包含该博文id
                    $click_posts_no_order[$key]++;          //那么这个这个数组中以该博文id为键对应的值+1，也就是点击次数+1
                } else {                                          //如果数组中还没有以该博文id为名字的键
                    $click_posts_no_order[$key] = 1;            //那么往该数组添加以该博文id为名字的键并赋值为1
                }
            }
        }
    
            //将原来的记录进行修改，放进新的数组中
        foreach ($click_posts_no_order as $key => $value) {
            $result = Db::query("select title from post where id = " . $key);
            if (count($result) > 0) {                           //如果访问过的博文还存在，就添加该条访问信息
                $visit_post["title"] = $result[0]["title"];
                $visit_post["id"] = $key;
                $visit_post["click_count"] = $value;
                $click_posts[] = $visit_post;
            } else {                                            //如果不存在，跳过
                break;
            }
        }
    
            //接下来对被访问的博文按访问次数进行降序排序，冒泡排序
        for ($i = 0; $i < sizeof($click_posts); $i++) {
            for ($j = 0; $j < (sizeof($click_posts) - $i - 1); $j++) {
                if ($click_posts[$j]["click_count"] < $click_posts[$j + 1]["click_count"]) {
                    $tmp = $click_posts[$j];
                    $click_posts[$j] = $click_posts[$j + 1];
                    $click_posts[$j + 1] = $tmp;
                }
            }
        }
            //限制最多返回10条博客访问记录
        if (sizeof($visit_posts) > 10) {
            $visit_posts = array_slice($visit_posts, 0, 10);
        }
    
            //统计访问记录，限制最多返回10条
        if (sizeof($visit_records_of_root) > 10) {
            $visit_records = array_slice($visit_records_of_root, 0, 10);
        } else {
            $visit_records = $visit_records_of_root;
        }

            //给模板赋值
        $view = $this;
        $view->assign("title", $title);
        $view->assign("summa", $summa);
        $view->assign("click_posts", $click_posts);
        $view->assign("visit_records", $visit_records);
        return $view->fetch("root");
    }

    //more_click_posts方法，根据请求参数返回相应的博文访问记录
    public function more_click_posts()
    {
        //标题
        $title = "";
        $request = Request::instance();
        $type = $request->get("type");
        $date = $request->get("date");
        $format = "";

        switch ($type) {
            case "day":
                $format = "'%Y-%m-%d'";
                $title = $date . "日点击博文记录";
                break;
            case "month":
                $format = "'%Y-%m'";
                $title = $date . "月点击博文记录";
                break;
            case "year":
                $format = "'%Y'";
                $title = $date . "年点击博文记录";
                break;
        }
        //查询某时间的访问记录
        $visit_records = array();
        if ($type == "root") {
            $visit_records = Db::query("select * from visit order by id desc ");
            $title = "全部点击博文记录";
        } else {
            $visit_records = Db::query("select * from visit where DATE_FORMAT(visit_time," . $format . ")='" . $date . "' order by id desc ");
        }
        $visit_posts = " ";
        for ($i = 0; $i < sizeof($visit_records); $i++) {
            $visit_posts = $visit_posts . $visit_records[$i]["visit_posts"];
        }
        //统计博文点击量排行的相关信息
        $click_posts_no_order = array();
        $visit_posts_array = explode(',', $visit_posts);
        //下面从某日所有访问记录中统计出被访问的博文和其对应的访问次数，以博文id为键、点击次数为值记录在$click_posts_no_order变量中
        for ($i = 0; $i < sizeof($visit_posts_array); $i++) {       //遍历某日被访问的所有博文的所有id
            if ($visit_posts_array[$i] != " ") {     //如果非空，也就是有效博文id
                $key = $visit_posts_array[$i];
                if (isset($click_posts_no_order[$key])) {       //如果用于记录的数组的键中包含该博文id
                    $click_posts_no_order[$key]++;          //那么这个这个数组中以该博文id为键对应的值+1，也就是点击次数+1
                } else {                                          //如果数组中还没有以该博文id为名字的键
                    $click_posts_no_order[$key] = 1;            //那么往该数组添加以该博文id为名字的键并赋值为1
                }
            }
        }

        //将原来的记录进行修改，放进新的数组中
        $click_posts = array();             //存储博文记录的数组
        foreach ($click_posts_no_order as $key => $value) {
            $result = Db::query("select title from post where id = " . $key);
            if (count($result) > 0) {                           //如果访问过的博文还存在，就添加该条访问信息
                $visit_post["title"] = $result[0]["title"];
                $visit_post["id"] = $key;
                $visit_post["click_count"] = $value;
                $click_posts[] = $visit_post;
            } else {                                            //如果不存在，跳过
                break;
            }
        }

        //接下来对被访问的博文按访问次数进行降序排序，冒泡排序
        for ($i = 0; $i < sizeof($click_posts); $i++) {
            for ($j = 0; $j < (sizeof($click_posts) - $i - 1); $j++) {
                if ($click_posts[$j]["click_count"] < $click_posts[$j + 1]["click_count"]) {
                    $tmp = $click_posts[$j];
                    $click_posts[$j] = $click_posts[$j + 1];
                    $click_posts[$j + 1] = $tmp;
                }
            }
        }

        //分页输出
        $count = count($click_posts);
        $curpage = input('page') ? input('page') : 1;
        $page_item_count = 20;                //每页显示数目
        $total_item_count = count($click_posts);    //所有项目数量
        $show_data = array();                   //要展示的数据
        if ($total_item_count > 0) {
            $all_items = array_chunk($click_posts, $page_item_count, true);       //先分割
            $show_data = $all_items[$curpage - 1];                                 //取出要展示的项目
        }
        $p = Bootstrap::make($show_data, $page_item_count, $curpage, $total_item_count, $simple = false, $options = [
            'var_page' => 'page',
            'path' => url('/admin/overview/more_click_posts'),//这里根据需要修改url
            'query' => [],
            'fragment' => '',
        ]);

        $p->appends($_GET);
        $this->assign('title', $title);
        $this->assign('click_posts', $p);
        $this->assign('pagelist', $p->render());
        return $this->fetch("more_click_posts");
    }

    //more_visit_records方法，根据请求参数返回响应访客记录
    public function more_visit_records()
    {
        //标题
        $title = "";
        $request = Request::instance();
        $type = $request->get("type");
        $date = $request->get("date");
        $format = "";

        switch ($type) {
            case "day":
                $format = "'%Y-%m-%d'";
                $title = $date . "日访客记录";
                break;
            case "month":
                $format = "'%Y-%m'";
                $title = $date . "月访客记录";
                break;
            case "year":
                $format = "'%Y'";
                $title = $date . "年访客记录";
                break;
        }

        //查询某时间的访问记录
        $visit_records = array();
        if ($type == "root") {
            $visit_records = Db::query("select * from visit order by id desc ");
            $title = "全部访客记录";
        } else {
            $visit_records = Db::query("select * from visit where DATE_FORMAT(visit_time," . $format . ")='" . $date . "' order by id desc ");
        }

        //分页输出
        $curpage = input('page') ? input('page') : 1;
        $page_item_count = 20;                //每页显示数目
        $total_item_count = count($visit_records);    //所有项目数量
        $show_data = array();
        if ($total_item_count > 0) {
            $all_items = array_chunk($visit_records, $page_item_count, true);       //先分割
            $show_data = $all_items[$curpage - 1];                           //取出要展示的项目
        }
        $p = Bootstrap::make($show_data, $page_item_count, $curpage, $total_item_count, $simple = false, $options = [
            'var_page' => 'page',
            'path' => url('/admin/overview/more_visit_records'),//这里根据需要修改url
            'query' => [],
            'fragment' => '',
        ]);

        $p->appends($_GET);
        $this->assign('title', $title);
        $this->assign('visit_records', $p);
        $this->assign('pagelist', $p->render());
        return $this->fetch("more_visit_records");
    }

    //visit_posts方法，根据请求中的visit_id参数，返回该访问id所访问过的博文
    public function visit_posts()
    {
        $response_content = "该访客访问过的博文如下：\r\n";                                      //定义返回内容
        $visit_id = $_GET["visit_id"];
        $visit_record = Db::query("select * from visit where id = " . $visit_id)[0];
        $visit_posts_str = $visit_record["visit_posts"];             //获取访问过的博文id组成的字符串
        $visit_posts_arr = explode(',', $visit_posts_str);
        $order = 1;                                                  //定义序号
        foreach ($visit_posts_arr as $key => $value) {
            if ($value != "") {
                $result = Db::query("select title from post where id = " . $value);
                if (count($result) > 0) {
                    $title = $result[0]["title"];               //获取标题
                    $response_content .= $order++ . "." . $title . "\r\n";
                }
            }
        }
        return $response_content;
    }

    //前置方法，用于设置导航栏属性
    public function init_nav()
    {
        $class_of_overview = "active";
        $this->assign("class_of_overview", $class_of_overview);
    }

    //前置方法，用于检测登录情况
    public function check_signin()
    {
        if (empty($_COOKIE['account']) || empty($_COOKIE['password'])) {                 //如果账号或密码为空
            $this->error('进入管理系统请先登录', '/admin/signin/signin.html', 3);               //跳转到登录界面
        }
    }
}