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

		helper_version(config('version')?:"2.1.0");

		if(is_local()){
			config('host',"");
			config('app_debug',true);
			config('app_trace',true);
		}
 


	}
}