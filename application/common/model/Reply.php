<?php

namespace app\common\model;

use think\Model;

class Reply extends Model
{
    //
    protected $table = 'bbs_reply';
    protected $pk = 'id';
    
    public function user()
    {
        return $this -> belongsTo('User','uid');
    }
    
     public function post()
    {
        return $this -> belongsTo('Post','pid');
    }
}
