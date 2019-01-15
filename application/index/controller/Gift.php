<?php
/**
 * Created by PhpStorm.
 * User: yantao
 * Date: 2019-01-14
 * Time: 17:16
 */

namespace app\index\controller;

use think\Controller;

class Gift extends Controller
{
    public function start()
    {
        $gift = $this->gift();

        return ['code' => 200, 'status' => 'success', 'data' => $gift];
    }

    public function stop()
    {
        $gift = $this->gift();

        if (!is_array($gift)) {
            return ['code' => 200, 'status' => 'success', 'data' => $gift];
            exit;
        }

        $lenth = count($gift);

        // $lenth = 奖品总数 - 想要的次数 + 1
        // 往后推一个 $lenth -1
        // 往前推一个 $lenth +1
        if ($lenth == 17) { // 第八次
            $yours = $gift['0'];
            model('gift')
                ->where('name', $yours)
                ->setDec('num', 1);
        } else {
            $rand = mt_rand(1, $lenth - 1);
            $yours = $gift[$rand];
            model('gift')
                ->where('name', $yours)
                ->setDec('num', 1);
        }

        return ['code' => 200, 'status' => 'success', 'data' => $yours];
    }

    private function gift()
    {
        $cols = model('gift')
            ->where('admin', 'eq', 0)
            ->select();

        $col = model('gift')
            ->where('admin', 'eq', 1)
            ->find();

        if ($col->num == 1) {
            $gift[] = $col->name;
        }

        foreach ($cols as $v) {
            for ($i = 0; $i < $v->num; $i++) {
                $gift[] = $v->name;
            }
        }

        if (!isset($gift)) {
            return '抽奖完毕';
        } else {
            return $gift;
        }
    }

    public function index()
    {
        return $this->fetch();
    }
}