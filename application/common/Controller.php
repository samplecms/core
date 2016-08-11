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
		helper_version("2.1.0");

	}
}