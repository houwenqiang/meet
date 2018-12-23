<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Reply;
use app\common\model\Post;
use app\common\model\User;

class ReplyController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function __construct()
    {
        if (empty(session('ulogin'))) {
            $this -> error('请先登录', '/admin/login');
        }
    }
    
    public function index(Request $request)
    {
        //
        $uinfo = User::select(); 
        $pinfo = Post::select(); 
        $arr = [];
        
        $content = $request -> get('content');
        $arr[] = ['content','like',"%{$content}%"];
        
        $rinfo = Reply::where($arr) -> paginate(5) -> appends($request -> get());
        $pageStr = $rinfo -> render();
        return view('post/reply',['uinfo' => $uinfo,'pinfo' => $pinfo,'rinfo' => $rinfo, 'pageStr' => $pageStr]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
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
    public function edit($rid)
    {
        //
        $pinfo = Post::select();
        $rinfo = Reply::get($rid);
        return view('post/redit',['rinfo' => $rinfo,'pinfo' => $pinfo]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $rid)
    {
        //
        $rinfo = $request -> post();

        Reply::where('id',$rid) -> update($rinfo);
        $this -> success('链接修改成功','/post/reply');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete(Request $request,$rid)
    {
        //
        if($dele = $request -> post()){
        $rid = $dele['id'];
        }
        if(Reply::destroy($rid)){
            $this -> success('回帖删除成功');
        }else {
            $this -> error('回帖删除失败');
        }
    }
}
