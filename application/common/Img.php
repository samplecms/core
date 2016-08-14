<?php
// +----------------------------------------------------------------------
// | File
// +----------------------------------------------------------------------
// | Copyright (c) 20016
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;
class Img{

 
	/*	
	*
	*
	*安装 "imagine/imagine": "~0.5.0"
	*手册 http://imagine.readthedocs.org/en/latest/
	*
	*.htaccess 配置 
	*
	*RewriteCond %{REQUEST_FILENAME} !\.(jpg|jpeg|png|gif|bmp)$ 
	*RewriteRule /thumb/(.*)$ /imagine?id=$1 [NC,R,L]
	*
	*图片事例  
	*thumb/201408/53f59659e9217,w_100,h_100.jpeg
	*
	*
	*get('imagine',function(){    
	*	$id = $_GET['id'];
	*	$dir = WEB.'/thum/'.$id;
	*	$ext  = substr($id,strrpos($id,'.'));
	*	$name = substr($id,0,strpos($id,','));
	*	$source = WEB.'/upload/'.$name.$ext;
	*	$str = substr($id,strpos($id,',')+1); 
	*	$str = substr($str,0,strrpos($str,'.'));
	*	$arr = explode(',',$str);
	*	foreach($arr as $vo){
	*		$v = explode('_',$vo);
	*		$list[$v[0]] = $v[1];
	*	}
	*	$w = $list['w']?:'auto';
	*	$h = $list['h']?:'auto';
	*	$ex = substr($dir,0,strrpos($dir,'/'));
	*	if(!is_dir($ex)) mkdir($ex,0775,true);
	*	$imagine = new \Imagine\Gd\Imagine();
	*	// or
	*	//$imagine = new \Imagine\Imagick\Imagine();
	*	// or
	*	//$imagine = new \Imagine\Gmagick\Imagine(); 
	*	$size    = new \Imagine\Image\Box($w, $h); 
	*	$mode    = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
	*	// or
	*	//$mode    = Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND; 
	*	$imagine->open($source)
	*	    ->thumbnail($size, $mode)
	*	    ->save($dir)
	*	;
	*	$c = file_get_contents($dir);
	*	echo $c;
	*});
	*</code>
	*
	* 
	*/
	/**
	* 生成缩略图
	*
	*<code>
	*需要配置上面的代码Route::get('imagine'......
	* 
	* set('/upload/201408/53f59883545d3jpeg' , ['w'=>400,'h'=>300])
	*
	* 将生成
	* /thumb/201408/53f59883545d3,w_400,h_300.jpeg
	*
	* </code>
	* @param string $path 　 
	* @param string $arr 　 
	* @return  string
	*/
	static function thumb($path,$arr = ['w'=>200,'h'=>200,'thumbtype'=>1]){
		$ext  = substr($path,strrpos($path,'.'));
		$name = substr($path,0,strpos($path,'.')); 
		foreach($arr as $k=>$v){
			$e .=','.$k.'_'.$v;
		}
		$f = $name.$e.$ext;
		if(is_local()){
			config('host',"");
		}
		return config('host').'/thumb'.$f;
	} 

	/**
	* mime 
	*
	* @param string $name 　 
	* @param string $arr 　 
	* @return  string
	*/
	static function mime($name){
		return getimagesize($name)['mime'];
	}
 	 
 	/**
	* 本地的图片,如果存在返回图片的URL 
	*
	* @param string $str 　 
	* @return  string/null
	*/
	static function get_local_one($str){
		return static::local($str , false);
	} 
 	/**
	* 本地的所有图片,如果存在返回图片的URL 
	*
	* @param string $str 　 
	* @return  array/null
	*/
	static function get_local_all($str){
		return static::local($str , true);
	}
 
	/**
	* 不区别本地或线上图片,返回第一个图片的URL 
	*
	* @param string $str 　 
	* @return  string/null
	*/
	static function get_one($str){
		return static::get($str , false);
	}
	 
	/**
	* 不区别本地或线上图片,返回所有图片的URL 
	*
	* @param string $str 　 
	* @return  array/null
	*/
	static function get_all($str){
		return static::get($str , true);
	} 
	/**
	* 移除内容中的图片元素
	*
	* @param string $content 　 
	* @return  string
	*/
	static function remove($content){  
		$preg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i';
		$out = preg_replace($preg,"",$content);
		return $out;
	} 
 
	/**
	* 图片的宽高
	*
	* @param string $img 　 
	* @return  array [w,h]
	*/
	static function wh($img){
		$a = getimagesize($img);
		return array('w'=>$a[0],'h'=>$a[1]);
	}
 	/**
	*  内部函数
	*/
	static function get($content,$all=true){ 
		$preg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i'; 
		preg_match_all($preg,$content,$out);
		$img = $out[2];  
		if($all === true){
			return $img;
		}else if($all === false){
			return $img[0]; 
		}
		return $out[0];
	} 
	/**
	*  内部函数
	*/
	static function local($content,$all=false){  
		$img = static::get($content, true);
		if($img) { 
			$num = count($img); 
			for($j=0;$j<$num;$j++){ 
				$i = $img[$j]; 
				if( (strpos($i,"http://")!==false || strpos($i,"https://")!==false ))
				{
					unset($img[$j]);
				}
			}
		}
		if($all === true){
			return $img;
		}
		return $img[0]; 
	} 







}