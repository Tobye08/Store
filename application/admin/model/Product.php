<?php
/**
 * Created by PhpStorm.
 * User: yantao
 * Date: 2019-01-09
 * Time: 14:15
 */

namespace app\admin\model;

use think\Model;

class Product extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
}