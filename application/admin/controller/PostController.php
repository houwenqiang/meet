<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Post;
use app\common\model\Cate;
use app\common\model\User;

class PostController extends Controller
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
        $cinfo = Cate::select(); 
        $uinfo = User::select(); 
        
        $arr = [];
        //按标题查询
        if($request -> get('search-sort') == 'title'){
            $title = $request -> get('keywords');
            $arr[] = ['title','like',"%{$title}%"];
        }
        //按内容搜索
        if($request -> get('search-sort') == 'content'){
            $content = $request -> get('keywords');
            $arr[] = ['content','like',"%{$content}%"];
        }
        $pinfo = Post::where($arr) -> paginate(5) -> appends($request -> get());
        $pageStr = $pinfo -> render(); 
        

        return view('post/post',['uinfo' => $uinfo,'cinfo' => $cinfo,'pinfo' => $pinfo, 'pageStr' => $pageStr]);
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
    public function edit($pid)
    {
        //
        $pinfo = Post::get($pid);
        $cinfo = Cate::select();
        return view('post/pedit',['pinfo' => $pinfo, 'cinfo' => $cinfo]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $pid)
    {
        //
        $pinfo = $request -> post();

        Post::where('id',$pid) -> update($pinfo);
        $this -> success('主贴修改成功','/post/post');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete(Request $request,$pid)
    {
        //
        if($dele = $request -> post()){
        $pid = $dele['id'];
        }
        if(Post::destroy($pid)){
            $this -> success('主贴删除成功');
        }else {
            $this -> error('主贴删除失败');
        }
    }
}
