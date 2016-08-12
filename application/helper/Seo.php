<?php
// +----------------------------------------------------------------------
// | 设置网站SEO
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------

namespace app\helper;
class Seo{


	//keywords description
	static function get($type = 'description',$request = null){
		
		if(!$request){
			$ar = helper_current_request();	
			$request = $ar['module'].'.'.$ar['controller'].'.'.$ar['action'];
		}
		
		$arr = config('seo.'.$type);
		$r = $arr[$request];

		if($r){
			return config('helper_seo_set_it_'.$type).$r;
		}
		return config('helper_seo_set_it_'.$type);
	}

	static function set($type = 'description',$title){
		config('helper_seo_set_it_'.$type,$title);
	}



}