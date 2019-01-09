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
//网站-首页
Route::get('/', 'Web\IndexController@index');
//网站-发送邮件
Route::get('/send_mail', 'Web\IndexController@sendMail');
//网站-激活用户
Route::get('/verify', 'Web\IndexController@verifyUser');
//网站-活动列表
Route::get('/listings', 'Web\IndexController@listings');
//网站-活动详情
Route::get('/actshow', 'Web\IndexController@actShow');
//网站-活动详情预览
Route::get('/actshowprev', 'Web\IndexController@actShowPrev');
//网站-活动详情预览
Route::post('/actshowprev', 'Web\IndexController@actApplyPre');
//网站-活动报名
Route::post('/actshow', 'Web\IndexController@actApply');
//网站-新闻列表
Route::get('/news', 'Web\IndexController@newsList');
//网站-新闻列表
Route::get('/cities', 'Web\IndexController@citiesList');
//网站-新闻显示
Route::get('/infoshow', 'Web\IndexController@newsShow');
//网站-关于我们
Route::get('/about', 'Web\IndexController@aboutUs');
//网站-用户注册
Route::get('/register', 'Web\UserController@register');
Route::post('/register', 'Web\UserController@regSave');
//网站-用户登录
Route::get('/login', 'Web\UserController@login');
Route::post('/login', 'Web\UserController@loginChk');
//用户中心-个人信息
Route::get('/myaccount', 'Web\UserController@accInfo');
//用户中心-更新头像
Route::post('/myaccount', 'Web\UserController@savePhoto');
//用户中心-用户退出
Route::get('/logout', 'Web\UserController@logOut');
//用户中心-添加活动
Route::get('/addact', 'Web\UserController@addAct');
Route::post('/addact', 'Web\UserController@addActSave');
//用户中心-活动列表
Route::get('/actlist', 'Web\UserController@actList');
//用户中心-删除活动
Route::get('/delact', 'Web\UserController@delAct');
//用户中心-修改活动
Route::get('/modact', 'Web\UserController@modAct');
//用户中心-修改活动保存
Route::post('/modact', 'Web\UserController@modActSave');
//用户中心-订单列表
Route::get('/odrlist', 'Web\UserController@odrList');
//用户中心-删除用户订单
Route::get('/orderdel', 'Web\UserController@orderDel');
//用户中心-信息列表
Route::get('/inbox', 'Web\UserController@ltrList');
Route::post('/inbox', 'Web\UserController@ltrSave');
//用户中心-我的订单列表
Route::get('/myodrlist', 'Web\UserController@myOdrList');
//用户中心-我的信息列表
Route::get('/myinbox', 'Web\UserController@myLtrList');
Route::post('/myinbox', 'Web\UserController@myLtrSave');
//用户中心-个人信息
Route::get('/editpro', 'Web\UserController@editPro');
Route::post('/editpro', 'Web\UserController@editProSave');
//用户中心-退出登录
Route::get('/logout', 'Web\UserController@logOut');
//用户中心-提交评价
Route::post('/comment', 'Web\UserController@comment');
//用户中心-评价列表
Route::get('/revdetail', 'Web\UserController@revDetail');
//用户中心-订阅
Route::get('/sub', 'Web\UserController@subscribe');
//用户中心-取消订阅
Route::get('/unsubscribe', 'Web\UserController@unsubscribe');
//用户中心-订阅列表
Route::get('/mysublist', 'Web\UserController@subList');
//后台-登陆
Route::get('/admin/admin_login', function () {
    return view('admin.login');
});
Route::post('/admin/admin_login', 'Admin\AdminUserController@adminLogin');
//后台-首页
Route::get('/admin/activity/index', 'Admin\ActivityController@index');
//后台-修改密码
Route::get('/admin/user/edit_pwd', 'Admin\AdminUserController@editPwd');
Route::post('/admin/user/edit_pwd', 'Admin\AdminUserController@updatePwd');
//后台-用户退出
Route::get('/admin/user/admin_logout', 'Admin\AdminUserController@adminLogout');
//后台-添加分类
Route::get('/admin/activity/add_class', 'Admin\ActivityController@addClass');
Route::post('/admin/activity/add_class', 'Admin\ActivityController@updateClass');
//后台-编辑分类
Route::get('/admin/activity/edit_class', 'Admin\ActivityController@editClass');
Route::post('/admin/activity/edit_class', 'Admin\ActivityController@updateClass');
//后台-添加城市
Route::get('/admin/activity/add_city', 'Admin\ActivityController@addCity');
Route::post('/admin/activity/add_city', 'Admin\ActivityController@updateCity');
//后台-编辑城市
Route::get('/admin/activity/edit_city', 'Admin\ActivityController@editCity');
Route::post('/admin/activity/edit_city', 'Admin\ActivityController@updateCity');
//后台-城市列表
Route::get('/admin/activity/city_list', 'Admin\ActivityController@listCity');
//后台-删除分类
Route::get('/admin/activity/del_class', 'Admin\ActivityController@delClass');
//后台-分类列表
Route::get('/admin/activity/class_list', 'Admin\ActivityController@listClass');
//后台-活动列表
Route::get('/admin/activity/index', 'Admin\ActivityController@index');
//后台-操作活动
Route::get('/admin/activity/mod_act', 'Admin\ActivityController@modAct');
//后台-删除活动
Route::get('/admin/activity/del_act', 'Admin\ActivityController@delAct');
//后台-订单列表
Route::get('/admin/order/index', 'Admin\OrderController@index');
//后台-操作订单
Route::get('/admin/order/mod_odr', 'Admin\OrderController@modOdr');
//后台-评价列表
Route::get('/admin/comment/index', 'Admin\CommentController@index');
//后台-操作评价
Route::get('/admin/comment/mod_com', 'Admin\CommentController@modCom');
//后台-新闻列表
Route::get('/admin/news/index', 'Admin\NewsController@index');
//后台-添加新闻
Route::get('/admin/news/add_news', 'Admin\NewsController@addNews');
//后台-添加新闻过程
Route::post('/admin/news/add_news', 'Admin\NewsController@saveNews');
//后台-编辑新闻
Route::get('/admin/news/edit_news', 'Admin\NewsController@editNews');
//后台-编辑新闻过程
Route::post('/admin/news/edit_news', 'Admin\NewsController@saveNews');
//后台-所有用户
Route::get('/admin/user/index', 'Admin\UserController@index');
//后台-操作用户
Route::get('/admin/user/mod_user', 'Admin\UserController@modUser');
//后台-关于我们
Route::get('/admin/news/about', 'Admin\NewsController@aboutUs');
Route::post('/admin/news/about', 'Admin\NewsController@aboutUsSave');