<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Cate;
use app\common\model\Part;
use app\common\model\Post;

class CateController extends Controller
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
        $arr = []; 
        $pinfo = Part::select();
        $cinfo = Cate::select();
        //获取搜索条件
        $cname = $request -> get('cname');
        $arr[] = ['cname','like',"%{$cname}%"];
    
        $cinfo = Cate::where($arr)-> paginate(3) -> appends($request -> get());
        $pageStr = $cinfo -> render(); 
        
        return view('cate/clist',['cinfo' => $cinfo, 'pinfo' => $pinfo,'pageStr' => $pageStr]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
        $pinfo = Part::select();
        //dump($pinfo);
        return view('cate/create',['pinfo' => $pinfo]);
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
        $cinfo = $request -> post();
        //dump($cinfo);
        try{
            Cate::create($cinfo,true);
        }catch(\Exception $e){
            return $this -> error('板块添加失败');
        }
        $this -> success('板块添加成功','/cate/clist');
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
    public function edit($cid)
    {
        //
        $cinfo = Cate::get($cid);
        $pinfo = Part::select();
        return view('cate/edit',['cinfo' => $cinfo,'pinfo' => $pinfo]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $cid)
    {
        //
        $cinfo = $request -> post();
        Cate::where('id',$cid) -> update($cinfo);
        $this -> success('板块修改成功','/cate/clist');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
   
   public function del($cid)
    {
        // //
        $arrpid = Post::table('bbs_post') -> column('cid');
        if(!in_array($cid,$arrpid)){
            Cate::destroy($cid);
            $this -> success('板块删除成功');
        }else{
            $this -> error('该板块存在帖子，删除失败');
        }     
    }
     public function delete(Request $request)
    {
		if(!empty($request -> post()['id'])){
			$cid = $request -> post()['id'];
			foreach($cid as $k => $v){
				$arr = Post::where('cid','=',$v) -> select();
				$posts = Count($arr);
				if(!$posts){
					Cate::destroy($v); 
				}
			}
			$this -> success('没有帖子的板块删除成功');
		}else{
			$this -> error('请选择要删除的选项','/part/plist');
		}  
    }
    
}
