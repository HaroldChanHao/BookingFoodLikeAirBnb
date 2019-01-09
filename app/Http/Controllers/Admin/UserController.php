<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	//用户列表
    public function index(Request $request) {
    		$where[] = ['mealmir_user.user_email', '<>', ''];
		if ($request->input('end')) {
    			$where[] = ['mealmir_user.user_create', '>=', urldecode($request->input('start'))];
    			$where[] = ['mealmir_user.user_create', '<=', urldecode($request->input('end'))];
		}
    		if ($request->input('keyWords')) {
    			$orWhere[] = ['mealmir_user.user_email', 'like', '%'.$request->input('keyWords').'%'];
    			//$orWhere[] = ['mealmir_user.user_email', 'like', '%'.$request->input('keyWords').'%'];
    			
    			$user = DB::table('mealmir_user')
	            
	            ->where($orWhere)
	            ->orderBy('id', 'desc')
	            ->get();
    		} else {
    			$user = DB::table('mealmir_user')
	            
	            ->where($where)
	            ->orderBy('id', 'desc')
	            ->get();
    		}
    		return view('admin.user', ['adminUser' => session('adminInfo.userName'),
	    		'adminPath' => $request->path(),
	    		'userData' => $user]);
    		
    }
    //操作用户状态
    public function modUser(Request $request) {
    		DB::table('mealmir_user')->where('id', $request->input('id'))
    			->update(['user_status' => $request->input('stas')]);
		return back()->withInput();
    }
}
