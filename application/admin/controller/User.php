<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\User as UserBlog;

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
     * 删除用户
     */
    public function del()
    {
        $id = input('param.id');
        $res = model('user')
            ->where('id','eq',$id)
            ->delete();

        return $res ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 保存修改
     */
    public function usave()
    {
        $id = input('param.id');
        $password = input('param.password');
        $password_confirmation = input('param.password_confirmation');

        if ($password != $password_confirmation) {
            return $this->error('两次密码不一致');
        }

        $args = [
            'phone' => input('param.phone'),
            'username' => input('param.username'),
            'email' => input('param.email'),
        ];

        if ($password && $password_confirmation) {
            $args ['password'] = md5($password);
        }

        $res = model('user')
            ->where('id', 'eq', $id)
            ->update($args);

        return $res ? $this->success('修改成功') : $this->error('修改失败');
    }

    /**
     * 修改用户
     */
    public function update()
    {
        $id = input('param.id');
        $user = model('user')
            ->field('*')
            ->where('id', 'eq', $id)
            ->find();

        $this->assign('user', $user);
        return $this->fetch();
    }

    /**
     * 用户管理
     */
    public function oper()
    {
        $list = model('user')->getUser();
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * 执行添加管理员
     */
    public function doadd()
    {
        $args = [
            "phone" => input('param.phone'),
            "username" => input('param.username'),
            "password" => md5(input('param.password')),
            "email" => input('param.email'),
        ];

        $password_confirmation = input('param.password_confirmation');
        if ($args['password'] != $password_confirmation) {
            return $this->error('两次密码不一致');
        }

        $res = model('user')->data($args)->save();

        return $res ? $this->success('添加用户成功') : $this->error('添加用户失败');
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

        $res = model('user')
            ->save([
                'phone' => $phone,
                'username' => $username,
                'password' => md5($password),
            ]);

        $user = db('user')
            ->field('*')
            ->where('phone', 'eq', $phone)
            ->select();

        if ($res) {
            session('admin', $user);
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
            ->field('*')
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
