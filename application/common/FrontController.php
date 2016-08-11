<?php
// +----------------------------------------------------------------------
// | 基础控制器
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;
 
use think\Lang;

 
class FrontController extends Acl{


	public $theme = 'default';

	public $allowAction = ['*'];
	
	/**
	 * 可重新定义该函数,实现权限检测
	 */
	public function _check(){
		return cookie('id');
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
		// 开启语言包功能
		//config('lang_switch_on' , true);   
		// 支持的语言列表
		config('lang_list' ,['zh-cn']); 
		// 设定当前语言
		Lang::range('zh-cn');

		

	}
}