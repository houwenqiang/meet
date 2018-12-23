<?php

namespace app\common\model;

use think\Model;

class Cate extends Model
{
    //
    protected $table = 'bbs_cate';
    protected $pk = 'id';
    
    public function part()
    {
    	return $this -> belongsto('part');
    }
    public function post()
    {
    	return $this -> hasMany('Post', 'cid');
    }
    
}
