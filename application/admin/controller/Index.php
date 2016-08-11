<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\admin\controller;
use app\common\field\UserAdmin as Model;

class Index extends \app\common\AdminController{
	//允许没有权限访问规则 
	public $allowAction = ['login'];


	public function index()
    { 
        
    	return $this->make('index');
    }

    public function logout()
    { 
         /*cookie('admin_id', null);
         cookie('admin_user', null);
         cookie('admin_email', null);*/
         $this->success('退出系统成功', url('admin/index/login'));

    }


	public function login()
    {
        if(is_ajax()){
        	Model::login($_POST);
        		
        }
        

        return $this->make('login');
    }

}