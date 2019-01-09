<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
	//后台首页
    public function index(Request $request) {
    		$where[] = ['mealmir_activity.act_status', '=', $request->input('stas')];
		if ($request->input('actClass')) {
    			$where[] = ['mealmir_activity.act_class', '=', $request->input('actClass')];
		}
		if ($request->input('dateType') == 1) {
    			$where[] = ['mealmir_activity.act_date', '>=', urldecode($request->input('start'))];
    			$where[] = ['mealmir_activity.act_date', '<=', urldecode($request->input('end'))];
		} elseif ($request->input('dateType') == 2) {
    			$where[] = ['mealmir_activity.act_create', '>=', urldecode($request->input('start'))];
    			$where[] = ['mealmir_activity.act_create', '<=', urldecode($request->input('end'))];
		}
    		if ($request->input('keyWords')) {
    			$orWhere[] = ['mealmir_activity.act_name', 'like', '%'.$request->input('keyWords').'%'];
// 			$orWhere[] = ['mealmir_activity.act_location', 'like', '%'.$request->input('keyWords').'%'];
//  			$orWhere[] = ['mealmir_activity.act_desc', 'like', '%'.$request->input('keyWords').'%'];
//  			$orWhere[] = ['mealmir_activity.act_contact', 'like', '%'.$request->input('keyWords').'%'];
//  			$orWhere[] = ['mealmir_activity.act_user', 'like', '%'.$request->input('keyWords').'%'];
    			
    			$activity = DB::table('mealmir_activity')
	            ->leftJoin('mealmir_class', 'mealmir_class.id', '=', 'mealmir_activity.act_class')
	            ->leftJoin('mealmir_user', 'mealmir_user.id', '=', 'mealmir_activity.act_user')	            
	            ->leftJoin('mealmir_city', 'mealmir_city.id', '=', 'mealmir_activity.act_location')	            
	            ->orwhere($orWhere)
	            ->where($where)
	            ->orderBy('mealmir_activity.id', 'desc')
	            ->select('mealmir_activity.*','mealmir_city.city_name','mealmir_city.con_name','mealmir_class.class_title', 'mealmir_user.user_email')
	            ->get();
    		} else {
    			$activity = DB::table('mealmir_activity')
	            ->leftJoin('mealmir_class', 'mealmir_class.id', '=', 'mealmir_activity.act_class')
	            ->leftJoin('mealmir_user', 'mealmir_user.id', '=', 'mealmir_activity.act_user')
	            ->leftJoin('mealmir_city', 'mealmir_city.id', '=', 'mealmir_activity.act_location')	 
	            ->where($where)
	            ->orderBy('mealmir_activity.id', 'desc')
	            ->select('mealmir_activity.*','mealmir_city.city_name','mealmir_city.con_name','mealmir_class.class_title', 'mealmir_user.user_email')
	            ->get();
    		}
    		
    		
		$actclass = DB::table('mealmir_class')
            ->get();
    		switch ($request->input('stas')) {
		    case 0:
		        return view('admin.index0', ['adminUser' => session('adminInfo.userName'),
			    		'adminPath' => $request->path(),
			    		'actclass' => $actclass,
			    		'stas' => 0,
			    		'actData' => $activity]);
		        		break;
		    case 1:
		        return view('admin.index1', ['adminUser' => session('adminInfo.userName'),
			    		'adminPath' => $request->path(),
			    		'actclass' => $actclass,
			    		'stas' => 1,
			    		'actData' => $activity]);
		        		break;
		    case 2:
		        return view('admin.index', ['adminUser' => session('adminInfo.userName'),
			    		'adminPath' => $request->path(),
			    		'actclass' => $actclass,
			    		'stas' => 2,
			    		'actData' => $activity]);
		        		break;
		}
    		
    }
    //操作活动状态
    public function modAct(Request $request) {
    		if ($request->input('stas') == 3) {
    			if (DB::table('mealmir_activity')->where('id', $request->input('id'))->value('del_sign') == 1) {
    				$user_id = DB::table('mealmir_activity')->where('id', $request->input('id'))->value('act_user');
				$user = DB::table('mealmir_user')->where('id', $user_id)->first();
		        // Mail::send()的返回值为空，所以可以其他方法进行判断
		        Mail::send('mail.reject',['name'=>$user->user_name],function($message) use($user){
		            $message ->to($user->user_email)->subject('notification');
		        });
		        if(count(Mail::failures()) < 1){
		            DB::table('mealmir_activity')->where('id', $request->input('id'))
			    			->update(['del_sign' => 0,'act_status' => 1]);
					return redirect('/admin/activity/index?stas=0');
		        }else{
		            echo ('<script>alert("邮件发送超时，请重试！");window.history.go(-1);</script>');
		        }
    			} else {
    				$user_id = DB::table('mealmir_activity')->where('id', $request->input('id'))->value('act_user');
				$user = DB::table('mealmir_user')->where('id', $user_id)->first();
		        // Mail::send()的返回值为空，所以可以其他方法进行判断
		        Mail::send('mail.mail',['name'=>$user->user_name],function($message) use($user){
		            $message ->to($user->user_email)->subject('审核通知');
		        });
		        if(count(Mail::failures()) < 1){
		            DB::table('mealmir_activity')->where('id', $request->input('id'))
			    			->delete();
					return redirect('/admin/activity/index?stas=0');
		        }else{
		            echo ('<script>alert("邮件发送超时，请重试！");window.history.go(-1);</script>');
		        }
    			}
			
		} else {
			if (DB::table('mealmir_activity')->where('id', $request->input('id'))->value('del_sign') == 1) {
				DB::table('mealmir_activity')->where('id', $request->input('id'))
			    			->delete();
					return redirect('/admin/activity/index?stas=0');
			} else {
				DB::table('mealmir_activity')->where('id', $request->input('id'))
		    			->update(['act_status' => $request->input('stas')]);
				return back()->withInput();
			}
			
		}
    }
    //删除活动状态
    public function delAct(Request $request) {
    		DB::table('mealmir_activity')->where('id', $request->input('id'))
    			->delete();
    		DB::table('mealmir_order')->where('act_id', $request->input('id'))
    			->delete();
		return redirect('/admin/activity/index?stas=2');
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
    
    
    
    //添加城市页面
    public function addCity(Request $request) {
    		$country = DB::table('mealmir_city')
    			-> select('con_name')
    			-> distinct()
    			-> get();
    		return view('admin.addcity', ['adminUser' => session('adminInfo.userName'),
    			'adminPath' => $request->path(),
    			'country' => $country,
			'script' => '']);
    }
    //编辑城市页面
    public function editCity(Request $request) {
    		$city = DB::table('mealmir_city');
		//查询
    		$data=$city
    			->where('id', $request->input('id'))
    			->first();
    		return view('admin.editcity', ['adminUser' => session('adminInfo.userName'),
    			'adminPath' => $request->path(),
    			'data' => $data,    			
			'script' => '']);
    }
    //更新城市过程
    public function updateCity(Request $request) {
    		$city = DB::table('mealmir_city');
		//查询
    		$data=$city
    			->where('city_name', $request->input('cityName'))
    			->where('con_name', $request->input('conName'))
    			->first();
    		if ($data) {
    			if ($request->input('id')) {
    				$img = $_FILES['cityPic'];
	    			$img_name = '';
				if(!empty($img)) {
				    $img_desc = $this->reArrayFiles($img);
				    $img_name = '';
				    foreach($img_desc as $val)
				    {
				        $newname = date('YmdHis',time()).mt_rand().'.'.pathinfo($val['name'], PATHINFO_EXTENSION);
				        move_uploaded_file($val['tmp_name'],$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$newname);
				        $img_name = $newname;
				    }
				}
				
	    			if ($request->input('id')) {
	    				if ($request->input('conName1')) {
	    					//有新的国家
	    					$city->where('id', $request->input('id'))
	            				->update(['city_name' => $request->input('cityName'),'con_name' => $request->input('conName1'),'city_pic' => $img_name]);
	    				} else {
	    					//无新的国家
	    					$city->where('id', $request->input('id'))
	            				->update(['city_name' => $request->input('cityName'),'con_name' => $request->input('conName'),'city_pic' => $img_name]);
	    				}
	    				
	    			} else {
	    				if ($request->input('conName1')) {
	    					$city->insert(['city_name' => $request->input('cityName'),'con_name' => $request->input('conName1'),'city_pic' => $img_name]);
	    				} else {
	    					$city->insert(['city_name' => $request->input('cityName'),'con_name' => $request->input('conName'),'city_pic' => $img_name]);
	    				}	    				
	    			}
	    			return redirect('/admin/activity/city_list');
    			} else {
    				return view('admin.addcity', ['adminUser' => session('adminInfo.userName'),
		    			'adminPath' => $request->path(),
					'script' => '<script>alert("已存在重名城市");</script>']);
    			}
    			
    		} else {
    			$img = $_FILES['cityPic'];
    			$img_name = '';
			if(!empty($img)) {
			    $img_desc = $this->reArrayFiles($img);
			    $img_name = '';
			    foreach($img_desc as $val)
			    {
			        $newname = date('YmdHis',time()).mt_rand().'.'.pathinfo($val['name'], PATHINFO_EXTENSION);
			        move_uploaded_file($val['tmp_name'],$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$newname);
			        $img_name = $newname;
			    }
			}
			
    			if ($request->input('id')) {
    				if ($request->input('conName1')) {
    					DB::table('mealmir_city')->where('id', $request->input('id'))
            				->update(['city_name' => $request->input('cityName'),'con_name' => $request->input('conName1'),'city_pic' => $img_name]);
    				} else {
    					DB::table('mealmir_city')->where('id', $request->input('id'))
            				->update(['city_name' => $request->input('cityName'),'con_name' => $request->input('conName'),'city_pic' => $img_name]);
    				}
    				
    				
    			} else {
    				if ($request->input('conName1')) {
    					$city->insert(['city_name' => $request->input('cityName'),'con_name' => $request->input('conName1'),'city_pic' => $img_name]);
    				} else {
    					$city->insert(['city_name' => $request->input('cityName'),'con_name' => $request->input('conName'),'city_pic' => $img_name]);
    				}
    				
    			}
    			return redirect('/admin/activity/city_list');
    		}
    }
    //城市列表
    public function listCity(Request $request) {
    		$where = '';
    		if ($request->input('keyWords')) {
    			$where = "and city_name like '%".$request->input('keyWords')."%'";		
    		}
    		$city = DB::table('mealmir_city');
    		$data=$city
    			->whereRaw('	1=1 '.$where)
    			->get();
    		
    		return view('admin.listcity', ['adminUser' => session('adminInfo.userName'),
    			'adminPath' => $request->path(),
    			'cityData' => $data,    			
    			'keyWords' => $request->input('keyWords'),    			
			'script' => '<script></script>']);
    }
    private function reArrayFiles($file) {
	    $file_ary = array();
	    $file_count = count($file['name']);
	    $file_key = array_keys($file);
	    
	    for($i=0;$i<$file_count;$i++)
	    {
	        foreach($file_key as $val)
	        {
	            $file_ary[$i][$val] = $file[$val][$i];
	        }
	    }
	    return $file_ary;
	}
}
