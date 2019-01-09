<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
	//评价列表
    public function index(Request $request) {
    		$where[] = ['mealmir_comment.com_status', '=', $request->input('stas')];
		if ($request->input('end')) {
    			$where[] = ['mealmir_comment.com_create', '>=', urldecode($request->input('start'))];
    			$where[] = ['mealmir_comment.com_create', '<=', urldecode($request->input('end'))];
		}
    		if ($request->input('keyWords')) {
    			$orWhere[] = ['mealmir_activity.act_name', 'like', '%'.$request->input('keyWords').'%'];
    			//$orWhere[] = ['mealmir_user.user_email', 'like', '%'.$request->input('keyWords').'%'];
    			
    			$comment = DB::table('mealmir_comment')
	            ->leftJoin('mealmir_activity', 'mealmir_activity.id', '=', 'mealmir_comment.act_id')
	            ->leftJoin('mealmir_user', 'mealmir_user.id', '=', 'mealmir_comment.com_user')
	            ->where($where)
	            ->orwhere($orWhere)
	            ->select('mealmir_comment.*', 'mealmir_activity.act_name', 'mealmir_user.user_email')
	            ->get();
    		} else {
    			$comment = DB::table('mealmir_comment')
	            ->leftJoin('mealmir_activity', 'mealmir_activity.id', '=', 'mealmir_comment.act_id')
	            ->leftJoin('mealmir_user', 'mealmir_user.id', '=', 'mealmir_comment.com_user')
	            ->where($where)
	            ->select('mealmir_comment.*', 'mealmir_activity.act_name', 'mealmir_user.user_email')
	            ->get();
    		}
    		switch ($request->input('stas')) {
		    case 0:
		        return view('admin.comment0', ['adminUser' => session('adminInfo.userName'),
			    		'adminPath' => $request->path(),
			    		'stas' => 0,
			    		'comData' => $comment]);
		        		break;
		    case 1:
		        return view('admin.comment1', ['adminUser' => session('adminInfo.userName'),
			    		'adminPath' => $request->path(),
			    		'stas' => 1,
			    		'comData' => $comment]);
		        		break;
		}
    		
    }
    //操作评价状态
    public function modCom(Request $request) {
    		if ($request->input('stas') == 0) {
    			DB::table('mealmir_comment')->where('id', '=', $request->input('id'))->delete();
    		} else {
    			DB::table('mealmir_comment')->where('id', $request->input('id'))
    			->update(['com_status' => $request->input('stas')]);		
    		}
    		return back()->withInput();
    }
}
