<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
	//用户登录
    public function adminLogin(Request $request) {
		$users = DB::table('mealmir_admin');
		//查询
    		$data=$users
    			->where('user_id', $request->input('Username'))
    			->where('user_password', md5($request->input('Password')))
    			->first();
    		
    		//如果找到记录
    		if($data) {
			session(['adminInfo.userId' => $data->id,
				'adminInfo.userName' => $data->user_id]);
    			return redirect('/admin/activity/index?stas=2');
		//没有记录
    		} else {
			session(['adminInfo.userId' => '']);
    			return back()->withInput();
    		}
    }
    
    //修改密码页面
    public function editPwd(Request $request) {
    		return view('admin.editpwd', ['adminUser' => session('adminInfo.userName'),
	    		'adminPath' => $request->path(),
			'script' => '']);	

    }
    
    //修改密码过程
    public function updatePwd(Request $request) {
    		$users = DB::table('mealmir_admin');
		//查询
    		$data=$users
    			->where('id', session('adminInfo.userId'))
    			->where('user_password', md5($request->input('password')))
    			->first();
    		
    		if($data) {
    			$users->where('id', session('adminInfo.userId'))
            		->update(['user_password' => md5($request->input('newPassword'))]);
            		
            	return view('admin.editpwd', ['adminUser' => session('adminInfo.userName'),
    				'adminPath' => $request->path(),
    				'script' => '<script>alert("操作成功");</script>']);	
    		} else {
    			return view('admin.editpwd', ['adminUser' => session('adminInfo.userName'),
    				'adminPath' => $request->path(),
    				'script' => '<script>alert("原密码错误");</script>']);	
    		}
    }
    
    //退出后台
    public function adminLogout(Request $request) {
    		session(['adminInfo.userId' => '',
				'adminPath' => $request->path(),
    				'script' => '<script></script>']);
    		return redirect('/admin/admin_login');
    }
}
