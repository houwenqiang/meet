<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

use app\common\model\Part;
use app\common\model\Cate;

class PartController extends Controller
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
        //$pinfo = Part::select(); 
        $arr = []; 
        $name = $request -> get('name');
        $arr[] = ['name','like',"%{$name}%"];
    
        $pinfo = Part::where($arr)-> paginate(3) -> appends($request -> get());
        $pageStr = $pinfo -> render(); 
        
        return view('part/plist',['pinfo' => $pinfo, 'pageStr' => $pageStr]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
        return view('part/create');
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
        $pinfo = $request -> post();
        //dump($pinfo);
        try{
            Part::create($pinfo,true);
        }catch(\Exception $e){
            return $this -> error('分区添加失败');
        }
        $this -> success('分区添加成功');
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
        $pinfo = Part::get($pid);
        return view('part/edit',['pinfo' => $pinfo]);
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
        Part::where('id',$pid) -> update($pinfo);
        $this -> success('分区修改成功','/part/plist');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function del($pid)
    {
        // //
        $arrpid = Cate::table('bbs_cate') -> column('pid');
        if(!in_array($pid,$arrpid)){
            Part::destroy($pid);
            $this -> success('分区删除成功');
        }else{
            $this -> error('该分区存在板块，删除失败');
        }     
    }
     public function delete(Request $request)
    {
		if(!empty($request -> post()['id'])){
			$pid = $request -> post()['id'];
			foreach($pid as $k => $v){
				$arr = Cate::where('pid','=',$v) -> select();
				$cates = Count($arr);
				if(!$cates){
					Part::destroy($v); 
				}
			}
			$this -> success('没有板块的分区删除成功');
		}else{
			$this -> error('请选择要删除的选项');
		}  
    }
}
