<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	//首页
    public function register(Request $request) {
		return view('web.register', ['script' => '',
			'user_id' => session('user_id'),
			'user_pic' => session('user_pic'),
			'user_name' => session('user_name')]);
	}
	//登录
    public function login(Request $request) {
		return view('web.login', ['script' => '',
    			'user_id' => session('user_id'),
    			'user_pic' => session('user_pic'),
			'user_name' => session('user_name')]);
	}
	//用戶註冊保存
	public function regSave(Request $request) {
		if ($request->input('url')) {
			if ($request->input('user_password') <> $request->input('user_confirm_password')) {
				echo ('<script>alert("Check password please!！")window.history.go(-1);</script>');
			} else {
				$user = DB::table('mealmir_user');
				//查询
		    		$data=$user
		    			->where('user_email', $request->input('user_email'))
		    			->first();
		    		//var_dump($request->input('user_email'));
		    		if ($data) {
		    			echo ('<script>alert("Email was register before!")window.history.go(-1);</script>');
		    			
		    		} else {
					$uid = $user->insertGetId([
						'user_email' => $request->input('user_email'),
						'user_name' => $request->input('user_name'),
						'user_password' => md5($request->input('user_confirm_password'))
					]);
					$udata = DB::table('mealmir_user')->where('id',$uid)->first();
					// Mail::send()的返回值为空，所以可以其他方法进行判断
			        Mail::send('mail.verify',['name'=>$udata->user_name,'link'=>'http://mealmir.com/verify?token='.md5($udata->id.$udata->user_create).'&id='.$udata->id],function($message) use($udata){
			            $message ->to($udata->user_email)->subject('Activate MEALMIR account');
			        });
			        
		    			echo ('<script>alert("Please check the verification mail!");window.location.href="/login?url='.$request->input('url').'";</script>');
		    		}
			}
		} else {
			if ($request->input('user_password') <> $request->input('user_confirm_password')) {
				return view('web.register', ['script' => '<script>alert("Check password please!");</script>',
	    			'user_id' => session('user_id'),
	    			'user_name' => session('user_name'),
				'user_email' => session('user_email')]);
			} else {
				$user = DB::table('mealmir_user');
				//查询
		    		$data=$user
		    			->where('user_email', $request->input('user_email'))
		    			->first();
		    		//var_dump($request->input('user_email'));
		    		if ($data) {
		    			return view('web.register', ['script' => '<script>alert("Email was register before!");</script>','user_id' => session('user_id'),
		    			'user_pic' => session('user_pic'),
		    			'user_name' => session('user_name')]);
		    		} else {
					$uid = $user->insertGetId([
						'user_email' => $request->input('user_email'),
						'user_name' => $request->input('user_name'),
						'user_password' => md5($request->input('user_confirm_password'))
					]);
					$udata = DB::table('mealmir_user')->where('id',$uid)->first();
					// Mail::send()的返回值为空，所以可以其他方法进行判断
			        Mail::send('mail.verify',['name'=>$udata->user_name,'link'=>'http://mealmir.com/verify?token='.md5($udata->id.$udata->user_create).'&id='.$udata->id],function($message) use($udata){
			            $message ->to($udata->user_email)->subject('Activate MEALMIR account');
			        });
			        
		    			echo ('<script>alert("Please check the verification mail!");window.location.href="/login";</script>');
		    		}
			}
		}
		
    }
    //用户登录检测
    	public function loginChk(Request $request) {
    		$user = DB::table('mealmir_user');
		//查询
    		$data=$user
    			->where('user_email', $request->input('user_email'))
    			->where('user_password', md5($request->input('user_confirm_password')))
    			->first();
    		if ($request->input('url')) {
    			if ($data) {
    				if ($data->user_verify == 1) {
    					session(['user_id' => $data->id,
		    			'user_email' => $data->user_email,
		    			'user_pic' => $data->user_pic,
		    			'user_name' => $data->user_name]);
		    			return view('web.register', ['script' => '<script>alert("Success！");window.location.href="'.$request->input('url').'";</script>',
		    			'user_id' => session('user_id'),
		    			'user_email' => session('user_email'),
		    			'user_pic' => session('user_pic'),
					'user_name' => session('user_name')]);
    				} else {
    					echo ('<script>alert("Please activate this account from your email first");window.location.href="/login?url='.$request->input('url').'";</script>');
    				}
	    			
	    		} else {
				echo ('<script>alert("Username or password wrong");window.location.href="/login?url='.$request->input('url').'";</script>');
	    		}
    		} else {
    			if ($data) {
    				if ($data->user_verify == 1) {
		    			session(['user_id' => $data->id,
		    			'user_email' => $data->user_email,
		    			'user_pic' => $data->user_pic,
		    			'user_name' => $data->user_name]);
		    			return view('web.register', ['script' => '<script>alert("Success！");window.location.href="/";</script>',
		    			'user_id' => session('user_id'),
		    			'user_email' => session('user_email'),
		    			'user_pic' => session('user_pic'),
					'user_name' => session('user_name')]);
				} else {
					echo ('<script>alert("Please activate this account from your email first");window.location.href="/login";</script>');
				}
	    		} else {
				return view('web.login', ['script' => '<script>alert("Username or password wrong");</script>',
	    			'user_id' => session('user_id'),
	    			'user_pic' => session('user_pic'),
				'user_name' => session('user_name')]);
	    		}
    		}    		
    }
    //用户个人信息
    public function accInfo(Request $request) {
    		$user = DB::table('mealmir_user');
		//查询
    		$data=$user
    			->where('id', session('user_id'))
    			->first();
    		return view('web.myaccount', ['user_id' => session('user_id'),
			'user_name' => session('user_name'),
			'infoPath' => 'Account',
			'user_pic' => session('user_pic'),
			'user_data' => $data]);
    }
    //用户退出
    public function logOut(Request $request) {
    		session(['user_id' => '',
    			'user_email' => '']);
    		return redirect('/');
    }
    //用户添加活动
    public function addAct(Request $request) {
    		$actClass = DB::table('mealmir_class');
    		$data = $actClass
    			-> get(); 
    		$cityClass = DB::table('mealmir_city');
    		$cityData = $cityClass
    			-> get();    		
    		return view('web.addact', ['user_id' => session('user_id'),
			'user_name' => session('user_name'),
			'user_pic' => session('user_pic'),
			'script' => '',
			'city_data' => $cityData,
			'act_class' => $data]);
    }
    //添加活动保存
    public function addActSave(Request $request) {
    		$img = $_FILES['featured_image'];
		if(!empty($img)) {
		    $img_desc = $this->reArrayFiles($img);
		    $img_name = '';
		    foreach($img_desc as $val)
		    {
		        $newname = date('YmdHis',time()).mt_rand().'.'.pathinfo($val['name'], PATHINFO_EXTENSION);
		        move_uploaded_file($val['tmp_name'],$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$newname);
		        $img_name = $newname.','.$img_name;
		    }
		}
    		
    		$geo = DB::table('mealmir_city') -> where('id',$request->input('job_region')) -> first();
    		$add = urlencode($request->input('job_location')).','.$geo->city_name.','.$geo->con_name;
    		$res = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$add.'&key=AIzaSyBFd8Wufl1_cXM-xk9L_OGZeYITiplT98k'),true);
    		$actInfo = DB::table('mealmir_activity');
    		$actInfo->insert([
			'act_name' => $request->input('job_title'),
			'act_location' => $request->input('job_region'),
			'act_lat' => $res['results'][0]['geometry']['location']['lat'],
			'act_lng' => $res['results'][0]['geometry']['location']['lng'],
			'act_add' => $request->input('job_location'),
			'act_class' => $request->input('job_category'),
			'act_date_start' => $request->input('start'),
			'act_date_end' => $request->input('end'),
			'act_ord_start' => $request->input('book_start'),
			'act_ord_end' => $request->input('book_end'),
			'act_images' => $img_name,
			'act_contact' => $request->input('phone'),
			'act_total' => $request->input('people_num'),
			'act_user' => session('user_id'),
			'act_desc' => $request->input('job_description')
		]);
		$cityClass = DB::table('mealmir_city');
    		$cityData = $cityClass
    			-> get();
		$actClass = DB::table('mealmir_class');
    		$data = $actClass
    			-> get();  
    		return view('web.addact', ['user_id' => session('user_id'),
			'user_name' => session('user_name'),
			'user_pic' => session('user_pic'),
			'act_class' => $data,
			'city_data' => $cityData,
			'script' => '<script>alert("Success!");window.location.href="/actlist";</script>']);
    }
    //活动列表
    public function actList(Request $request) {    		
		$actList = DB::table('mealmir_activity');
		$data = $actList
			-> leftJoin('mealmir_order', 'mealmir_activity.id', '=', 'mealmir_order.act_id')
			-> where('mealmir_activity.act_user', session('user_id'))
			-> where('mealmir_activity.act_status', '<>',0)
			-> select(DB::raw('mealmir_activity.id,mealmir_activity.act_name,mealmir_activity.act_add,mealmir_activity.act_date_start,mealmir_activity.act_date_end,count(mealmir_order.id) as orderTal'))
			-> groupBy('mealmir_activity.id','mealmir_activity.act_name','mealmir_activity.act_add','mealmir_activity.act_date_start','mealmir_activity.act_date_end')
			-> orderBy('mealmir_activity.id', 'desc')
			-> get();
		$script = '';
		if ($request->input('status')) {
			$script = '<script>alert("Please wait for review！");</script>';
		}
		//dump($data);
		return view('web.actlist', ['user_id' => session('user_id'),
			'user_name' => session('user_name'),
			'user_pic' => session('user_pic'),
			'infoPath' => 'Activity',
			'script' => $script,
			'act_data' => $data]);
    }
    //删除活动
    public function delAct(Request $request) {    		
		DB::table('mealmir_activity')
			-> where('mealmir_activity.act_user', session('user_id'))
			-> where('mealmir_activity.id', $request->input('id'))
			-> update(['del_sign' => 1,'act_status' => 0]);
		//dump($data);
		return redirect('/actlist?status=del');
    }
    //修改活动
    public function modAct(Request $request) {    		
		$actData = DB::table('mealmir_activity')
			-> leftJoin('mealmir_city', 'mealmir_activity.act_location', '=', 'mealmir_city.id')
			-> leftJoin('mealmir_class', 'mealmir_activity.act_class', '=', 'mealmir_class.id')
			-> leftJoin('mealmir_user', 'mealmir_activity.act_user', '=', 'mealmir_user.id')
			-> select('mealmir_activity.*','mealmir_city.city_name','mealmir_city.con_name','mealmir_class.class_title','mealmir_user.user_email','mealmir_user.user_create','mealmir_user.user_pic','mealmir_user.user_name')
			-> where('mealmir_activity.id',$request->input('id'))			
			-> first();
		$actClass = DB::table('mealmir_class');
    		$data = $actClass
    			-> get(); 
    		$cityClass = DB::table('mealmir_city');
    		$cityData = $cityClass
    			-> get();    		
		return view('web.editact', ['user_id' => session('user_id'),
			'act_data' => $actData,
			'user_pic' => session('user_pic'),
			'script' => '',
			'city_data' => $cityData,
			'act_class' => $data,
			'user_name' => session('user_name')]);
    }
    //修改活动保存
    public function modActSave(Request $request) {
    		$img = $_FILES['featured_image'];
		if(!empty($img)) {
		    $img_desc = $this->reArrayFiles($img);
		    $img_name = '';
		    foreach($img_desc as $val)
		    {
		        $newname = date('YmdHis',time()).mt_rand().'.'.pathinfo($val['name'], PATHINFO_EXTENSION);
		        move_uploaded_file($val['tmp_name'],$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$newname);
		        $img_name = $newname.','.$img_name;
		    }
		}
    		
    		$geo = DB::table('mealmir_city') -> where('id',$request->input('job_region')) -> first();
    		$add = urlencode($request->input('job_location')).','.$geo->city_name.','.$geo->con_name;
    		$res = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$add.'&key=AIzaSyBFd8Wufl1_cXM-xk9L_OGZeYITiplT98k'),true);
    		$actInfo = DB::table('mealmir_activity') -> where('id',$request->input('id'));
    		$actInfo->update([
			'act_name' => $request->input('job_title'),
			'act_location' => $request->input('job_region'),
			'act_lat' => $res['results'][0]['geometry']['location']['lat'],
			'act_lng' => $res['results'][0]['geometry']['location']['lng'],
			'act_add' => $request->input('job_location'),
			'act_class' => $request->input('job_category'),
			'act_date_start' => $request->input('start'),
			'act_date_end' => $request->input('end'),
			'act_ord_start' => $request->input('book_start'),
			'act_ord_end' => $request->input('book_end'),
			'act_images' => $img_name,
			'act_contact' => $request->input('phone'),
			'act_total' => $request->input('people_num'),
			'act_status' => 0,
			'act_desc' => $request->input('job_description')
		]);
		return redirect('/actlist?status=del');
    }
    //订单列表
    public function odrList(Request $request) {    		
		$actList = DB::table('mealmir_order');
		$data = $actList
			-> leftJoin('mealmir_user', 'mealmir_order.order_user', '=', 'mealmir_user.id')
			-> leftJoin('mealmir_activity', 'mealmir_activity.id', '=', 'mealmir_order.act_id')
			-> leftJoin('mealmir_letter', 'mealmir_order.id', '=', 'mealmir_letter.odr_id')
			-> where('mealmir_activity.act_user', session('user_id'))
			-> where('mealmir_order.act_id', $request->input('id'))
			-> select(DB::raw('mealmir_order.id,mealmir_user.user_email,mealmir_user.user_name,mealmir_order.order_create,mealmir_order.order_number,count(mealmir_letter.id) as letters'))
			-> groupBy('mealmir_order.id','mealmir_user.user_email','mealmir_user.user_name','mealmir_order.order_create','mealmir_order.order_number')
			-> orderBy('mealmir_order.id', 'desc')
			-> get();
		//dump($data);
		return view('web.odrlist', ['user_id' => session('user_id'),
			'user_name' => session('user_name'),
			'user_pic' => session('user_pic'),
			'infoPath' => 'Activity',
			'odr_data' => $data]);
    }
    //删除订单
    public function orderDel(Request $request) {
    		DB::table('mealmir_order')
			-> leftJoin('mealmir_activity', 'mealmir_activity.id', '=', 'mealmir_order.act_id')
			-> where('mealmir_activity.act_user', session('user_id'))
			-> where('mealmir_order.id', $request->input('id'))
			-> delete();
		return redirect('/actlist');
    }
    //信息列表
    public function ltrList(Request $request) {    		
		$ltrList = DB::table('mealmir_letter');
		$data = $ltrList
			-> leftJoin('mealmir_order', 'mealmir_letter.odr_id', '=', 'mealmir_order.id')
			-> leftJoin('mealmir_activity', 'mealmir_activity.id', '=', 'mealmir_order.act_id')
			-> leftJoin('mealmir_user as user_r', 'user_r.id', '=', 'mealmir_letter.user_id')
			-> leftJoin('mealmir_user as user_p', 'user_p.id', '=', 'mealmir_letter.post_id')
			-> where('mealmir_activity.act_user', session('user_id'))
			-> where('mealmir_letter.odr_id', $request->input('id'))
			-> select(DB::raw('mealmir_letter.id,user_r.user_email,user_p.id as user_id,mealmir_letter.letter_con,mealmir_letter.letter_create,mealmir_letter.post_id'))
			//-> groupBy('mealmir_order.id','mealmir_user.user_email','mealmir_order.order_create','mealmir_order.order_number')
			-> orderBy('mealmir_letter.id')
			-> get();
		//dump($data);
		return view('web.letterlist', ['user_id' => session('user_id'),
			'user_name' => session('user_name'),
			'user_pic' => session('user_pic'),
			'order_id' => $request->input('id'),
			'infoPath' => 'Activity',
			'ltr_data' => $data]);
    }
    //信息保存
    public function ltrSave(Request $request) { 
    		$user_id = DB::table('mealmir_order')->where('id',$request->input('id'))->value('order_user');
		DB::table('mealmir_letter')->insert(
		    ['odr_id' => $request->input('id'), 
		    'user_id' => $user_id,
		    'post_id' => session('user_id'),
		    'letter_con' => $request->input('letter_con')]
		);
		return redirect('/inbox?id='.$request->input('id'));
    }
    //我的订单列表
    public function myOdrList(Request $request) {    		
		$actList = DB::table('mealmir_order');
		$data = $actList
			-> leftJoin('mealmir_activity', 'mealmir_activity.id', '=', 'mealmir_order.act_id')
			-> leftJoin('mealmir_letter', 'mealmir_order.id', '=', 'mealmir_letter.odr_id')
			-> where('mealmir_order.order_user', session('user_id'))
			-> select(DB::raw('mealmir_order.id,mealmir_activity.act_name,mealmir_activity.id as act_id,mealmir_order.order_create,mealmir_order.order_number,count(mealmir_letter.id) as letters'))
			-> groupBy('mealmir_order.id','mealmir_activity.act_name','mealmir_activity.id','mealmir_order.order_create','mealmir_order.order_number')
			-> orderBy('mealmir_order.id', 'desc')
			-> get();
		//dump($data);
		$script = '';
		if ($request->input('status') == 'success') {
			$script = '<script>alert("reservation success！");</script>';
		}
		return view('web.myodrlist', ['user_id' => session('user_id'),
			'user_name' => session('user_name'),
			'user_pic' => session('user_pic'),
			'infoPath' => 'Order',
			'script' => $script,
			'odr_data' => $data]);
    }
    //我的信息列表
    public function myLtrList(Request $request) {    		
		$ltrList = DB::table('mealmir_letter');
		$data = $ltrList
			-> leftJoin('mealmir_order', 'mealmir_letter.odr_id', '=', 'mealmir_order.id')
			-> leftJoin('mealmir_activity', 'mealmir_activity.id', '=', 'mealmir_order.act_id')
			-> leftJoin('mealmir_user as user_r', 'user_r.id', '=', 'mealmir_letter.user_id')
			-> leftJoin('mealmir_user as user_p', 'user_p.id', '=', 'mealmir_letter.post_id')
			-> where('mealmir_order.order_user', session('user_id'))
			-> where('mealmir_letter.odr_id', $request->input('id'))
			-> select(DB::raw('mealmir_letter.id,user_p.user_email,user_p.id as user_id,mealmir_letter.letter_con,mealmir_letter.letter_create,mealmir_letter.post_id'))
			//-> groupBy('mealmir_order.id','mealmir_user.user_email','mealmir_order.order_create','mealmir_order.order_number')
			-> orderBy('mealmir_letter.id')
			-> get();
		//dump($data);
		return view('web.letterlist', ['user_id' => session('user_id'),
			'user_name' => session('user_name'),
			'user_pic' => session('user_pic'),
			'order_id' => $request->input('id'),
			'infoPath' => 'Order',
			'ltr_data' => $data]);
    }
    //我的信息保存
    public function myLtrSave(Request $request) { 
    		$user_id = DB::table('mealmir_order')->where('id',$request->input('id'))->value('order_user');
		DB::table('mealmir_letter')->insert(
		    ['odr_id' => $request->input('id'), 
		    'user_id' => $user_id,
		    'post_id' => session('user_id'),
		    'letter_con' => $request->input('letter_con')]
		);
		return redirect('/myinbox?id='.$request->input('id'));
    }
    //编辑个人信息
    public function editPro(Request $request) { 
		return view('web.editpro', ['user_id' => session('user_id'),
			'user_name' => session('user_name'),
			'user_pic' => session('user_pic'),
			'script' => '']);
    }
    //编辑个人信息保存
    public function editProSave(Request $request) { 
    		if (DB::table('mealmir_user')->where([['id', '=', session('user_id')],['user_password', '=', md5($request->input('old_pwd'))]])->value('id')) {
    			DB::table('mealmir_user')->where('id', session('user_id'))->update(['user_password' => md5($request->input('new_pwd')), 'user_name' => $request->input('user_name')]);
    			return view('web.editpro', ['user_id' => session('user_id'),
			'user_name' => session('user_name'),
			'user_pic' => session('user_pic'),
			'script' => '<script>alert("Success!");</script>']);
    		} else {
    			return view('web.editpro', ['user_id' => session('user_id'),
			'user_name' => session('user_name'),
			'user_pic' => session('user_pic'),
			'script' => '<script>alert("Wrong Password.");</script>']);
    		}
    		
    }
	//保存头像
	public function savePhoto(Request $request) {
		$img = $_FILES['photo'];
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
		DB::table('mealmir_user')->where('id', session('user_id'))->update(['user_pic' => $img_name]);
		session(['user_pic' => $img_name]);
    		return redirect('/myaccount');
	}
	//提交用户评价
	public function comment(Request $request) {
		if (session('user_id')) {
			DB::table('mealmir_comment')->insert(
			    ['act_id' => $request->input('id'), 
			    'com_user' => session('user_id'), 
			    'act_user' => $request->input('uid'),
			    'com_content' => $request->input('comment'),
			    'star_val' => $request->input('star')]
			);
			return redirect('/actshow?id='.$request->input('id').'&status=success');
		} else {
			
			return redirect('/login');
		}
		
	}
	//用户评价列表
    public function revDetail(Request $request) {    		
		$actList = DB::table('mealmir_comment');
		$data = $actList
			-> where('act_user', $request->input('id'))
			-> orderBy('id', 'desc')
			-> get();
			$booking = 0;
		if (session('user_id')) {
			if (DB::table('mealmir_order')->where('act_id', $request->input('id'))->where('order_user', session('user_id'))->where('order_status', '0')->first()) {
				$booking = 1;
			}
		}
		$userdata = DB::table('mealmir_user')
			-> where('id', $request->input('id'))
			-> first();
		//dump($data);
		return view('web.review', ['user_id' => session('user_id'),
			'user_name' => session('user_name'),
			'user_pic' => session('user_pic'),
			'user_book' => $booking,
			'act_data' => $userdata,
			'com_data' => $data]);		
    }
    //用户订阅
    public function subscribe(Request $request) {
    		if (session('user_id')) {
    			if (!(DB::table('mealmir_subscribe')->where('sub_user',session('user_id'))->where('act_user',$request->input('id'))->first())) {
	    			DB::table('mealmir_subscribe')->insert(
				    ['act_user' => $request->input('id'), 
				    'sub_user' => session('user_id')]
				);
				
	    		}
	    		return redirect('/mysublist');
    		} else {
    			echo ('<script>alert("Login Please！");window.location.href="/login?url='.$_SERVER["HTTP_REFERER"].'";</script>');
    		}
    		
    }
    //用户订阅列表
    public function subList(Request $request) {
    		$data=DB::table('mealmir_subscribe')
    			->leftJoin('mealmir_user','mealmir_user.id','=','mealmir_subscribe.act_user')
    			->leftJoin('mealmir_activity','mealmir_activity.act_user','=','mealmir_subscribe.act_user')
    			->where('mealmir_subscribe.sub_user',session('user_id'))
    			->groupBy('mealmir_user.id','mealmir_user.user_name')
    			->select(DB::raw('mealmir_user.id,mealmir_user.user_name,count(mealmir_activity.id) as act_count'))
    			->get();
    		return view('web.sublist', ['user_id' => session('user_id'),
			'user_name' => session('user_name'),
			'user_pic' => session('user_pic'),
			'infoPath' => 'Sublist',
			'odr_data' => $data]);
    }
    //用户取消订阅
    public function unsubscribe(Request $request) {
    		DB::table('mealmir_subscribe')
    			->where('sub_user',session('user_id'))
    			->where('act_user',$request->input('id'))
    			->delete();
    		return redirect('/mysublist');
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
