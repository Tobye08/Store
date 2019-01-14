<?php
namespace app\admin\controller;

use app\common\controller\AdminController;

class Index extends AdminController
{
    public function index()
    {
        return $this->fetch();
    }
}
