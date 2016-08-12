<?php
// +----------------------------------------------------------------------
// | 基础控制器
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;
 
 

use think\Cookie;
use think\Session;
class Controller extends Theme{


	public $theme = 'default';


	public function init(){
		parent::init();

		Cookie::prefix(get_domain().'_');
		Session::prefix(get_domain().'_');
		helper_version(config('version')?:"2.1.0");

		if(is_local())
			config('host',"");

		$common = [
			'Arr','Img',
			'File','FieldSave',
			'Hook','Str',
			'WeekMonthDay',
			'Widgets'
		];

		$helper = [
			'Comm','Db',
			'Seo','Title'
		];

		$a = "\app\\common\\";
		$b = "\app\\helper\\";

		foreach($common as $v){
			class_alias($a.$v,strtolower($v));	
		}
		foreach($helper as $v){
			class_alias($b.$v,strtolower($v));	
		}



	}
}