<?php
// +----------------------------------------------------------------------
// | 字段 
// +----------------------------------------------------------------------
// | Copyright (c) 20016
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;


class Field
{
	
	  
	/**
	*  静态方法实现
	*/
 	static function __callStatic($method,$par = []){  
 			$arr = $par[0];
 			$str = self::_start();
			$str .= Form::label($arr['label'])."\n";
			$str .= Form::$method($arr['field'],['value'=>$arr['value'],'data'=>$arr['data'],'class'=>'form-control'])."\n";
			$str .= self::_end($arr['field']);
			return $str;
  	}
	
	static function editor($arr = []){
		$str = self::text($arr);
		widgets('Redactor',['ele'=>'#'.$arr['field']]);
		return $str;
	}
	
	
	static function upload($arr = []){
		$str = self::_start();
		$str .= Form::label($arr['label'])."\n";
		$str .= widgets('Plupload',[
 	  			'ele'=>$arr['field'],
 	  			'option'=>[
 					'maxSize'=>'100',
 					'class'=>'picture',
 					'count'=>1	,
 					'data'=>$arr['value'],
  					'url'=>url('admin/upload/index'),
  					'urlHash'=>url('admin/upload/hash'),
 		  		]
 		]);
 		$str .= self::_end($arr['field']);
 		return $str;
	}
	
	 
	
	static function _start(){
		return '<div class="form-group">'."\n";
	}
	
	static function _end($field){
		return "<div class='error error_".$field."'></div></div>"."\n";
	}
}
