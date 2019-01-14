<?php
/**
 * Created by PhpStorm.
 * User: yantao
 * Date: 2019-01-08
 * Time: 17:01
 */

namespace app\common\controller;

use think\Controller;

class AdminController extends Controller
{
    public function _initialize()
    {
        if (!session('?admin')) {
            $this->redirect(url('admin/user/login'));
        }
    }
}