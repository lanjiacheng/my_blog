<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\wamp\www\my_blog\public/../application/admin\view\overview\signin.html";i:1524802110;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> <link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css" /><link rel="stylesheet" type="text/css" href="/static/css/admin_mystyle.css" /> <script type="text/javascript" src="/static/js/jquery.min.js"></script><script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
    <title>登录博客管理系统</title>
</head>

<body>
    <br/>
    <form class="form-horizontal" action="/admin/overview/handle_signin.html" method="GET">
        <div class="form-group">
            <div class="col-md-offset-4 col-md-4">
                <input class="form-control" id="inputEmail3" name="account" placeholder="账号">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-4 col-md-4">
                <input type="password" class="form-control" id="inputPassword3" name="password" placeholder="密码">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-4 col-md-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember_password" value="yes">记住密码
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-4 col-md-4">
                <button type="submit" class="btn btn-success">Sign in</button>
            </div>
        </div>
    </form>
</body>

</html>