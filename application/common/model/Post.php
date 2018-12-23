<?php

namespace app\common\model;

use think\Model;

class Post extends Model
{
    //
    protected $table = 'bbs_post';
    protected $pk = 'id';
    
    public function user()
    {
        return $this -> belongsTo('User','uid');
    }
    
    public function reply()
    {
        return $this -> hasMany('Reply','pid');
    }
}