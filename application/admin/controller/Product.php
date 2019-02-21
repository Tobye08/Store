<?php
/**
 * Created by PhpStorm.
 * User: yantao
 * Date: 2019-01-09
 * Time: 14:00
 */

namespace app\admin\controller;

use app\common\controller\AdminController;

class Product extends AdminController
{
    /**
     * 删除产品
     */
    public function del()
    {
        $id = input('param.id');
        $res = model('product')
            ->where('id',$id)
            ->delete();

        return $res ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 删除图片
     */
    public function delImg()
    {
        $id = $_GET['imgId'];
        $res = model('productimg')
            ->where('id',$id)
            ->delete();
        if ($res) {
            return ['code'=>200,'status'=>'success','date'=>null];
        } else {
            return ['code'=>422,'status'=>'false','date'=>null];
        }
    }

    /**
     * 提交修改
     */
    public function usave()
    {
        $args = input('param.');
        $file = request()->file('image');

        $res = model('product')
            ->where('id', $args['id'])
            ->update($args);

        if ($file) {
            foreach ($file as $value) {
                $path = ROOT_PATH . "public/static/upload";
                $info = $value
                    ->validate([
                        'size' => 2048000,
                        'ext' => 'jpg,png,gif,jpeg',
                    ])
                    ->move($path);
                if (is_object($info) && $info->getSaveName()) {
                    $path = $info->getSaveName();
                    $re = model('productimg')
                        ->insert([
                            'pid' => $args['id'],
                            'path' => $path,
                        ]);
                }
            }
        }

        if ($res) {
            return $this->success('内容修改成功');
        } elseif (isset($re)) {
            if ($re) {
                return $this->success('图片修改成功');
            } else {
                return $this->error('图片修改失败');
            }
        } else {
            return $this->error('修改失败');
        }
    }

    /**
     * 修改产品
     */
    public function update()
    {
        $id = input('param.id');

        $col = model('product')
            ->where('id', $id)
            ->find();
        $img = model('productimg')
            ->where('pid', $id)
            ->select();
        $category = model('category')
            ->select();
        $brand = model('brand')
            ->select();

        $this->assign('category', $category);
        $this->assign('brand', $brand);
        $this->assign('col', $col);
        $this->assign('img', $img);
        return $this->fetch();
    }

    /**
     * 保存产品
     */
    public function save()
    {
        $args = input('param.');
        $file = request()->file('image');

        $args['create_time'] = time();
        $args['update_time'] = time();
        $id = model('product')
            ->insertGetId($args);

        if ($file) {
            foreach ($file as $value) {
                $path = ROOT_PATH . "public/static/upload";
                $info = $value
                    ->validate([
                        'size' => 2048000,
                        'ext' => 'jpg,png,gif,jpeg',
                    ])
                    ->move($path);
                if (is_object($info) && $info->getSaveName()) {
                    $path = $info->getSaveName();
                    model('productimg')
                        ->insert([
                            'pid' => $id,
                            'path' => $path,
                        ]);
                }
            }
        }

        return $this->success('添加成功');
    }

    /**
     * 添加产品
     */
    public function add()
    {
        $category = model('category')
            ->select();
        $brand = model('brand')
            ->select();
        $this->assign('category', $category);
        $this->assign('brand', $brand);
        return $this->fetch();
    }

    /**
     * 首页
     */
    public function index()
    {
        $cols = model('product')
            ->select();
        $this->assign('cols', $cols);
        return $this->fetch();
    }
}