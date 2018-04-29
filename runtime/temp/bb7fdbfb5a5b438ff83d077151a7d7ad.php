<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:74:"D:\wamp\www\my_blog\public/../application/admin\view\operation\manage.html";i:1524836623;s:28:"static/model/admin_head.html";i:1524927514;s:27:"static/model/admin_nav.html";i:1524927514;s:45:"static/model/admin_manage_calendar_input.html";i:1524927514;}*/ ?>
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
        <div class=" row ">
            <div class="col-md-9 ">
                <div class="panel panel-default ">
                    <!-- Default panel contents -->
                    <div class="panel-heading ">
                        <h4><?php echo $title; ?></h4>
                    </div>
                    <ul class="list-group ">
                        <li class="list-group-item ">
                            <div class="row">
                                <div class="col-md-1 col-xs-1">
                                    <h4>序号</h4>
                                </div>
                                <div class="col-md-7 col-xs-7">
                                    <h4>标题</h4>
                                </div>
                                <div class="col-md-2 col-xs-2">
                                    <h4>时间</h4>
                                </div>
                                <div class="col-md-2 col-xs-2">
                                    <h4>操作</h4>
                                </div>
                            </div>
                        </li>
                        <?php if(is_array($posts) || $posts instanceof \think\Collection || $posts instanceof \think\Paginator): $i = 0; $__LIST__ = $posts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$post): $mod = ($i % 2 );++$i;?>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-1 col-xs-1"><?php echo $i+($page-1)*$rows; ?></div>
                                <div class="col-md-7 col-xs-7"><?php echo $post['title']; ?></div>
                                <div class="col-md-2 col-xs-2"><?php echo $post['create_date']; ?></div>
                                <div class="col-md-2 col-xs-2">
                                    <div id_of_post="<?php echo $post['id']; ?>">
                                        <?php echo $post['is_top']==0?'
                                        <button class="top btn btn-success btn-xs" type="button">置顶</button>':'
                                        <button class="un_top btn btn-warning btn-xs" type="button">取顶</button>'; ?>
                                        <button class="delete btn btn-danger btn-xs" type="button">删除</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <div class="pagediv">
                        <?php echo $posts->render(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="panel panel-default ">
                    <!-- Default panel contents -->
                    <div class="panel-heading ">
                        <h4>按月份查找</h4>
                    </div>
                    <ul class="list-group ">
                        <li class="list-group-item ">
                            <!-- 添加时间控件 -->
                            <!-- <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
<!-- <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"> -->
<link rel="stylesheet" type="text/css" href="/static/css/bootstrap-datetimepicker.min.css" />
<h5>输入月份：</h5>
<form action="/admin/operation/manage.html" class="form-horizontal" role="form">
    <div id="myrow" class="row">
        <div class="col-md-9 col-xs-10 mycol">
            <div class="input-group date form_date" data-date="" data-date-format="yyyy mm" data-link-field="dtp_input2" data-link-format="yyyy-mm">
                <input class="form-control" size="16" readonly/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            <input type="hidden" id="dtp_input2" value="" name="month"/>
        </div>
        <div class="col-md-3 col-xs-2 mycol">
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
                                            <a href="/admin/operation/manage.html?month=<?php echo $recent_date; ?> "><?php echo $recent_date; ?></a>
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
<script type="text/javascript" src="/static/js/bootstrap-datetimepicker.min.js"></script> <script type="text/javascript" src="/static/js/bootstrap-datetimepicker.zh-CN.js"></script> <script type="text/javascript" src="/static/js/admin_manage.js"></script>

</html>