<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Web;
use app\common\model\Str;

class WebController extends Controller
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
    
    public function index()
    {
        //    
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
    public function edit()
    {
        //
        $winfo = Web::get(1);
        return view('web/web',['winfo' => $winfo]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $wid)
    {
        //
        $winfo = $request -> post();
        if($request -> file('logo')){
            $file  = $request -> file('logo');
            $info = $file -> move('./static/images/web_logo/');
            $newpath  = $info -> getSaveName();
        } else{
            $newpath  = '1.png';
        }
        $winfo['logo'] = $newpath;

        Web::where('id',$wid) -> update($winfo);
        $this -> success('修改成功','/web/web');
    }

    
    public function stredit()
    {
        //
        $sinfo = Str::get(1);
        return view('web/str',['sinfo' => $sinfo]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function strupdate(Request $request, $sid)
    {
        //
        $sinfo = $request -> post();

        Str::where('id',$sid) -> update($sinfo);
        $this -> success('敏感词设置成功','/web/str');
        
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
