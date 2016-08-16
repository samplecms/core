<?php
// +----------------------------------------------------------------------
// | 基础控制器
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;
 
 

 
class AdminController extends Acl{


	public $theme = 'admin';

	public $allowAction = [];
	
	/**
	 * 可重新定义该函数,实现权限检测
	 */
	public function _check(){
		return cookie('admin_id');
	}

	/**
	 * 可重新定义该函数,实现权限出错提示
	 */
	public function _no_auth_message(){
		throw new \Exception('无权访问当前页面！！！');
		exit();
	}


	public function init(){
		parent::init();
		 
		
		 
		config('host','');
		config('url_html_suffix','');
		config('url_common_param',false);
		config('url_route_on',true);
		config('url_route_must',false);

		config('minify_css',false);
		config('minify_js',false);
		config('minify_html',false);
 
	}
}