<?php
/**
 * Created by PhpStorm.
 * User: yantao
 * Date: 2019-01-10
 * Time: 15:28
 */

namespace app\admin\controller;

use app\common\controller\AdminController;

class Brand extends AdminController
{
    /**
     * 删除品牌
     */
    public function del()
    {
        $id = input('param.id');
        $res = model('brand')
            ->where('id',$id)
            ->delete();

        return $res ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 执行修改
     */
    public function usave()
    {
        $id = input('param.id');
        $cid = input('param.cid');
        $bname= input('param.bname');
        $file = request()->file('upload');

        if ($file) {
            $path = ROOT_PATH . "public/static/upload";
            $info = $file
                ->validate([
                    'size' => 2048000,
                    'ext' => 'jpg,png,gif,jpeg',
                ])
                ->move($path);
            if (is_object($info) && $info->getSaveName()) {
                $path = $info->getSaveName();
                $res = model('brand')
                    ->where('id', $id)
                    ->update([
                        'cid' => $cid,
                        'bname' => $bname,
                        'logo' => $path,
                    ]);
            }else{
                return $this->error('logo上传失败');
            }
        } else {
            $res = model('brand')
                ->where('id', $id)
                ->update([
                    'cid' => $cid,
                    'bname' => $bname,
                ]);
        }
        return $res ? $this->success('修改成功') : $this->error('修改失败');
    }

    /**
     * 修改品牌
     */
    public function update()
    {
        $id = input('param.id');
        $category = model('category')
            ->select();
        $col = model('brand')
            ->where('id',$id)
            ->find();
        $this->assign('category',$category);
        $this->assign('col',$col);
        return $this->fetch();
    }

    /**
     * 执行添加
     */
    public function save()
    {
        $cid = input('param.cid');
        $bname = input('param.bname');
        $file = request()->file('upload');

        $path = ROOT_PATH . "public/static/upload";
        $info = $file
            ->validate([
                'size' => 2048000,
                'ext' => 'jpg,png,gif,jpeg',
            ])
            ->move($path);
        if (is_object($info) && $info->getSaveName()) {
            $path = $info->getSaveName();
            $res  = model('brand')
                ->save([
                    'cid' => $cid,
                    'bname' => $bname,
                    'logo' => $path,
                ]);
            return $res ? $this->success('添加成功') : $this->error('添加失败');
        }else{
            return $this->error('logo上传失败');
        }
    }

    /**
     * 添加品牌
     */
    public function add()
    {
        $category = model('category')
            ->select();
        $this->assign('category',$category);
        return $this->fetch();
    }

    /**
     * 品牌首页
     */
    public function index()
    {
        $brand = model('brand')
            ->select();
        $this->assign('brand', $brand);
        return $this->fetch();
    }
}