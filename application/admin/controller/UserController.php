<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\User;
use app\common\model\Post;
use app\common\model\Reply;

class UserController extends Controller
{
    public function __construct()
    {
        if (empty(session('ulogin'))) {
            $this -> error('请先登录', '/admin/login');
        }
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        //$uinfo = User::select();        
        /* 
        $uinfo = User::paginate(3);
        $pageStr = $uinfo -> render();
        $this -> assign('uinfo',$uinfo); 
        */
            $arr = [];  
            $qx = [];         
        //获取搜索权限条件           
            $qx = $request -> get('qx');
            if($qx == '管理员'){
                 $qx = 2;
            }else if($qx == '普通用户'){
                 $qx = 1;
            }
            $qx = ['qx','=',$qx];
        //按用户名搜索
            if($request -> get('search-sort') == 'uname'){
                $uname = $request -> get('keywords');
                $arr[] = [$qx,['uname','like',"%{$uname}%"]];
            }
        //按性别搜索
            if($request -> get('search-sort') == 'sex'){
                $sex = $request -> get('keywords');
                if($sex == '男'){
                    $sex = 'm';
                }else if($sex == '女'){
                    $sex = 'w';
                }
            $arr[] = [$qx,['sex','like',"%{$sex}%"]];
            }
        //按年龄搜索
            if($request -> get('search-sort') == 'age'){
                $age = $request -> get('keywords');
                $arr[] = [$qx,['age','like',"%{$age}%"]];
            }
        //按手机号搜索
            if($request -> get('search-sort') == 'tel'){
                $tel = $request -> get('keywords');
                $arr[] = [$qx,['tel','like',"%{$tel}%"]];
            }
            
        //按权限搜索
        // if($request -> get('search-sort') == 'qx'){
            // $qx = $request -> get('keywords');
            // if($qx == '管理员'){
                // $qx = 2;
            // }else if($qx == '普通用户'){
                // $qx = 1;
            // }
            // $arr[] = ['qx','=',$qx];
        // }
        //按用户名搜索
        // if($request -> get('search-sort') == 'uname'){
            // $uname = $request -> get('keywords');
            // $arr[] = ['uname','like',"%{$uname}%"];
        // }
        //按性别搜索
        // if($request -> get('search-sort') == 'sex'){
            // $sex = $request -> get('keywords');
             // if($sex == '男'){
                // $sex = 'm';
            // }else if($sex == '女'){
                // $sex = 'w';
            // }
            // $arr[] = ['sex','like',"%{$sex}%"];
        // }
        //按年龄搜索
        // if($request -> get('search-sort') == 'age'){
            // $age = $request -> get('keywords');
            // $arr[] = ['age','like',"%{$age}%"];
        // }
        //按手机号搜索
        // if($request -> get('search-sort') == 'tel'){
            // $tel = $request -> get('keywords');
            // $arr[] = ['tel','like',"%{$tel}%"];
        // }
        //$uinfo = User::where($arr) -> select();
        
        $uinfo = User::where($arr)-> paginate(5) -> appends($request -> get());
        $pageStr = $uinfo -> render(); 
        
        return view('user/ulist',['uinfo' => $uinfo, 'pageStr' => $pageStr]);
         
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
        return view('user/create');
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
        //用户名验证
        if(!preg_match('/^\w{4,16}$/',$uinfo['uname'])){
            return $this -> error('用户名只能由4到16位的字母数字下划线组成'); 
        }
        //年龄验证
        if($uinfo['age'] > 80){
            return $this -> error('用户年龄80以下'); 
        }
        //密码验证
        if(!preg_match('/^\w{4,16}$/',$uinfo['pass'])){
            return $this -> error('密码能由4到16位的字母数字下划线组成'); 
        }
        //密码加密
        $uinfo['pass'] = md5($uinfo['pass']);
        //手机号验证
        if (!preg_match('/^1[3456789](\d){9}$/',$uinfo['tel'])){
            return $this ->error('请输入正确的手机号');
        }
        $uinfo['rtime'] = time();
        
        $uinfo['rip'] = ip2long($_SERVER['REMOTE_ADDR']);
        
        if($request -> file('pic')){
            $file  = $request -> file('pic');
            $info = $file -> move('./static/images/user_img');
            $uinfo['pic'] = $info -> getSaveName();
        }


        try{
            User::create($uinfo,true);
        }catch(\Exception $e){
            return $this -> error('用户添加失败');
        }
        $this -> success('用户添加成功');
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
    public function edit($uid)
    {
        //
        $uinfo = user::get($uid);
        return view('user/edit',['uinfo' => $uinfo]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $uid)
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
        }
         
      
        user::where('id',$uid) -> update($uinfo);
        $this -> success('用户修改成功','/user/ulist');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($uid)
    {
        //dump($uid);
        $post = Post::where('uid','=',$uid) -> select();
        $reply = Reply::where('uid','=',$uid) -> select();
        //dump($post);
        if(User::destroy($uid)){
            if(count($post) != 0){
                foreach($post as $k => $v){
                    $pid[] = $v['id'];
                    Post::destroy($pid);
                }
            }
            if(count($reply) != 0){
                foreach($reply as $k => $v){
                    $rid[] = $v['id'];
                    Reply::destroy($rid);
                }
            }
            $this -> success('用户删除成功');
        }else{
            $this -> error('用户删除失败');
        }
        //if($dele = $request -> post()){
        //$uid = $dele['id'];;
        // if(user::destroy($uid)){
            // $this -> success('用户删除成功');
        // }else{
            // $this -> error('用户删除失败');
        // }
    }
      
    public function del(Request $request)
    {
        if(!empty($request -> post()['id'])){
            $uid = $request -> post()['id'];
        
            foreach($uid as $k => $v){
               User::where('id','=',$v) -> delete(); 
               Post::where('uid','=',$v) -> delete(); 
               Reply::where('uid','=',$v) -> delete(); 
                $this -> success('用户删除成功');
            }
        }
        else{
             $this -> error('用户删除失败');
         }
    }
}
