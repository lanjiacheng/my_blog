<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"/var/www/my_blog/public/../application/admin/view/operation/publish.html";i:1524975511;s:28:"static/model/admin_head.html";i:1524975511;s:27:"static/model/admin_nav.html";i:1524975511;}*/ ?>
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
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                <div>
                                    <h4>发表博文</h4>
                                </div>
                            </div>
                            <div class="col-md-8 col-xs-8">
                                <div style="float: right;">
                                    <button id="send" type="button" class="btn btn-success">
                                        <span class="glyphicon glyphicon-send"></span> 发表</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <h4>
                                <span class="label label-warning">标题</span>
                            </h4>
                            <input id="title" type="text" class="form-control post_content">
                        </li>
                        <li class="list-group-item">
                            <h4>
                                <span class="label label-warning">作者</span>
                            </h4>
                            <input id="author" type="text" class="form-control post_content">
                        </li>
                        <li class="list-group-item">
                            <h4>
                                <span class="label label-warning">预览图片</span>
                            </h4>
                            <input type="file" class="choose_image_preview">
                            <img id="image_of_preview" class="post_content" src="" />
                        </li>
                        <li class="list-group-item">
                            <h4>
                                <span class="label label-warning">分类</span>
                            </h4>
                            <form>
                                <label class="radio-inline">
                                    <input type="radio" name="category" value="diary"> 日记
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="category" value="thought"> 感想
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="category" value="footprint"> 足迹
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="category" value="programme"> 编程
                                </label>
                            </form>
                        </li>
                        <li class="list-group-item">
                            <h4>
                                <span class="label label-warning">预览文字</span>
                            </h4>
                            <textarea id="text_preview" class="post_content form-control" rows="5"></textarea>
                        </li>
                        <li id="add_btn_bar" class="list-group-item">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div style="float: right;">
                                        <button id="add_subtitle" type="button" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-bookmark"></span> 小标题</button>
                                        <button id="add_paragraph" type="button" class="btn btn btn-success">
                                            <span class="glyphicon glyphicon-align-left"></span> 段落</button>
                                        <button id="add_image" type="button" class="btn btn-info">
                                            <span class="glyphicon glyphicon-picture"></span> 图片</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="/static/js/admin_publish.js"></script>

</html>