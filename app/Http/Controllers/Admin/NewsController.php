<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
	//新闻列表
    public function index(Request $request) {
		$where[] = ['mealmir_news.news_title', '<>', ''];
		if ($request->input('end')) {
    			$where[] = ['mealmir_news.news_create', '>=', urldecode($request->input('start'))];
    			$where[] = ['mealmir_news.news_create', '<=', urldecode($request->input('end'))];
		}
    		if ($request->input('keyWords')) {
    			$orWhere[] = ['mealmir_news.news_title', 'like', '%'.$request->input('keyWords').'%'];
    			//$orWhere[] = ['mealmir_user.user_email', 'like', '%'.$request->input('keyWords').'%'];
    			
    			$news = DB::table('mealmir_news')
	            
	            ->where($orWhere)
	            ->orderBy('id', 'desc')
	            ->get();
    		} else {
    			$news = DB::table('mealmir_news')
	            
	            ->where($where)
	            ->orderBy('id', 'desc')
	            ->get();
    		}
    		return view('admin.news', ['adminUser' => session('adminInfo.userName'),
	    		'adminPath' => $request->path(),
	    		'newsData' => $news]);
    		
    }
    //编辑新闻
    public function editNews(Request $request) {
    		if ($request->input('stas') == 9) {
    			//删除
    			DB::table('mealmir_news')->where('id', $request->input('id'))->delete();
			return back()->withInput();
    		} else {
    			$newsData = DB::table('mealmir_news')
    				->where('id', $request->input('id'))
	    			->first();
	    		return view('admin.editnews', ['adminUser' => session('adminInfo.userName'),
	    			'adminPath' => $request->path(),
	    			'newsData' => $newsData,    			
				'script' => '']);
	    }    		
    }
    //保存更新新闻
    public function saveNews(Request $request) {
 		$img = $_FILES['newsPic'];
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
    			DB::table('mealmir_news')->where('id', $request->input('id'))
	    			->update(['news_title' => $request->input('newsTitle'),'news_pic' => $img_name,'news_content' => $request->input('newsContent')]);
    		} else {
    			DB::table('mealmir_news')->insert(['news_title' => $request->input('newsTitle'),'news_pic' => $img_name,	'news_content' => $request->input('newsContent')]);
    		}		
    		return redirect('/admin/news/index');	
    }
    //添加新闻
    public function addNews(Request $request) {
    		return view('admin.addnews', ['adminUser' => session('adminInfo.userName'),
    			'adminPath' => $request->path(),
			'script' => '']);
    }
    //关于我们
    public function aboutUs(Request $request)  {
    		$newsData = DB::table('mealmir_about')->first();
	    	return view('admin.aboutus', ['adminUser' => session('adminInfo.userName'),
    			'adminPath' => $request->path(),
    			'newsData' => $newsData,    			
			'script' => '']);
    }
    //关于我们-保存
    public function aboutUsSave(Request $request)  {
    		DB::table('mealmir_about')->where('id', 1)
    			->update(['news_content' => $request->input('newsContent')]);
	    	return redirect('/admin/news/about');	
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
