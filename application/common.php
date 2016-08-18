<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
 

// 应用公共文件


if(!function_exists('get_ip')){

	/**
	 * 获取客户端IP地址
	 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
	 * @return mixed
	 */
	function get_ip($type = 0)
	{
		$type      = $type ? 1 : 0;
		static $ip = null;
		if (null !== $ip) {
			return $ip[$type];
		}
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$pos = array_search('unknown', $arr);
			if (false !== $pos) {
				unset($arr[$pos]);
			}
			$ip = trim($arr[0]);
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (isset($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		// IP地址合法验证
		$long = sprintf("%u", ip2long($ip));
		$ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
		return $ip[$type];
	}

}

if(!function_exists('is_local')){

	function is_local(){
		if(in_array(get_ip(), ['127.0.0.1','::1'])){
			return true;
		}		
		return false;
	}
}

if(is_local() === true){
	ini_set('display_errors',1);
	error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));
}else{
	ini_set('display_errors',0);
	error_reporting(0);
}


if(!function_exists('dump')){

	function dump($str){
		print_r('<pre>');
		print_r($str);
		print_r('</pre>');

	}

}

if(!function_exists('get_domain')){

	function get_domain(){

		return $_SERVER['HTTP_HOST'];
	}

}

//自定义字段 生成列表 页URL
if(!function_exists('field_url_index')){

	function field_url_index($type){
		return url('admin/field/index',['eqtype'=>$type]);
	}

}


if(!function_exists('field_url_create')){

	function field_url_create($type){
		return url('admin/field/create',['eqtype'=>$type]);
	}

}
 
if(!function_exists('widgets')){

	function widgets($name=null,$par=null){
		$in = ['js_code','css_code','js','css'];
		if($name && !in_array($name,$in) ){
			return \app\common\Widgets::start($name,$par);
		}
		return \app\common\Widgets::render();
	}

}

if(!function_exists('field_model')){
 //字段MODEL 
 function field_model($eqtype){
 	return __field_model($eqtype)['model'];
 }
 function field_class($eqtype){
 	return __field_model($eqtype)['class'];
 }

 function __field_model($eqtype){
 		$eqtype = ucfirst($eqtype);
 		static $_model;
 		 
 		
 		if($_model[$eqtype]){
 			return $_model[$eqtype];
 		}
		 
 		$a =  "\app\model\\".$eqtype;
        $_model[$eqtype]['model'] = new $a;
        $_model[$eqtype]['class'] = $a;


        return $_model[$eqtype];


	}
}




if(!function_exists('helper_version')){

	function helper_version($version = null){
		if($version){
			config('helper.version',$version);
		}
		return config('helper.version');
	}

}

if(!function_exists('public_path')){
	
	function public_path(){
		return realpath(__DIR__.'/../public').'/';
	}
	
}


if(!function_exists('minify_html')){
	function minify_html($data){
		return \app\common\Minify::html($data);
	}
}


if(!function_exists('minify_css')){
	function minify_css(){
		return \app\common\Minify::output('css');
	}
}


if(!function_exists('minify_js')){
	function minify_js(){
		return \app\common\Minify::output('js');
	}
}

if(!function_exists('helper_link')){
	//生成不重复的JS CSS
	function helper_link($url,$version = null){
		static $all;

		$type = 'css';
		if(is_string($url) && strpos($url,'.js')!==false){
			$type = 'js';
		}
		
		if(is_array($url)){	

			
			$i++;
			$q = 0;
			foreach($url as $v){
				if($q == 0){
					$type = 'css';
					if(is_string($v) && strpos($v,'.js')!==false){
						$type = 'js';
					}
				}
				

				$q++;
				$link = helper_link($v,$version);
				if(!$all[$link])
					$links[] = $link;
				$all[$link] = $link;

				

			}

			if(config('minify_'.$type) === true){
				return;
			}
			
		
			$go =  implode("\n",$links);
			 
			return $go;
		}

		if(is_local() === true && !$version){
			$version = '1.0.1';
		}

		if(!$version){
			$version = helper_version();
		}
		if(config('minify_js') === true || config('minify_css') === true){
			\app\common\Minify::set($url);
		}

		$url = $url."?v=".$version;
		switch ($type) {
			case 'js':
				if(config('minify_js') === true){
					$link = $url;
				}else{
					$link = '<script type="text/javascript" src="'.$url.'"></script>';	
				}
				
				break;
			
			default:
				if(config('minify_css') === true){
					$link = $url;
				}else{
					$link = '<link rel="stylesheet" href="'.$url.'">';
				}
				break;
		}

		return $link;
	}



}

 
if(!function_exists('theme_load_file')){

	function theme_load_file($file,$ext = '.php'){
		static $c;
		if($c[$info]){
			return $c[$info];
		}
		$info =  config('template.view_path').$file.$ext;
		if(file_exists($info)){
			$c[$info] = include $info;
		}
		return $c[$info];
	}


}

if(!function_exists('theme_include')){

	function theme_include($a){
		$request = think\Request::instance();
		$module  = $request->module();
		$id = $request->controller();
		return   config('template.view_path').$module.DS.$id.DS.$a.'.php';
	}


}

if(!function_exists('output')){
	
	function output(){
		return \app\common\Output::assets();
	}
}

 
if(!function_exists('helper_current_request')){

	function helper_current_request(){
		$request = think\Request::instance();
		$module  = $request->module();
		$id = $request->controller();
		$action = $request->action();
		return   ['module'=>$module,'controller'=>$id,'action'=>$action];
	}


}

 
if(!function_exists('theme_url')){

	function theme_url(){
		$request = think\Request::instance();
		$module  = $request->module();
		$id = $request->controller();
		return   base_url().config('template.view_url');
	}

}

if(!function_exists('theme_html')){

	function theme_html($file,$ext='.html'){
		return  config('template.view_path').$file.$ext;
	}

}

if(!function_exists('obj')){

	function obj($class){
		static $m;
		if(!$m[$class]){
			$m[$class] = new $class;
		}
		return $m[$class];
	}

}

if(!function_exists('is_post')){

	function is_post(){
		return $_SERVER['REQUEST_METHOD']=='POST'?true:false;
	}

}

if(!function_exists('is_ajax')){

	function is_ajax(){
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
if(!function_exists('base_url')){

	function base_url(){
		$request = think\Request::instance();
		return $request->root().DS;
	}

}

if(!function_exists('theme_info')){ 
	
	function theme_info($name){
		
		return theme_load_file('info')[$name];

	}
}

if(!function_exists('clean_mongo_array_injection')){


	///////////////////////////////////////
	// 过滤MONGODB ARRAY中的KEY为$的 $_GET POST COOKIE REQUEST
	///////////////////////////////////////
	function clean_mongo_array_injection(){
		$in = array(& $_GET, & $_POST, & $_COOKIE, & $_REQUEST);
		while (list ($k, $v) = each($in))
		{
			if(is_array($v)){
				foreach ($v as $key => $val)
				{
					if(strpos($key,'$')!==false){
						unset($in[$k][$key]);
						$key = str_replace('$','',$key);
					}
					$in[$k][$key] = $val;
					$in[] = & $in[$k][$key];
				}
			}
		}
	}
	clean_mongo_array_injection();
}


