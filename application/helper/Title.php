<?php
// +----------------------------------------------------------------------
// | 设置网站标题
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------

namespace app\helper;
class Title{



	static function get($request = null){
		
		if(!$request){
			$ar = helper_current_request();	
			$request = $ar['module'].'.'.$ar['controller'].'.'.$ar['action'];
		}
		
		$arr = config('helper.title');
		$r = $arr[$request];

		if($r){
			if(!config('helper_title_set_it')){
				return $r;
			}
			return config('helper_title_set_it').'|'.$r;
		}

		return config('helper_title_set_it');
	}

	static function set($title){
		config('helper_title_set_it',$title);
	}



}