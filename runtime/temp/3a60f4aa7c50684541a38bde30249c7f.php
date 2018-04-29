<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:69:"D:\wamp\www\my_blog\public/../application/index\view\index\index.html";i:1523962504;s:22:"static/model/head.html";i:1524927514;s:21:"static/model/nav.html";i:1524927514;s:24:"static/model/slider.html";i:1524927514;s:30:"static/model/post_preview.html";i:1524987753;s:27:"static/model/other_bar.html";i:1524991963;s:32:"static/model/calendar_input.html";i:1524927514;s:24:"static/model/footer.html";i:1524927514;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<!-- 此处添加头文件 -->
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
	<!-- 此处添加nav.html文件，以显示导航栏 -->
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
			<a href="index.html">
				<img src="/static/images/logo.png">
			</a>
		</header>
		<!-- 添加滑动图片 -->
		<!-- 滑动图片 -->
<section class="main-slider">
    <ul class="bxslider">
        <?php if(is_array($top_posts) || $top_posts instanceof \think\Collection || $top_posts instanceof \think\Paginator): $i = 0; $__LIST__ = $top_posts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$top_post): $mod = ($i % 2 );++$i;?>
        <li>
            <div class="slider-item">
                <a href="/index/index/post.html?post_id=<?php echo $top_post['id']; ?>">
                    <!-- 建议此处添加比例为5:2的图片 -->
                    <img src="/static/images/<?php echo $top_post['timestamp']; ?>/image_preview.jpg" title="<?php echo $top_post['title']; ?>" />
                </a>
                <h2>
                    <a href="/index/index/post.html?post_id=<?php echo $top_post['id']; ?>" title="<?php echo $top_post['title']; ?>"><?php echo $top_post['title']; ?></a>
                </h2>
            </div>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</section>
		<section>
			<div class="row">
				<div class="col-md-8">
					<!-- 此处添加post_preview.html文件，以展示多个博文预览 -->
					<!-- 多个博文预览部分 -->
<!-- 
    引用本模板需要赋值的变量：
    posts           一个包含多个博文的二维数组
 -->
<?php if(is_array($posts) || $posts instanceof \think\Collection || $posts instanceof \think\Paginator): $i = 0; $__LIST__ = $posts;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$post): $mod = ($i % 2 );++$i;?>
<article class="blog-post">
    <div class="blog-post-image">
        <a href="/index/index/post.html?post_id=<?php echo $post['id']; ?>">
            <!-- 建议添加9:6比例的图片 -->
            <img src="/static/images/<?php echo $post['timestamp']; ?>/image_preview.jpg" alt="">
        </a>
    </div>
    <div class="blog-post-body">
        <h2>
            <a href="/index/index/post.html?post_id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a>
        </h2>
        <div class="post-meta">
            <span>作者：
                <a href="/index/index/author.html"><?php echo $post['author']; ?></a>
            </span>/
            <span>
                <i class="fa fa-clock-o"></i><?php echo $post['create_date']; ?></span>/
            <span>
                <!-- <i class="fa fa-comment-o"></i> -->
                <i class="fa fa-eye" aria-hidden="true"></i>
                <!-- <span class="glyphicon glyphicon-eye-open"></span> -->
                <a href="#"><?php echo $post['post_click_count']; ?></a>
            </span>
        </div>
        <p><?php echo $post['preview']; ?></p>
        <div class="read-more">
            <a href="/index/index/post.html?post_id=<?php echo $post['id']; ?>">继续阅读</a>
        </div>
    </div>
</article>
<?php endforeach; endif; else: echo "$empty" ;endif; ?>
					<div class="pagediv">
							<?php echo $posts->render(); ?>
					</div>
				</div>
				<!-- <div class="copyrights">Collect from <a href="http://www.cssmoban.com/" >企业网站模板</a></div> -->
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
                <span class="glyphicon glyphicon-calendar" style="margin-left: 5px;"></span>
                <a href="/index/index/category_by_month.html?month=<?php echo $recent_month['str']; ?>" style="float: right;margin-right: 15px;"><?php echo $recent_month['year']; ?> 年 <?php echo $recent_month['month']; ?> 月</a>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</div>
					</aside>
				</div>
			</div>
		</section>
	</div>
	<!-- /.container -->
	<!-- 添加底部板块 -->
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
<!-- 
	总结一下thinkphp框架中资源的引用：
	一般资源放在/$projectRootDir/public/static/目录
	不同属性有不同引用方式：
	{ include }标签中的file属性用：static/...
	{ load }标签中的href属性用：/static/...
	< img >标签中的src属性用：/static/...
 -->