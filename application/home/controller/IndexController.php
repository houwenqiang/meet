<?php

namespace app\home\controller;

use think\Controller;
use think\Request;

use app\common\model\Part;
use app\common\model\Cate;
use app\common\model\Fri;
use app\common\model\Web;
use app\common\model\User;
use app\common\model\Post;

class IndexController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        //
        $pinfo = Part::select();
        $cinfo = Cate::select();
        $finfo = Fri::select();
        $winfo = Web::get(1);
        //session('winfo',$winfo);
        
        //搜索设置
        //$arr = []; 
        //$search = Post::where($arr)-> appends($request -> get());
        //dump($);
        return view('index/index',['pinfo' => $pinfo, 'cinfo' => $cinfo, 'finfo' => $finfo,'winfo' => $winfo]);
    }
    
    public function search(Request $request)
    {
        //
        $winfo = Web::find();
        $uinfo = User::select();
        
        $arr = []; 
        $title = $request -> get('search');
        $arr[] = ['title','like',"%{$title}%"];
        
        $searchinfo = Post::where($arr)-> paginate(1) -> appends($request -> get());
        $pageStr = $searchinfo -> render(); 
        
        //dump($searchinfo);
        //dump($arr);
        return view('search/list',['uinfo' => $uinfo,'winfo' => $winfo,'searchinfo' => $searchinfo, 'pageStr' => $pageStr]);
    }

    /**s
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
        $finfo = Fri::select();
        
        
        $winfo = Web::get(1);
      //  $winfo = Web::find();
        return view('/useredit/login',['finfo' => $finfo,'winfo'=> $winfo]);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
        $uinfo = $request -> post();
        
        if(!preg_match('/^\w{4,16}$/',$uinfo['uname'])){
            return $this -> error('用户名只能由4到16位的字母数字下划线组成'); 
        }
      
        if(!preg_match('/^\w{4,16}$/',$uinfo['pass'])){
            return $this -> error('密码能由4到16位的字母数字下划线组成'); 
        }
        
        $uinfo['pass'] = md5($uinfo['pass']);
        
        if (!preg_match('/^1[3456789](\d){9}$/',$uinfo['tel'])){
            return $this ->error('请输入正确的手机号');
        }
        $uinfo['rtime'] = time();
        $uinfo['qx'] = 1;
        
        $uinfo['rip'] = ip2long($_SERVER['REMOTE_ADDR']);
        
        try{
            User::create($uinfo,true);
        }catch(\Exception $e){
            return $this -> error('用户注册失败');
        }
        $this -> success('用户注册成功，请登录','/');
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($yid)
    {
        //
        $uinfo = user::get($yid);
        $finfo = Fri::select();
        $winfo = Web::find();
        //dump($uinfo);
        return view('useredit/edit',['winfo' => $winfo,'uinfo' => $uinfo, 'finfo' => $finfo]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $yid)
    {
        //
        $uinfo = $request -> post();
        //dump($uinfo);
        //验证
        if(!preg_match('/^\w{4,16}$/',$uinfo['uname'])){
            return $this -> error('用户名只能由4到16位的字母数字下划线组成'); 
        }
        if($uinfo['age'] > 80){
            return $this -> error('用户年龄80以下'); 
        }
        
        
        if (!preg_match('/^1[345678](\d){9}$/',$uinfo['tel'])){
            return $this ->error('请输入正确的手机号');
        }
        
        if($request -> file('pic')){
            $file  = $request -> file('pic');
            $info = $file -> move('./static/images/user_img');
            $uinfo['pic'] = $info -> getSaveName();
            session('hlogin')['pic'] = $uinfo['pic'];
        }
      
        user::where('id',$yid) -> update($uinfo);
        
        $this -> success('用户信息修改成功','/');
        
        
    }
    
    public function codeedit($mid)
    {
        //
        $finfo = Fri::select();
        $winfo = Web::find();
        $uinfo = user::get($mid);
        return view('useredit/codeedit',['winfo' => $winfo,'uinfo' => $uinfo,'finfo' => $finfo]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function codeupdate(Request $request, $mid)
    {
        //
        $uinfo = user::get($mid);
        //dump($uinfo);
        $ypass = md5($request -> post('ypass'));
        $xpass = md5($request -> post('xpass'));
        if($ypass != $uinfo['pass']){
            return $this -> error('原密码不正确','/');  
        }else{
            $uinfo['pass'] = $xpass;
        }    
        user::where('id',$mid) -> update(['pass' => $uinfo['pass']]);
        session('hlogin', false);
        $this -> success('密码修改成功,请重新登录','/');
        
        //验证
        //dump($uinfo);
        //dump($ypass);
        //dump($xpass);
        //user::where('id',$mid) -> update($uinfo);
        //$this -> success('密码修改成功','/');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
