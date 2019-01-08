<?php
namespace app\admin\controller;

use think\Controller;

class Category extends Controller
{
    /**
     * 保存添加的分类
     */
    public function save()
    {
        return $this->fetch();
    }

    /**
     * 添加分类
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 分类首页
     */
    public function index()
    {
        return $this->fetch();
    }
}
