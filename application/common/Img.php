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
	static function thumb($path,$arr = ['w'=>200,'h'=>200]){
		$ext  = substr($path,strrpos($path,'.'));
		$name = substr($path,0,strpos($path,'.')); 
		foreach($arr as $k=>$v){
			$e .=','.$k.'_'.$v;
		}
		$f = $name.$e.$ext;
		if(substr($f,0,1)=='/')
			$f = substr($f,1);
		$f = substr($f,strpos($f,'/'));
		return '/thumb'.$f;
	} 

}