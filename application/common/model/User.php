<?php

namespace app\common\model;

use think\Model;

class User extends Model
{
    //
    protected $table = "User";
    protected $pk = 'id';
    public function post()
    {
        return $this -> hasMany('Post','pid','id');
    }
    
    public function reply()
    {
        return $this -> hasMany('Reply','pid','id');
    }
    
}
