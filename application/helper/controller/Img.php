<?php
// +----------------------------------------------------------------------
// | 系统内置功能，处理图片生成缩略图
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
/*
RewriteCond %{REQUEST_FILENAME} !\.(jpg|jpeg|png|gif|bmp)$ 
RewriteRule /thumb/(.*)$ /helper/img/thumb?id=$1 [NC,R,L]
*/
namespace app\helper\controller;


class Img{


	public function thumb(){	
			$used = [
				//常量，标识缩略图等比例缩放类型
				1=>\think\Image::THUMB_SCALING,
				//常量，标识缩略图缩放后填充类型
				2=>\think\Image::THUMB_FILLED,
				//常量，标识缩略图居中裁剪类型
				3=>\think\Image::THUMB_CENTER,
				//常量，标识缩略图右下角裁剪类型
				4=>\think\Image::THUMB_NORTHWEST,
 				//常量，标识缩略图右下角裁剪类型	
				5=>\think\Image::THUMB_SOUTHEAST,
				//常量，标识缩略图固定尺寸缩放类型
				6=>\think\Image::THUMB_FIXED,
					
			];
		 	$type = config('thumb.type')?:1;
		 	if($_GET['thumb_type']){
		 		$fun = $used[$_GET['thumb_type']];
		 	}else{
		 		$fun = $used[$type];
		 	}
			
			
			$text = config('thumb.text');
			
			$WEB = realpath(ROOT_PATH.'public');
			$id = $_GET['id'];
			$dir = $WEB.'/thumb/'.$id;
			$ext  = substr($id,strrpos($id,'.'));
			$name = substr($id,0,strpos($id,','));
			$source = $WEB.'/'.$name.$ext;
			$str = substr($id,strpos($id,',')+1); 
			$str = substr($str,0,strrpos($str,'.'));
			$arr = explode(',',$str);
			foreach($arr as $vo){
				$v = explode('_',$vo);
				$list[$v[0]] = $v[1];
			}
			$w = $list['w']?:'auto';
			$h = $list['h']?:'auto';
			$ex = substr($dir,0,strrpos($dir,'/'));
			  
			if(!is_dir($ex)) mkdir($ex,0775,true);
			 
			$image = \think\Image::open($source);
			// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
			if($text)
				$image->text($text,APP_PATH.'font/衡山毛筆KouzanBrushFont.ttf',20,'#fff');
			
			
			$image->thumb($w, $h,$fun)->save($dir);
			 
			$c = file_get_contents($dir);
			echo $c;

	}

}