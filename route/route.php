<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');
//前台
Route::rule('/','home/IndexController/index');
Route::rule('tie/list/:cid','home/TieController/index');
Route::rule('tie/fatie/:cid','home/TieController/create');
Route::rule('tie/save/:cid','home/TieController/save');
Route::rule('tie/detail/:hcid','home/TieController/huilist');
Route::rule('tie/reply/:hcid','home/TieController/reply');
//搜索
Route::rule('/search/list','home/IndexController/search');


//前台登录
Route::rule('/dologin', 'home/HomeLoginController/dologin');
Route::rule('/outlogin', 'home/HomeLoginController/outlogin');

Route::rule('useredit/edit/[:yid]','home/IndexController/edit');
Route::rule('/useredit/update/[:yid]','home/IndexController/update');

Route::rule('useredit/codeedit/[:mid]','home/IndexController/codeedit');
Route::rule('/useredit/codeupdate/[:mid]','home/IndexController/codeupdate');

Route::rule('/useredit/login','home/IndexController/create');
Route::rule('/useredit/save','home/IndexController/save');

//后台
Route::rule('/admin/login', 'admin/LoginController/login');
Route::rule('/yzm', 'admin/LoginController/verify');
Route::rule('/admin/dologin', 'admin/LoginController/dologin');
Route::rule('/admin/outlogin', 'admin/LoginController/outlogin');
Route::rule('login/codeedit/[:aid]', 'admin/LoginController/codeedit');
Route::rule('/login/codeupdate/[:aid]','admin/LoginController/codeupdate');

//首页
//Route::view('/common/index','admin@common/index');
//用户
Route::view('/admin','admin@common/index');
Route::rule('/user/create','admin/UserController/create');
Route::rule('/user/save','admin/UserController/save');
Route::rule('/user/ulist','admin/UserController/index');
Route::rule('/user/delete/[:uid]','admin/UserController/delete');
Route::rule('/user/del/[:uid]','admin/UserController/del');
Route::rule('/user/delete$','@admin/UserController/delete');
Route::rule('/user/del$','@admin/UserController/del');
Route::rule('/user/edit/[:uid]','admin/UserController/edit');
Route::rule('/user/update/[:uid]','admin/UserController/update');
Route::rule('/user/index','admin/UserController/index');

//友情链接
Route::rule('/fri/fcreate','admin/FriController/create');
Route::rule('/fri/save','admin/FriController/save');
Route::rule('/fri/flist','admin/FriController/index');
Route::rule('/fri/delete/[:fid]','admin/FriController/delete');
Route::rule('/fri/delete$','@admin/FriController/delete');
Route::rule('/fri/edit/[:fid]','admin/FriController/edit');
Route::rule('/fri/update/[:fid]','admin/FriController/update');
Route::rule('/fri/index','admin/FriController/index');


//网站配置
Route::rule('/web/web','admin/WebController/edit');
Route::rule('/web/update/[:wid]','admin/WebController/update');

Route::rule('/web/str','admin/WebController/stredit');
Route::rule('/web/strupdate/[:sid]','admin/WebController/strupdate');

//分区
Route::rule('/part/create','admin/PartController/create');
Route::rule('/part/save','admin/PartController/save');
Route::rule('/part/plist','admin/PartController/index');
Route::rule('/part/delete/[:pid]','admin/PartController/delete');
Route::rule('/part/del/[:pid]$','@admin/PartController/del');
Route::rule('/part/edit/[:pid]','admin/PartController/edit');
Route::rule('/part/update/[:pid]','admin/PartController/update');
Route::rule('/part/index','admin/PartController/index');

//板块
Route::rule('/cate/create','admin/CateController/create');
Route::rule('/cate/save','admin/CateController/save');
Route::rule('/cate/clist','admin/CateController/index');
Route::rule('/cate/delete/[:cid]','admin/CateController/delete');
//Route::rule('/cate/delete$','@admin/CateController/delete');
Route::rule('/cate/dele/[:cid]','admin/CateController/dele');
//Route::rule('/cate/dele$','@admin/CateController/dele');
Route::rule('/cate/edit/[:cid]','admin/CateController/edit');
Route::rule('/cate/update/[:cid]','admin/CateController/update');
Route::rule('/cate/index','admin/CateController/index');

//帖子
Route::rule('/post/post','admin/PostController/index');
Route::rule('/post/delete/[:pid]','admin/PostController/delete');
Route::rule('/post/delete$','@admin/PostController/delete');
Route::rule('/post/pedit/[:pid]','admin/PostController/edit');
Route::rule('/post/update/[:pid]','admin/PostController/update');

Route::rule('/post/reply','admin/ReplyController/index');
Route::rule('/post/delet/[:rid]','admin/ReplyController/delete');
Route::rule('/post/delet$','@admin/ReplyController/delete');
Route::rule('/post/redit/[:rid]','admin/ReplyController/edit');
Route::rule('/post/rupdate/[:rid]','admin/ReplyController/update');
return [

];
