<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\captcha\Captcha;
use app\common\model\User;

class LoginController extends Controller
{
    
    public function login()
    {
        //
        return view('login/login');
    }
    
    public function verify()
    {
        $captcha = new Captcha();
        $captcha -> imageH = 35;
        $captcha -> imageW = 120;
        $captcha -> length = 1;
        $captcha -> fontSize = 18;
        $captcha -> useCurve = true;
        $captcha -> codeSet = ('1234567890');
        return $captcha->entry(); 
    }
    
    public function dologin(Request $request)
    {
        $code = $request -> post('yzm');
        $captach = new Captcha();
        if(!$captach -> check($code)){
            $this -> error('验证码错误，请从新输入！','/admin/login');
        }
        
        $uname = $request -> post('uname');
        $pass = md5($request -> post('pass'));
        $login = User::where('uname','=',$uname) -> where('pass','=',$pass) -> find();
        //dump($login);
        if($login){
            if($login['qx'] == 2){
                session('ulogin',$login);
                //session('ulogin', true);
                $this -> success('登录成功','/admin');
            }else{
                $this -> error('没有权限登录','/admin/login');
            }
        }else{
            $this -> error('账号或密码不对','/admin/login');
        }
        
    }
   
    
    public function codeedit($aid)
    {
        //
        $uinfo = user::get($aid);
        return view('login/codeedit',['uinfo' => $uinfo]);
    }
    
    public function codeupdate(Request $request, $aid)
    {
        //
        $uinfo = user::get($aid);
        //dump($uinfo);
        $ypass = md5($request -> post('ypass'));
        $xpass = md5($request -> post('xpass'));
        if($ypass != $uinfo['pass']){
            return $this -> error('原密码不正确','/admin');  
        }else{
            $uinfo['pass'] = $xpass;
        }    
        user::where('id',$aid) -> update(['pass' => $uinfo['pass']]);
        session('ulogin', false);
        $this -> success('密码修改成功,请重新登录','/admin/login');
    }
    
    public function outlogin()
    {
        session('ulogin', false);
        $this -> success('退出成功', '/admin/login');
    }
        
}
