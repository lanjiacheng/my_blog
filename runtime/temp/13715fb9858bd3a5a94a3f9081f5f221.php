<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:70:"D:\wamp\www\my_blog\public/../application/index\view\index\author.html";i:1523862580;s:22:"static/model/head.html";i:1524833424;s:21:"static/model/nav.html";i:1524831987;s:24:"static/model/footer.html";i:1524009893;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
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
			<img src="/static/images/logo.png">
		</header>
		<section>
			<div class="row">
				<div class="col-md-12">
					<article class="blog-post">
						<div class="blog-post-body">
							<h2>
								<?php echo $author['introduction_title']; ?>
							</h2>
							<div class="blog-post-text">
								<?php echo $author['introduction_content']; ?>
								<!-- 
									介绍内容可按以下格式来控制板式：
									<p>段落一</p>
									<p>段落二</p>
									<h3>小标题</h3>
									<p>段落三</p>
									<p>段落四</p> 
								-->
							</div>
						</div>
					</article>
				</div>
			</div>
		</section>
	</div>
	<!-- /.container -->

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
	<!-- 导入脚本 -->
	<script type="text/javascript" src="/static/js/jquery.min.js"></script><script type="text/javascript" src="/static/js/bootstrap.min.js"></script><script type="text/javascript" src="/static/js/jquery.bxslider.js"></script><script type="text/javascript" src="/static/js/mooz.scripts.min.js"></script>
</body>

</html>