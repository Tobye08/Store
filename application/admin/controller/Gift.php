<?php
/**
 * Created by PhpStorm.
 * User: yantao
 * Date: 2019-01-14
 * Time: 16:40
 */

namespace app\admin\controller;

use app\common\controller\AdminController;

class Gift extends AdminController
{
    /**
     * 删除奖品
     */
    public function del()
    {
        $id = input('param.id');
        $res = model('gift')
        ->where('id',$id)
        ->delete();

        return $res ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 执行修改
     */
    public function usave()
    {
        $args = input('param.');
        $file = request()->file('image');


        $res = model('gift')
            ->where('id', $args['id'])
            ->update($args);

        if ($file) {
            foreach ($file as $value) {
                $path = ROOT_PATH . "public/static/gift";
                $info = $value
                    ->validate([
                        'size' => 20480000000,
                        'ext' => 'jpg,png,gif,jpeg',
                    ])
                    ->move($path);
//                echo '<pre>';
//                var_dump($info);
//                exit;
                if (is_object($info) && $info->getSaveName()) {
                    $path = $info->getSaveName();
                    $re = model('gift')
                        ->where('id',$args['id'])
                        ->update([
                            'image' => $path,
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
     * 修改礼品
     */
    public function update()
    {
        $id = input('param.id');
        $col = model('gift')
            ->where('id',$id)
            ->find();
        $this->assign('col',$col);
        return $this->fetch();
    }

    /**
     * 执行添加
     */
    public function save()
    {
        $args = [
            'name' => input('param.name'),
            'num' => input('param.num'),
        ];
        $file = request()->file('image');

        $id = model('gift')
            ->insertGetId($args);

        if ($file) {
            foreach ($file as $value) {
                $path = ROOT_PATH . "public/static/gift";
                $info = $value
                    ->validate([
                        'size' => 2048000,
                        'ext' => 'jpg,png,gif,jpeg',
                    ])
                    ->move($path);
                if (is_object($info) && $info->getSaveName()) {
                    $path = $info->getSaveName();
                    model('gift')
                        ->where('id',$id)
                        ->update(['image' => $path]);
                }
            }
        }

        return $this->success('添加成功');
    }

    /**
     * 添加奖品
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 抽奖管理
     */
    public function index()
    {
        $cols = model('gift')
            ->select();

        $this->assign('cols',$cols);
        return $this->fetch();
    }
}