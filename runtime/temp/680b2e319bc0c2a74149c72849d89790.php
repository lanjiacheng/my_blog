<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:65:"/var/www/my_blog/public/../application/index/view/index/post.html";i:1524975511;s:22:"static/model/head.html";i:1524975511;s:21:"static/model/nav.html";i:1524975511;s:30:"static/model/post_content.html";i:1524975511;s:27:"static/model/other_bar.html";i:1524975511;s:32:"static/model/calendar_input.html";i:1524975511;s:24:"static/model/footer.html";i:1524975511;}*/ ?>
<!DOCTYPE html>
<html lang="en">
		<!-- 头文件 -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/static/images/tag_icon.png">
    <link rel="shortcut" href="/static/images/tag_icon.png" />
    <link rel="bookmark" href="/static/images/tag_icon.png" />
    <title>LJC的博客</title>
    <link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css" /><link rel="stylesheet" type="text/css" href="/static/css/jquery.bxslider.css" /><link rel="stylesheet" type="text/css" href="/static/css/style.css" /> <link rel="stylesheet" type="text/css" href="/static/css/mystyle.css" />
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
</head>
	<body>
		<!-- Navigation -->
		<!-- 导航栏 -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <!-- 以下是添加导航栏logo -->
            <!-- <a class="navbar-brand" href="#">
                <img alt="Brand" src="/static/images/logo.png">
            </a> -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
                aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/index/index/index.html" style="padding:10px 10px">
                <img style="width: 30px;height: auto;" src="/static/images/nav_icon.png" />
            </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="<?php echo (isset($class_of_nav_item_home) && ($class_of_nav_item_home !== '')?$class_of_nav_item_home:" "); ?>">
                    <a href="/index/index/index.html">首页</a>
                </li>
                <li class="<?php echo (isset($class_of_nav_item_diary) && ($class_of_nav_item_diary !== '')?$class_of_nav_item_diary:" "); ?>">
                    <a href="/index/index/category.html?category=diary">日记</a>
                </li>
                <li class="<?php echo (isset($class_of_nav_item_footprint) && ($class_of_nav_item_footprint !== '')?$class_of_nav_item_footprint:" "); ?>">
                    <a href="/index/index/category.html?category=footprint">足迹</a>
                </li>
                <li class="<?php echo (isset($class_of_nav_item_programme) && ($class_of_nav_item_programme !== '')?$class_of_nav_item_programme:" "); ?>">
                    <a href="/index/index/category.html?category=programme">编程</a>
                </li>
                <li class="<?php echo (isset($class_of_nav_item_thought) && ($class_of_nav_item_thought !== '')?$class_of_nav_item_thought:" "); ?>">
                    <a href="/index/index/category.html?category=thought">杂谈</a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <!-- <li>
                    <a href="#">
                        <i class="fa fa-reddit"></i>
                    </a>
                </li> -->
            </ul>

        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
		<div class="container">
		<header>
			<a href="index.html"><img src="/static/images/logo.png"></a>
		</header>
		<section>
			<div class="row">
				<div class="col-md-8">
					<!-- 此处添加post_content.html文件 -->
					<!-- 博文内容模板 -->
<article class="blog-post">
    <div class="blog-post-image">
            <img src="/static/images/<?php echo $post['timestamp']; ?>/image_preview.jpg" alt="">
    </div>
    <div class="blog-post-body">
        <h2>
            <span><?php echo $post['title']; ?></span>
        </h2>
        <div class="post-meta">
            <span>作者：<a href="/index/index/author.html"><?php echo $post['author']; ?></a>
            </span>/
            <span>
                <i class="fa fa-clock-o"></i><?php echo $post['create_date']; ?></span>/
            <span>
                <i class="fa fa-eye"></i>
                <span><?php echo $post['post_click_count']; ?></span>
            </span>
        </div>
        <div class="blog-post-text">
            <!-- 
            按以下格式可以控制博文内容板式
            <p>这里是一段</p>
            <p>这里是一段</p>
            <h3>小标题</h3>
            <p>这里是一段</p>
            <img src="/static/images/test_01.jpg" alt="这里放图片">
            <p>这里是一段</p>
            -->
            <?php echo $post['content']; ?>
        </div>
    </div>
</article>
				</div>
				<div class="col-md-4 sidebar-gutter">
					<aside>
						<!-- 此处添加other_bar.html文件，以显示其他版块内容 -->
						<!-- 其他版块文件，包括博主简介、推荐博文、分时间分类等 -->
<div class="sidebar-widget">
    <h3 class="sidebar-title">博主简介</h3>
    <div class="widget-container widget-about">
        <a href="/index/index/author.html">
            <img src="/static/images/image_author.jpg" alt="">
        </a>
        <h4>
            <a href="/index/index/author.html"><?php echo $author['name']; ?></a>
        </h4>
        <div class="author-title"><?php echo $author['label']; ?></div>
        <p><?php echo $author['introduction_preview']; ?></p>
    </div>
</div>
<!-- sidebar-widget -->
<div class="sidebar-widget">
    <h3 class="sidebar-title">推荐博文</h3>
    <div class="widget-container">
        <?php if(is_array($recommended_posts) || $recommended_posts instanceof \think\Collection || $recommended_posts instanceof \think\Paginator): $i = 0; $__LIST__ = $recommended_posts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$recommended_post): $mod = ($i % 2 );++$i;?>
        <article class="widget-post">
            <div class="post-image">
                <a href="/index/index/post.html?post_id=<?php echo $recommended_post['id']; ?>">
                    <img src="/static/images/<?php echo $recommended_post['timestamp']; ?>/image_preview.jpg" alt="">
                </a>
            </div>
            <div class="post-body">
                <h2>
                    <a href="/index/index/post.html?post_id=<?php echo $recommended_post['id']; ?>"><?php echo $recommended_post['title']; ?></a>
                </h2>
                <div class="post-meta">
                    <span>
                        <i class="fa fa-clock-o"></i> <?php echo $recommended_post['create_date']; ?></span>
                    <span>
                        <i class="fa fa-eye"></i> <?php echo $recommended_post['post_click_count']; ?>
                    </span>
                </div>
            </div>
        </article>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
<!-- sidebar-widget -->
<div class="sidebar-widget">
    <h3 class="sidebar-title">按月查找</h3>
    <div class="widget-container">
        <!-- 以下添加时间控件 -->
        <!-- <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
<!-- <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"> -->
<link rel="stylesheet" type="text/css" href="/static/css/bootstrap-datetimepicker.min.css" />
<h5>输入月份：</h5>
<form action="/index/index/category_by_month.html" class="form-horizontal" role="form">
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
        <br/>
        <h5>近期月份：</h5>
        <!-- 以下添加近期月份列表 -->
        <ul id="my_month_ul">
            <?php if(is_array($recent_months) || $recent_months instanceof \think\Collection || $recent_months instanceof \think\Paginator): $i = 0; $__LIST__ = $recent_months;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$recent_month): $mod = ($i % 2 );++$i;?>
            <li>
                <a href="/index/index/category_by_month.html?month=<?php echo $recent_month['str']; ?>"> <?php echo $recent_month['year']; ?> 年 <?php echo $recent_month['month']; ?> 月</a>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</div>
					</aside>
				</div>
			</div>
		</section>
		</div><!-- /.container -->
		<!-- 脚部 -->
<footer class="footer">

    <!-- <div class="footer-socials">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-instagram"></i></a>
        <a href="#"><i class="fa fa-google-plus"></i></a>
        <a href="#"><i class="fa fa-dribbble"></i></a>
        <a href="#"><i class="fa fa-reddit"></i></a>
    </div> -->

    <div class="footer-bottom">
        <br/>
        <br/>
        <i class="fa fa-copyright"></i> Copyright 2018 LJC All rights reserved.<br>
    </div>
</footer>
		<!-- 导入脚本文件 -->
		<script type="text/javascript" src="/static/js/jquery.min.js"></script><script type="text/javascript" src="/static/js/bootstrap.min.js"></script><script type="text/javascript" src="/static/js/jquery.bxslider.js"></script><script type="text/javascript" src="/static/js/mooz.scripts.min.js"></script>
		<script type="text/javascript" src="/static/js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="/static/js/bootstrap-datetimepicker.zh-CN.js"></script>
		<script type="text/javascript" src="/static/js/myscripts.js"></script>
	</body>
</html>