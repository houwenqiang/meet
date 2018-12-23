<?php

namespace app\home\controller;

use think\Controller;
use think\Request;
use app\common\model\Fri;
use app\common\model\Post;
use app\common\model\Web;
use app\common\model\Reply;
use app\common\model\User;
use app\common\model\Str;

class TieController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index($cid)
    {
        // 
        $finfo = Fri::select();
        $uinfo = User::select();
        $poinfo = Post::select();
        $info = Post::where('id', '=' ,$cid) ->find();
        $winfo = Web::find();
        return view('tie/list',['finfo' => $finfo,'cid' => $cid,'poinfo' => $poinfo,'winfo' => $winfo,'info' => $info,'uinfo' => $uinfo]);
    }
    
    public function huilist($hcid)
    {
        //
        $finfo = Fri::select();
        $winfo = Web::find();
        //dump($hcid);
        //$prinfo = Reply:: -> select();
        
        $poinfo = Post::where('id', '=' ,$hcid) ->find();
        
        //dump($poinfo['status']);
        if($poinfo['status'] == 0){
            $this -> error('该贴被屏蔽....');
        }else{
            return view('tie/detail',['hcid' => $hcid,'finfo' => $finfo,'poinfo' => $poinfo,'winfo' => $winfo]); 
        }        
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create($cid)
    {
        //
        $winfo = Web::find();
        $finfo = Fri::select();        
        
        if(session('hlogin')){
            if((session('hlogin')['status']) == 0){
                $this -> error('不好意思，您的IP禁止发帖');     
            }else{
                return view('tie/fatie',['finfo' => $finfo,'winfo' => $winfo,'cid' => $cid]);
            }
        }else{
            $this -> error('请先登录再发帖');
        }
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request, $cid)
    {
        //
        //dump($cid);
        //exit;
        $sinfo = Str::get(1);
        
        $poinfo = $request -> post();
        $poinfo['ptime'] = time();
        $poinfo['cid'] = $cid;
        $poinfo['pip'] = ip2long($_SERVER['REMOTE_ADDR']);
        $poinfo['uid'] = session('hlogin')['id'];
        
        
        $arr[] = $request -> post('content');
        $str = $sinfo['str'];
        //dump($arr);
        //dump($str);
        foreach($arr as $v){
           $poinfo['content'] = str_replace( $str,'*',$v);
        }
        //dump($a);
        //exit;
        //dump($hlogin);
        //dump($poinfo);
        //dump($poinfo['uid']);
        //exit;
        try{
            Post::create($poinfo,true);
        }catch(\Exception $e){
            return $this -> error('发帖失败');
        }
        $this -> success('发帖成功','tie/list/'.$cid);
    }

     public function reply(Request $request, $hcid)
    {
        //
        $hinfo = $request -> post();
        //dump($hcid);
        $hinfo['ptime'] = time();
        $hinfo['pid'] = $hcid;
        $hinfo['pip'] = ip2long($_SERVER['REMOTE_ADDR']);
        $hinfo['uid'] = session('hlogin')['id'];
        
        //dump($hinfo);
        $sinfo = Str::get(1);
        
        $arr = $request -> post('content');
        $str = $sinfo['str'];
        //dump($arr);
        //dump($str);
        //foreach($arr as $v){
        $hinfo['content'] = str_replace( $str,'*',$arr);
        //}
        //exit;
        try{
            Reply::create($hinfo,true);
        }catch(\Exception $e){
            return $this -> error('回帖失败');
        }
        $this -> success('回帖成功','tie/detail/'.$hcid);
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
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
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
