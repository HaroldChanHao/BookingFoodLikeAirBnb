<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
	//订单列表
    public function index(Request $request) {
    		$where[] = ['mealmir_order.order_status', '=', $request->input('stas')];
		if ($request->input('end')) {
    			$where[] = ['mealmir_order.order_create', '>=', urldecode($request->input('start'))];
    			$where[] = ['mealmir_order.order_create', '<=', urldecode($request->input('end'))];
		}
    		if ($request->input('keyWords')) {
    			$orWhere[] = ['mealmir_activity.act_name', 'like', '%'.$request->input('keyWords').'%'];
    			//$orWhere[] = ['mealmir_user.user_email', 'like', '%'.$request->input('keyWords').'%'];
    			
    			$order = DB::table('mealmir_order')
	            ->leftJoin('mealmir_activity', 'mealmir_activity.id', '=', 'mealmir_order.act_id')
	            ->leftJoin('mealmir_user', 'mealmir_user.id', '=', 'mealmir_order.order_user')
	            ->where($where)
	            ->orwhere($orWhere)
	            ->select('mealmir_order.*', 'mealmir_activity.act_name', 'mealmir_user.user_email')
	            ->get();
    		} else {
    			$order = DB::table('mealmir_order')
	            ->leftJoin('mealmir_activity', 'mealmir_activity.id', '=', 'mealmir_order.act_id')
	            ->leftJoin('mealmir_user', 'mealmir_user.id', '=', 'mealmir_order.order_user')
	            ->where($where)
	            ->select('mealmir_order.*', 'mealmir_activity.act_name', 'mealmir_user.user_email')
	            ->get();
    		}
    		switch ($request->input('stas')) {
		    case 0:
		        return view('admin.order0', ['adminUser' => session('adminInfo.userName'),
			    		'adminPath' => $request->path(),
			    		'stas' => 0,
			    		'odrData' => $order]);
		        		break;
		    case 1:
		        return view('admin.order1', ['adminUser' => session('adminInfo.userName'),
			    		'adminPath' => $request->path(),
			    		'stas' => 1,
			    		'odrData' => $order]);
		        		break;
		}
    		
    }
    //操作订单状态
    public function modOdr(Request $request) {
    		DB::table('mealmir_order')->where('id', $request->input('id'))
    			->update(['order_status' => $request->input('stas')]);
		return back()->withInput();
    }
    //添加分类页面
    public function addClass(Request $request) {
    		return view('admin.addclass', ['adminUser' => session('adminInfo.userName'),
    			'adminPath' => $request->path(),
			'script' => '']);
    }
    //编辑分类页面
    public function editClass(Request $request) {
    		$class = DB::table('mealmir_class');
		//查询
    		$data=$class
    			->where('id', $request->input('id'))
    			->first();
    		return view('admin.editclass', ['adminUser' => session('adminInfo.userName'),
    			'adminPath' => $request->path(),
    			'data' => $data,    			
			'script' => '']);
    }
    //更新分类过程
    public function updateClass(Request $request) {
    		$class = DB::table('mealmir_class');
		//查询
    		$data=$class
    			->where('class_title', $request->input('classTitle'))
    			->first();
    		if ($data) {
    			if ($request->input('id')) {
    				return view('admin.editclass', ['adminUser' => session('adminInfo.userName'),
		    			'adminPath' => $request->path(),
		    			'data' => $data,
					'script' => '<script>alert("已存在重名分类");</script>']);
    			} else {
    				return view('admin.addclass', ['adminUser' => session('adminInfo.userName'),
		    			'adminPath' => $request->path(),
					'script' => '<script>alert("已存在重名分类");</script>']);
    			}
    			
    		} else {
    			if ($request->input('id')) {
    				DB::table('mealmir_class')->where('id', $request->input('id'))
            			->update(['class_title' => $request->input('classTitle')]);
    			} else {
    				$class->insert(['class_title' => $request->input('classTitle')]);
    			}
    			return redirect('/admin/activity/class_list');
    		}
    }
    //删除分类过程
    public function delClass(Request $request) {
		DB::table('mealmir_class')->where('id', $request->input('id'))->delete();
		return redirect('/admin/activity/class_list');
    }
    //分类列表
    public function listClass(Request $request) {
    		$where = '';
    		if ($request->input('keyWords')) {
    			$where = "and class_title like '%".$request->input('keyWords')."%'";		
    		}
    		$class = DB::table('mealmir_class');
    		$data=$class
    			->whereRaw('	1=1 '.$where)
    			->get();
    		
    		return view('admin.listclass', ['adminUser' => session('adminInfo.userName'),
    			'adminPath' => $request->path(),
    			'classData' => $data,    			
    			'keyWords' => $request->input('keyWords'),    			
			'script' => '<script></script>']);
    }
}
