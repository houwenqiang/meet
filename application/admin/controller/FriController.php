<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

use app\common\model\Fri;

class FriController extends Controller
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
        $arr = [];
        //按标题搜索
        if($request -> get('search-sort') == 'title'){
            $title = $request -> get('keywords');
            $arr[] = ['title','like',"%{$title}%"];
        }
        //按描述搜索
        if($request -> get('search-sort') == 'descript'){
            $descript = $request -> get('keywords');
            $arr[] = ['descript','like',"%{$descript}%"];
        }
        //按链接地址搜索
        if($request -> get('search-sort') == 'url'){
            $url = $request -> get('keywords');
            $arr[] = ['url','like',"%{$url}%"];
        }
        //分页
        $finfo = Fri::where($arr) -> paginate(5) -> appends($request -> get());
        $pageStr = $finfo -> render(); 
        
        return view('fri/flist',['finfo' => $finfo, 'pageStr' => $pageStr]);        
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
        return view('fri/fcreate');
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
        $finfo = $request -> post();
        //dump($finfo);
        
        if(!preg_match('/^(w){3}(\.\w+){1,3}$/',$finfo['url'])){
            return $this -> error('链接地址格式不正确'); 
        }
        if($request -> file('pic')){
            $file  = $request -> file('pic');
            $info = $file -> move('./static/images/Url_img/');
            $finfo['pic'] = $info -> getSaveName();
        }
        
        
        try{
            Fri::create($finfo,true);
        }catch (\Exception $e){
            return $this -> error('添加链接失败');
        }
        $this -> success('添加链接成功');
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
    public function edit($fid)
    {
        //
        $finfo = fri::get($fid);
        return view('fri/fedit',['finfo' => $finfo]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $fid)
    {
        //
        $finfo = $request -> post();
        //dump($finfo);
        
        if(!preg_match('/^(w){3}(\.\w+){1,3}$/',$finfo['url'])){
            return $this -> error('链接地址格式不正确'); 
        }
        
        if($request -> file('pic')){
            $file  = $request -> file('pic');
            $info = $file -> move('./static/images/Url_img/');
            $finfo['pic'] = $info -> getSaveName();   
        }
        

        fri::where('id',$fid) -> update($finfo);
        $this -> success('链接修改成功','/fri/flist');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete(Request $request,$fid)
    {
        //
        //dump($fid);
        if($dele = $request -> post()){
        $fid = $dele['id'];
        }
        if(fri::destroy($fid)){
            $this -> success('链接删除成功');
        }else {
            $this -> erroe('链接删除失败');
        }
    }
}
