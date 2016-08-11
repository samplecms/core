<?php
// +----------------------------------------------------------------------
// | 权限
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;
 
 

 
class Acl extends Controller{


	public $theme = 'admin';

	/**
	 * 权限控制
	 *　值可以为 当前的action也可以是完整的module.id.action或id.action
	 */
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
		$arr = helper_current_request();
		$this->module = strtolower($arr['module']);
		$this->id = strtolower($arr['controller']);
		$this->action= strtolower($arr['action']);	

		if(!$this->_auth_check()){
			$this->_no_auth_message();
		}

	}


	protected function _auth_check(){
		if(!$this->_access() && !$this->_check()){
				return false;
		}
		return true;
	}



	protected function _access(){
		if(!$this->allowAction) return false;
		foreach($this->allowAction as $v){
			if($v=='*'){
				return true;
			}else{
	
				$arr = explode('.',$v);
				$i = count($arr);
				$module = $this->module;
				$id = $this->id;
				$action = $this->action;
				switch($i){
					case 1:
						$check1 = $this->module.".".$this->id.".".$arr[0];
						if($arr[0]=="*"){
							$action = "*";
						}
						break;
					case 2:
						$check1 = $this->module.".".$arr[0].".".$arr[1];
						if($arr[1]=="*"){
							$action = "*";
						}
						if($arr[0]=="*"){
							$id = "*";
						}
						break;
					case 3:
						$check1 = $arr[0].".".$arr[1].".".$arr[2];
						if($arr[2]=="*"){
							$action = "*";
						}
						if($arr[1]=="*"){
							$id = "*";
						}
						break;
				}
	
				$check = strtolower($module.".".$id.".".$action);
				if($check == $check1  ){
					return true;
				}
			}
				
		}
	 
		return false;
	
	}


}