<?php
// +----------------------------------------------------------------------
// | Minify,自动合并，css js文件，HTML代码合并。
// | {:widgets()}
// | {:minify_css()}  {:minify_js()}
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
/*
$css = [
	'themes/business-casual/misc/css/business-casual.css',
	'themes/business-casual/misc/css/bootstrap.css',
];

echo  \app\helper\Minify::css($css);
*/
namespace app\common;
use MatthiasMullie\Minify as MinifyCore;
class Minify{

	static $file;

	static function set($file){
		static::$file[$file] = $file;
	}


	static function output($type = 'css'){
		if(!static::$file){
			return;
		}
		foreach(static::$file as $v){

			if(strpos($v,'.'.$type) !== false){
				$links[$v] = $v;
			}

		}

		$url = \app\common\Minify::$type($links)."?version=".helper_version();
		if($type=='css'){
			return  '<link rel="stylesheet" href="'.config('host').$url.'">';			
		}elseif($type == 'js'){
			return '<script type="text/javascript" src="'.config('host').$url.'"></script>';	
		}

	}

	static function __find($file){
		if(strpos($file,'?')!==false){
			$file = substr($file,0,strpos($file,'?'));
		}
		return $file;
	}

	static function css($files){
			$key = 'css_'.md5(json_encode($files));
			$url = 'assets/minify/'.$key.'.css';
			$minifiedPath = ROOT_PATH.'public/'.$url;
			if(is_file($minifiedPath)){
				return base_url().$url;
			}

			$dir = \app\common\File::dir($minifiedPath);
			if(!is_dir($dir)){ mkdir($dir,0777,true); }

			$minifier = new MinifyCore\CSS();

			foreach($files as $v){

				$v = static::__find($v);
				
				$load = ROOT_PATH.'public/'.$v;
				 
				if(is_file($load)){

					$v = file_get_contents($load);
				}
				
				$minifier->add($v);	
			}
			 
			$minifier->minify($minifiedPath);

			return base_url().$url;
	}


	static function js($files){
			$key = 'js_'.md5(json_encode($files));
			$url = 'assets/minify/'.$key.'.js';
			$minifiedPath = ROOT_PATH.'public/'.$url;

			if(is_file($minifiedPath)){
				return base_url().$url;
			}

			$dir = \app\common\File::dir($minifiedPath);
			if(!is_dir($dir)){ mkdir($dir,0777,true); }

			$minifier = new MinifyCore\JS();

			foreach($files as $v){
				$v = static::__find($v);

				$load = ROOT_PATH.'public/'.$v;
				 
				if(is_file($load)){

					$v = file_get_contents($load);
				}
				 
				$minifier->add($v);	
			}
			 
			$minifier->minify($minifiedPath);

			return base_url().$url;
	}



	static function html($data){

		$replace = array(
            '/<!--[^\[](.*?)[^\]]-->/s' => '',
            "/<\?php/"                  => '<?php ',
            "/\n([\S])/"                => ' $1',
            "/\r/"                      => '',
            "/\n/"                      => '',
            "/\t/"                      => ' ',
            "/ +/"                      => ' ',
        );
        $data =  preg_replace(
            array_keys($replace), array_values($replace), $data
        );
        return $data;
	}



}