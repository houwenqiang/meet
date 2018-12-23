<?php

namespace app\common\model;

use think\Model;

class Part extends Model
{
    //
    protected $table = 'bbs_part';
    protected $pk = 'id';
    
    public function cate()
    {
    	return $this -> hasMany('Cate', 'pid');
    }
}
