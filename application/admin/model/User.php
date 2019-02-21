<?php

namespace app\admin\model;

use think\Model;

class User extends Model
{
    public function getUser()
    {
        return $this->field('*')
            ->where('admin','eq',1)
            ->select();
    }

    public function addAdmin($args)
    {
        return $this->save($args);
    }

    protected $autoWriteTimestamp = 'datetima';
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
}