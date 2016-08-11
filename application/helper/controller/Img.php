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
			$WEB = realpath(ROOT_PATH.'public');
			$id = $_GET['id'];
			$dir = $WEB.'/thumb/'.$id;
			$ext  = substr($id,strrpos($id,'.'));
			$name = substr($id,0,strpos($id,','));
			$source = $WEB.'/upload/'.$name.$ext;
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
			$image->thumb($w, $h)->save($dir);
			 
			$c = file_get_contents($dir);
			echo $c;

	}

}