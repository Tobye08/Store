<?php
namespace app\admin\controller;

use think\Controller;

class User extends Controller
{
    protected $beforeActionList = [
        'checkAdmin' => ['except' => 'login,check,register,save']
    ];

    public function checkAdmin()
    {
        if (!session('?admin')) {
            return $this->redirect(url('admin/user/login'));
        }
    }

    /**
     * 执行添加管理员
     */
    public function doadd()
    {
        $phone = input('param.phone');
        $username = input('param.username');
        $password = input('param.password');
    }

    /**
     * 添加管理员
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        session('admin', null);
        return $this->redirect(url('admin/user/login'));
    }

    /**
     * 保存注册信息
     */
    public function save()
    {
        $phone = input('param.phone');
        $username = input('param.username');
        $password = input('param.password');
        $password_confirmation = input('param.password_confirmation');
        
        if ($password != $password_confirmation) {
            return $this->error('两次密码不一致');
        }

        $res = db('user')
            ->insert([
                'phone' => $phone,
                'username' => $username,
                'password' => md5($password),
            ]);

        if ($res) {
            session('admin', $username);
            return $this->success('注册成功', url('admin/index/index'));
        } else {
            return $this->error('输入错误');
        }
    }

    /**
     * 注册页面
     */
    public function register()
    {
        return $this->fetch();
    }

    /**
     * 校验登录
     */
    public function check()
    {
        $phone = input('param.phone');
        $password = md5(input('param.password'));

        if (!captcha_check(input('param.captcha'))) {
            $this->error('验证失败');
        };

        $admin = db('user')
            ->field('id,phone,username')
            ->where('phone', 'eq', $phone)
            ->where('password', 'eq', $password)
            ->where('admin', 'eq', 1)
            ->find();

        if ($admin) {
            session('admin', $admin);
            $this->redirect(url('admin/index/index'));
        } else {
            $this->error('账号或密码错误');
        }
    }

    /**
     * 登录页面
     */
    public function login()
    {
        return $this->fetch();
    }
}
