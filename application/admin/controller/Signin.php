<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Signin extends Controller
{

    //显示登录界面
    public function signin()
    {
        return $this->fetch("signin");
    }
    
    //处理登录请求方法
    public function handle_signin()
    {
        $accounts = Db::query("select * from admin_account where account = '" . $_GET["account"] . "'");
        if (count($accounts) > 0) {
            $account = $accounts[0]["account"];
            $password = $accounts[0]["password"];
            if ($_GET["password"] == $password) {
                if (!empty($_GET["remember_password"])) {                                      //如果勾选了记住密码
                    setcookie('account', $account, time() + (3600 * 24 * 3), "/admin/");             //记住密码3天
                    setcookie('password', $password, time() + (3600 * 24 * 3), "/admin/");
                } else {
                    setcookie('account', $account, time() + 3600, "/admin/");             //记住密码1小时
                    setcookie('password', $password, time() + 3600, "/admin/");
                }
                $this->success('登陆成功', '/admin/overview/day.html', 3);
            } else {
                $this->error('账号或密码错误', '/admin/signin/signin.html', 3);
            }
        } else {
            $this->error('账号或密码错误', '/admin/signin/signin.html', 3);
        }
    }

    //处理退出登录请求的方法
    public function handle_signout()
    {
        setcookie('account', "", time() - 3600, "/admin/");             //删除账号密码信息
        setcookie('password', "", time() - 3600, "/admin/");
        $this->success('退出成功', '/admin/signin/signin.html', 3);
    }
}