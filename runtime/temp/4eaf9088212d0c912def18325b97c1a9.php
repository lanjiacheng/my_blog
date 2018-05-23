<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:69:"/var/www/my_blog/public/../application/admin/view/overview/month.html";i:1524975511;s:28:"static/model/admin_head.html";i:1524975511;s:27:"static/model/admin_nav.html";i:1524975511;s:38:"static/model/admin_calendar_input.html";i:1524975511;}*/ ?>
<!DOCTYPE html>
<html lang="ch">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/static/images/tag_icon.png">
    <link rel="shortcut" href="/static/images/tag_icon.png" />
    <link rel="bookmark" href="/static/images/tag_icon.png"/>
    <title>LJC的博客管理系统</title>
    <link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css" /><link rel="stylesheet" type="text/css" href="/static/css/admin_mystyle.css" />
</head> <script type="text/javascript" src="/static/js/jquery.min.js"></script><script type="text/javascript" src="/static/js/bootstrap.min.js"></script>

<body>
    <!-- 添加导航栏 -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
                aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin/overview/day.html" style="padding:10px 10px">
                <img style="width: 30px;height: auto;" src="/static/images/nav_icon.png" />
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="<?php echo (isset($class_of_overview) && ($class_of_overview !== '')?$class_of_overview:" "); ?>">
                    <a href="/admin/overview/day.html">概览
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="<?php echo (isset($class_of_operation) && ($class_of_operation !== '')?$class_of_operation:" "); ?>">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">操作
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="<?php echo (isset($class_of_publish) && ($class_of_publish !== '')?$class_of_publish:" "); ?>">
                            <a href="/admin/operation/publish.html">发表</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li class="<?php echo (isset($class_of_manage) && ($class_of_manage !== '')?$class_of_manage:" "); ?>">
                            <a href="/admin/operation/manage.html">管理</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="/admin/signin/handle_signout.html">退出登录
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
    <!-- 内容 -->
    <div class="container-fluid content_body">
        <br/>
        <br/>
        <br/>
        <ol class="breadcrumb">
            <li>
                <a href="/admin/overview/root.html">根</a>
            </li>
            <li>
                <a href="/admin/overview/year.html">年</a>
            </li>
            <li class="active">
                月
            </li>
            <li>
                <a href="/admin/overview/day.html">日</a>
            </li>
        </ol>
        <div class=" row ">
            <div class="col-md-9 ">
                <div class="panel panel-default ">
                    <!-- Default panel contents -->
                    <div class="panel-heading ">
                        <h4><?php echo $title; ?></h4>
                    </div>
                    <ul class="list-group ">
                        <li class="list-group-item ">
                            <h5>汇总：</h5>
                            <table class="table table-bordered ">
                                <tbody>
                                    <tr>
                                        <td>访问次数：</td>
                                        <td><?php echo $summa['total_visit_count']; ?>次</td>
                                    </tr>
                                    <tr>
                                        <td>博文阅览篇数：</td>
                                        <td><?php echo $summa['total_post_read_count']; ?>篇</td>
                                    </tr>
                                    <tr>
                                        <td>博主介绍点击数：</td>
                                        <td><?php echo $summa['total_introduction_click_count']; ?>次</td>
                                    </tr>
                                </tbody>
                            </table>
                        </li>
                        <li class="list-group-item ">
                            <h5>博文点击量排行：</h5>
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th>博文标题</th>
                                        <th>点击数</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(is_array($click_posts) || $click_posts instanceof \think\Collection || $click_posts instanceof \think\Paginator): $i = 0; $__LIST__ = $click_posts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$click_post ): $mod = ($i % 2 );++$i;?>
                                    <tr name=" ">
                                        <th scope="row "><?php echo $key+1; ?></th>
                                        <td><?php echo $click_post['title']; ?></td>
                                        <td><?php echo $click_post['click_count']; ?></td>
                                    </tr>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                            <div class="row ">
                                <div class="col-12 ">
                                    <a href="/admin/overview/more_click_posts.html?type=month&date=<?php echo $date; ?> " style="float:
                right;;margin-right: 15px; ">
                                        <span class="glyphicon glyphicon-triangle-bottom " aria-hidden="true "></span>更多
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item ">
                            <h5>访问记录：</h5>
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th>访客ip</th>
                                        <th>时间</th>
                                        <th>阅读简介</th>
                                        <th>阅读博文数</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(is_array($visit_records) || $visit_records instanceof \think\Collection || $visit_records instanceof \think\Paginator): $i = 0; $__LIST__ = $visit_records;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$visit_record ): $mod = ($i % 2 );++$i;?>
                                    <tr>
                                        <th scope="row "><?php echo $key+1; ?></th>
                                        <td><?php echo long2ip($visit_record['ip']); ?></td>
                                        <td><?php echo $visit_record['visit_time']; ?></td>
                                        <td><?php switch($visit_record['visit_author']): case "1 ": ?>是<?php break; case "0
                                            ": ?>否<?php break; endswitch; ?>
                                        </td>
                                        <td>
                                            <a class="get_visit_posts" href="/admin/overview/visit_posts.html?visit_id=<?php echo $visit_record['id']; ?> "><?php echo $visit_record['visit_posts_count']; ?></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                            <div class="row ">
                                <div class="col-12 ">
                                    <a href="/admin/overview/more_visit_records.html?type=month&date=<?php echo $date; ?> " style="float:
                right;margin-right: 15px; ">
                                        <span class="glyphicon glyphicon-triangle-bottom " aria-hidden="true "></span>更多
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="panel panel-default ">
                    <!-- Default panel contents -->
                    <div class="panel-heading ">
                        <h4>往日访问记录</h4>
                    </div>
                    <ul class="list-group ">
                        <li class="list-group-item ">
                            <!-- 添加时间控件 -->
                            <!-- <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
<!-- <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"> -->
<link rel="stylesheet" type="text/css" href="/static/css/bootstrap-datetimepicker.min.css" />
<h5><?php echo $calendar['hint']; ?></h5>
<form action="/admin/overview/<?php echo $calendar['type']; ?>.html" class="form-horizontal" role="form">
    <div id="myrow" class="row">
        <div class="col-md-9 col-xs-9 mycol">
            <div class="input-group date form_date" data-date="" data-date-format="<?php echo $calendar['format_1']; ?>" data-link-field="dtp_input2" data-link-format="<?php echo $calendar['format_2']; ?>">
                <input class="form-control" size="16" readonly/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            <input type="hidden" id="dtp_input2" value="" name="date"/>
        </div>
        <div class="col-md-3 col-xs-3 mycol">
            <input id="mysubmit" class="btn" type="submit" value="查找" />
        </div>
    </div>
</form>
                        </li>
                        <li class="list-group-item ">
                            <h5>最近月份：</h5>
                            <table class="table table-bordered ">
                                <tbody>
                                    <?php if(is_array($recent_dates) || $recent_dates instanceof \think\Collection || $recent_dates instanceof \think\Paginator): $i = 0; $__LIST__ = $recent_dates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$recent_date ): $mod = ($i % 2 );++$i;?>
                                    <tr>
                                        <td>
                                            <span class="glyphicon glyphicon-calendar "></span>
                                            <a href="/admin/overview/month.html?date=<?php echo $recent_date; ?> "><?php echo $recent_date; ?></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="/static/js/bootstrap-datetimepicker.min.js"></script> <script type="text/javascript" src="/static/js/bootstrap-datetimepicker.zh-CN.js"></script> 
<script type="text/javascript" src="/static/js/admin_myscripts.js"></script>

</html>