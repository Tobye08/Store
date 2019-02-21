<?php

namespace app\admin\controller;

use app\common\controller\AdminController;

class Category extends AdminController
{
    /**
     * 删除分类
     */
    public function del()
    {
        $id = input('param.id');
        $res = model('category')
            ->where('id', $id)
            ->delete();
        return $res ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 执行修改
     */
    public function usave()
    {
        $id = input('param.id');
        $args = [
            'pid' => input('param.pid'),
            'cname' => input('param.cname'),
        ];

        $res = model('category')
            ->where('id', $id)
            ->update($args);

        return $res ? $this->success('修改成功') : $this->error('修改失败');
    }

    /**
     * 修改分类
     */
    public function update()
    {
        $id = input('param.id');
        $col = model('category')
            ->where('id', $id)
            ->find();
        $this->assign('col', $col);
        return $this->fetch();
    }

    /**
     * 保存添加的分类
     */
    public function save()
    {
        $args = [
            'cname' => input('param.cname'),
            'pid' => input('param.pid'),
        ];

        $res = model('category')
            ->save($args);
        return $res ? $this->success('添加分类成功') : $this->error('添加分类失败');
    }

    /**
     * 添加分类
     */
    public function add()
    {
        $category = [];
        $this->assign('category', $category);
        return $this->fetch();
    }

    /**
     * 分类首页
     */
    public function index()
    {
        $category = model('category')
            ->select();
        $this->assign('category', $category);
        return $this->fetch();
    }
}
