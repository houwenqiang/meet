<?php

namespace app\home\controller;

use think\Controller;
use think\Request;
use app\common\model\User;

class HomeLoginController extends Controller
{
    public function dologin(Request $request)
    {
        //获取用户名，密码
        $uname = $request -> post('uname');
        $pass = md5($request -> post('pass'));
        //判断是否相同
        $login = User::where('uname','=',$uname) -> where('pass','=',$pass) -> find();
        //dump($login);
        //验证
        if($login){
            session('hlogin',$login);
            //session('hlogin', true);
            $this -> success('登录成功');
            
            // if($login['qx'] == 1){
                // session('hlogin',$login);
                // //session('hlogin', true);
                // $this -> success('登录成功');
            // }else{
                // $this -> error('没有权限登录');
            // }
        }else{
            $this -> error('账号或密码不对');
        }
        
    }
    
    public function outlogin()
    {
        //关闭session
        session('hlogin', false);
       // session('winfo', false);
        $this -> success('退出成功','/');
    }
}
