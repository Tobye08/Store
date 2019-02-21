<?php
/**
 * Created by PhpStorm.
 * User: yantao
 * Date: 2019-01-09
 * Time: 10:10
 */

namespace app\admin\model;

use think\Model;

class Category extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
}