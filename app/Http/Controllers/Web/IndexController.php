<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
	//首页
    public function index(Request $request) {
    		$cityClass = DB::table('mealmir_city');
    		$cityData = $cityClass
    			-> limit(6)
    			-> get();
    		$newsData = DB::table('mealmir_news')
    			-> limit(6)
    			-> orderBy('id','desc')
    			-> get();
    		$actClass = DB::table('mealmir_activity');
    		$actData = $actClass
			-> leftJoin('mealmir_city', 'mealmir_activity.act_location', '=', 'mealmir_city.id')
			-> leftJoin('mealmir_user', 'mealmir_activity.act_user', '=', 'mealmir_user.id')
    			-> limit(6)
    			-> where('mealmir_activity.act_status', '=', '1')
    			-> orderBy('id','desc')
    			-> select('mealmir_activity.*','mealmir_city.city_name','mealmir_city.con_name','mealmir_user.user_pic')
    			-> get();
    		if (count($actData)>0) {
    			for ($x=0; $x<count($actData); $x++) {
		  		$comData = DB::table('mealmir_comment')
					-> select(DB::raw('ceil(avg(star_val)) as star_val, count(*) as reviews'))
					-> where('act_user',$actData[$x]->act_user)
					-> where('com_status',1)
					-> first();
			    $actData[$x]->star_val = $comData->star_val;
			}
    		}
    		
    		//dump($actData);

    		
		return view('web.index', ['user_id' => session('user_id'),
			'city_data' => $cityData,
			'act_data' => $actData,
			'news_data' => $newsData,
			'user_pic' => session('user_pic'),
			'user_name' => session('user_name')]);
	}
	//新闻列表
	public function newsList(){
		$newsData = DB::table('mealmir_news')
    			-> orderBy('id','desc')
    			-> get();
		return view('web.news', ['user_id' => session('user_id'),
			'news_data' => $newsData,
			'user_pic' => session('user_pic'),
			'user_name' => session('user_name')]);
	}
	//城市列表
	public function citiesList(){
		$citysData = DB::table('mealmir_city')
    			-> orderBy('id','desc')
    			-> get();
		return view('web.cities', ['user_id' => session('user_id'),
			'citys_data' => $citysData,
			'user_pic' => session('user_pic'),
			'user_name' => session('user_name')]);
	}
	//新闻显示
	public function newsShow(Request $request){
		$newsData = DB::table('mealmir_news')
    			-> where('id',$request->input('id'))
    			-> first();
		return view('web.infoshow', ['user_id' => session('user_id'),
			'news_data' => $newsData,
			'user_pic' => session('user_pic'),
			'user_name' => session('user_name')]);
	}
	//关于我们
	public function aboutUs(Request $request){
		$newsData = DB::table('mealmir_about')
    			-> first();
		return view('web.about', ['user_id' => session('user_id'),
			'news_data' => $newsData,
			'user_pic' => session('user_pic'),
			'user_name' => session('user_name')]);
	}
	//活动列表
	public function listings(Request $request){
    		$claData = DB::table('mealmir_class') -> get(); 
    		$cityData = DB::table('mealmir_city') -> get();			
		
    		$listDb = DB::table('mealmir_activity');
		$listDb
			-> leftJoin('mealmir_city', 'mealmir_activity.act_location', '=', 'mealmir_city.id')
			-> leftJoin('mealmir_user', 'mealmir_activity.act_user', '=', 'mealmir_user.id')
			-> select('mealmir_activity.*','mealmir_city.city_name','mealmir_city.con_name','mealmir_user.user_pic');
		
		if ($request->input('search_keywords')) {
    			$listDb	-> where('mealmir_activity.act_name', 'like', '%'.$request->input('search_keywords').'%');
		}
		if ($request->input('search_location')) {
    			$listDb	-> where('mealmir_activity.act_location', '=', $request->input('search_location'));
		}
		if ($request->input('user_id')) {
			$listDb	-> where('mealmir_activity.act_user', '=', $request->input('user_id'));
		}
		if ($request->input('search_categories')) {
			$listDb	-> where('mealmir_activity.act_class', '=', $request->input('search_categories'));
		}
		if ($request->input('search_keywords') && !($request->input('search_location')) && !($request->input('search_categories'))) {
		$listDb
			-> orWhere('mealmir_city.city_name', 'like',  '%'.$request->input('search_keywords').'%')
			-> orWhere('mealmir_city.con_name', 'like', '%'.$request->input('search_keywords').'%');
		}
		$listDb -> where('mealmir_activity.act_status', '=', '1');
		$listData = $listDb -> get();
    		
    		for ($x=0; $x<count($listData); $x++) {
	  		$comData = DB::table('mealmir_comment')
				-> select(DB::raw('ceil(avg(star_val)) as star_val, count(*) as reviews'))
				-> where('act_user',$listData[$x]->act_user)
				-> where('com_status',1)
				-> first();
		    $listData[$x]->star_val = $comData->star_val;
		}

		return view('web.listings', ['user_id' => session('user_id'),
			'list_data' => $listData,
			'list_data1' => $listData,
			'cla_data' => $claData,
			'city_data' => $cityData,
			'user_pic' => session('user_pic'),
			'user_name' => session('user_name')]);
	}
	//活动详情
	public function actShow(Request $request){
		$actData = DB::table('mealmir_activity')
			-> leftJoin('mealmir_city', 'mealmir_activity.act_location', '=', 'mealmir_city.id')
			-> leftJoin('mealmir_class', 'mealmir_activity.act_class', '=', 'mealmir_class.id')
			-> leftJoin('mealmir_user', 'mealmir_activity.act_user', '=', 'mealmir_user.id')
			-> select('mealmir_activity.*','mealmir_city.city_name','mealmir_city.con_name','mealmir_class.class_title','mealmir_user.user_email','mealmir_user.user_create','mealmir_user.user_pic','mealmir_user.user_name')
			-> where('mealmir_activity.id',$request->input('id'))			
			-> first();
		$booking = 0;
		if (session('user_id')) {
			if (DB::table('mealmir_order')->where('act_id', $request->input('id'))->where('order_user', session('user_id'))->where('order_status', '0')->first()) {
				$booking = 1;
			}
		}
		$comData = DB::table('mealmir_comment')
			 -> select(DB::raw('ceil(avg(star_val)) as star_val, count(*) as reviews'))
			 -> where('act_user',$actData->act_user)
			 -> where('com_status',1)
			 -> first();
		$subData = DB::table('mealmir_subscribe')
			-> where('act_user',$actData->act_user)
			-> count();
		$odrData = DB::table('mealmir_order')
			-> where('act_id',$actData->id)
			-> sum('order_number');
		$script = '';
		if ($request->input('status')) {
			$script = '<script>alert("Success!Please wait for review！");</script>';
		}
		
		return view('web.actshow', ['user_id' => session('user_id'),
			'act_data' => $actData,
			'user_pic' => session('user_pic'),
			'user_book' => $booking,
			'com_data' => $comData,
			'subData' => $subData,
			'odrData' => $odrData,
			'script' => $script,
			'user_name' => session('user_name')]);
	}
	//活动详情预览
	public function actShowPrev(Request $request){
		$actData = DB::table('mealmir_activity')
			-> leftJoin('mealmir_city', 'mealmir_activity.act_location', '=', 'mealmir_city.id')
			-> leftJoin('mealmir_class', 'mealmir_activity.act_class', '=', 'mealmir_class.id')
			-> leftJoin('mealmir_user', 'mealmir_activity.act_user', '=', 'mealmir_user.id')
			-> select('mealmir_activity.*','mealmir_city.city_name','mealmir_city.con_name','mealmir_class.class_title','mealmir_user.user_email','mealmir_user.user_create','mealmir_user.user_pic','mealmir_user.user_name')
			-> where('mealmir_activity.id',$request->input('id'))
			-> first();
		$booking = 0;
		if (session('user_id')) {
			if (DB::table('mealmir_order')->where('act_id', $request->input('id'))->where('order_user', session('user_id'))->where('order_status', '0')->first()) {
				$booking = 1;
			}
		}
		$comData = DB::table('mealmir_comment')
			 -> select(DB::raw('ceil(avg(star_val)) as star_val, count(*) as reviews'))
			 -> where('act_user',$actData->act_user)
			 -> where('com_status',1)
			 -> first();
		$odrData = DB::table('mealmir_order')
			-> where('act_id',$actData->id)
			-> sum('order_number');		
		$subData = DB::table('mealmir_subscribe')
			-> where('act_user',$actData->act_user)
			-> count();
		return view('web.actshow', ['user_id' => session('user_id'),
			'act_data' => $actData,
			'user_pic' => session('user_pic'),
			'user_book' => $booking,
			'com_data' => $comData,
			'odrData' => $odrData,
			'subData' => $subData,
			'script' => '',
			'user_name' => session('user_name')]);
	}
	//活动申请
	public function actApply(Request $request){
		if (session('user_id')) {
			if (time() < $request->input('start')) {
			//未到预订时间
			echo ('<script>alert("reservation is not due！");window.history.go(-1);</script>');
			} elseif (time() > $request->input('end')) {
				//超过预订时间
				echo ('<script>alert("overbooking！");window.history.go(-1);</script>');
			} else {
				DB::table('mealmir_order')->insert(
				    ['act_id' => $request->input('id'), 
				    'order_user' => session('user_id'),
				    'order_number' => $request->input('application')]
				);
				return redirect('/myodrlist?status=success');
			}
			
		} else {
			echo ('<script>alert("Login Please！");window.location.href="/login?url='.$_SERVER["HTTP_REFERER"].'";</script>');
		}
	}
	
	//活动申请测试
	public function actApplyPre(Request $request){
		if (time() < $request->input('start')) {
			//未到预订时间
			echo(date("Y-m-d H:i:s",$request->input('start')));
			echo('<br>');
			echo(date("Y-m-d H:i:s",$request->input('end')));
			echo('<br>');
			echo(date("Y-m-d H:i:s",time()));
			echo('<br>');
			echo ('reservation is not due!');
			echo strtotime("2018-09-16 05:30:00");
			echo('<br>');
			echo($request->input('start'));
			echo date_default_timezone_get(); 
		}
		if (time() > $request->input('end')) {
			//超过预订时间
			echo(date("Y-m-d H:i:s",$request->input('start')));
			echo('<br>');
			echo(date("Y-m-d H:i:s",$request->input('end')));
			echo('<br>');
			echo(date("Y-m-d H:i:s",time()));
			echo('<br>');
			echo ('overbooking!');
			echo strtotime("2018-09-16 05:30:00");
			echo('<br>');
			echo($request->input('start'));
			echo date_default_timezone_get(); 
		}
	}
	
	public function verifyUser(Request $request) {
		$data = DB::table('mealmir_user')->where('id',$request->input('id'))->first();
		if (md5($data->id.$data->user_create) == $request->input('token')) {
			DB::table('mealmir_user')->where('id',$request->input('id'))->update(['user_verify' => 1]);
			echo ('<script>alert("Activate success！");window.location.href="/login";</script>');
		}
	}
	//发送邮件
	public function sendMail(Request $request) {
		$name = '陈浩';
        // Mail::send()的返回值为空，所以可以其他方法进行判断
        Mail::send('mail.mail',['name'=>$name],function($message){
            $to = 'haroldchan@hotmail.com';
            $message ->to($to)->subject('邮件测试');
        });
        echo 'ok';
	}
}
