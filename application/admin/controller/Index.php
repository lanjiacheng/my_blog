<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\controller\Overview;

class Index extends Controller
{
    public function index()
    {
        if (empty($_COOKIE['account']) || empty($_COOKIE['password'])) {                 //如果账号或密码为空
            $this->error('进入管理系统请先登录', '/admin/signin/signin.html', 3);               //跳转到登录界面
        } else {
            $this->success('欢迎进入乐中悲の博客管理系统', '/admin/overview/day.html', 3);
        }
    }
}