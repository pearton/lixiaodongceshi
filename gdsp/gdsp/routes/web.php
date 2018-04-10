<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['web']], function(){
    Route::get('/', 'Top\IndexController@index');//域名入口
    Route::get('/index', 'Top\IndexController@index');//域名入口

    Route::get('/set', 'Top\IndexController@set');//设置前台密码
    //Route::get('/admin/set', 'Admin\IndexController@set');//设置后台密码

    Route::get('/admin/login', 'Admin\IndexController@login');//后台登陆
    Route::put('/admin/loging', 'Admin\IndexController@loging');//后台登陆
});

/**
 * 后台
 */

Route::group(['middleware' => ['web','adminLogin']], function(){
    Route::get('/admin/index', 'Admin\IndexController@index');//后台首页
    Route::get('/admin/content', 'Admin\IndexController@content');//后台首页
    Route::get('/admin/quit', 'Admin\IndexController@quit');//后台登陆
    Route::get('/admin/wenjianmulu','Admin\WenjianController@mulu');//打开本地项目根目录

    Route::get('/admin/putword', 'Admin\SetController@putword');//导出学生个人奖学金报表word
    Route::get('/admin/putwordduoren', 'Admin\SetController@putwordduoren');//生成学生多人奖学金报表word
    Route::get('/admin/putexcelgsp', 'Admin\SetController@putexcelgsp');//导出学生个人gsp活动excel
     Route::get('/admin/putexcelgspduoren', 'Admin\SetController@putexcelgspduoren');//生成学生多人gsp活动excel
    Route::get('/admin/putexcelsuzhi', 'Admin\SetController@putexcelsuzhi');//导出学生个人gsp活动excel
    Route::get('/admin/yasuoword', 'Admin\SetController@yasuoword');//导出word
    Route::get('/admin/excel', 'Admin\SetController@index');//导出excel
    Route::get('/admin/putexcel', 'Admin\SetController@putExcel');//导出一级文件夹excel
    Route::get('/admin/putexcelerji/{id}', 'Admin\SetController@putexcelerji');//导出二级文件夹excel
    Route::get('/admin/putexcelsanji/{id}', 'Admin\SetController@putexcelsanji');//导出资源文件目录excel
    Route::get('/admin/putexcelsanji', 'Admin\SetController@putexcelsanji');//导出资源文件目录excel



    Route::put('/admin/wenjian/onexcel', 'Admin\SetController@wenjianOnExcel');//文件分类导入excel
    Route::put('/admin/item/onexcel', 'Admin\SetController@itemOnExcel');//详细列表导入excel
});
/**
 * 文件类型
 */
Route::group(['middleware' => ['web','adminLogin']], function(){
    Route::get('/admin/wenjian', 'Admin\WenjianController@index');//文件类型列表

    Route::get('/admin/wenjian/create/{id}', 'Admin\WenjianController@create');//创建文件夹
    Route::get('/admin/wenjian/del/{id}', 'Admin\WenjianController@del');//删除文件夹

    Route::get('/admin/lv/create/{id}', 'Admin\WenjianController@createlv');//创建文件夹
    Route::get('/admin/lv/del/{id}', 'Admin\WenjianController@dellv');//删除文件夹

    Route::get('/admin/wenjian/add', 'Admin\WenjianController@add');//文件类型添加
    Route::put('/admin/wenjian/added', 'Admin\WenjianController@added');//
    Route::get('/admin/wenjian/edit/{id}', 'Admin\WenjianController@edit');//文件类型编辑
    Route::put('/admin/wenjian/edited', 'Admin\WenjianController@edited');//
    Route::get('/admin/wenjian/clock/{id}', 'Admin\WenjianController@clock');//开启或关闭显示



    Route::get('/admin/wenjian/lv/add/{id}', 'Admin\WenjianController@lvAdd');//文件类型等级添加
    Route::put('/admin/wenjian/lv/added', 'Admin\WenjianController@lvAdded');//
    Route::get('/admin/wenjian/lv/edit/{id}', 'Admin\WenjianController@lvEdit');//文件类型等级编辑
    Route::put('/admin/wenjian/lv/edited', 'Admin\WenjianController@lvEdited');//
    Route::get('/admin/wenjian/lv/clock/{id}', 'Admin\WenjianController@lvclock');//开启或关闭显示
    Route::get('/admin/wenjian/lv/{id}', 'Admin\WenjianController@lv');//文件类型等级



    Route::get('/admin/wenjian/dels/{id}', 'Admin\WenjianController@dels');//文件类型删除不删除文件
    Route::delete('/admin/wenjian/dels', 'Admin\WenjianController@delss');//文件类型删除
    Route::delete('/admin/wenjian/lv/dels', 'Admin\WenjianController@lvdels');//分级批量删除
});


/**
 * 项目列表
 */
Route::group(['middleware' => ['web','adminLogin']], function(){
    Route::get('/admin/item/select', 'Admin\ItemController@select');//获取指定文件夹下的所有文件
    Route::put('/admin/item/created', 'Admin\ItemController@createditem');//创建文件夹

    Route::get('/admin/item/create/{id}', 'Admin\ItemController@createitem');//创建文件夹
    Route::get('/admin/item/add', 'Admin\ItemController@add');//列表添加
    Route::put('/admin/item/added', 'Admin\ItemController@added');//
    Route::get('/admin/item/edit/{id}', 'Admin\ItemController@edit');//列表编辑
    Route::put('/admin/item/edited', 'Admin\ItemController@edited');//
    Route::get('/admin/item/clock/{id}', 'Admin\ItemController@clock');//开启或关闭显示
    Route::get('/admin/item/{item_type?}', 'Admin\ItemController@index');//文件类型列表
    Route::get('/admin/ceshi/', 'Admin\ItemController@ceshi');//测试页面

    Route::delete('/admin/item/dels', 'Admin\ItemController@dels');//列表删除


});

/**
 * 前台
 */
Route::group(['middleware' => ['web']], function(){
//    Route::get('/login', 'Top\IndexController@login');//前台登陆
//    Route::put('/loging', 'Top\IndexController@loging');//前台登陆

    Route::get('/content', 'Top\IndexController@content');//分级模块
    Route::get('/content/{id}', 'Top\IndexController@contented');//分级模块
    Route::get('/contents/{id}', 'Top\IndexController@contents');//分级-》列表

    Route::get('/contentss', 'Top\IndexController@contentss');//
    Route::get('/word/{id}', 'Top\IndexController@word');//
    Route::get('/ppt/{id}', 'Top\IndexController@ppt');//
    Route::get('/play/{id}', 'Top\IndexController@play');//
});

Route::group(['middleware' => ['web','topLogin']], function(){
    Route::get('/quit', 'Top\IndexController@quit');//前台登陆

});