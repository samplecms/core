<?php
// +----------------------------------------------------------------------
// | 自动生成表单及列表 功能。
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\admin\controller;
 
use app\common\FieldSave;

class Field extends \app\common\AdminController{
	//允许没有权限访问规则 
	public $allowAction;
	 
	public $m;

	public function init(){

		parent::init();
		$this->m = new FieldSave;
        $this->m->theme = $this->theme;
        $this->m->url = 'admin/field/';
        $this->m->hook = 'admin.field.';

        $this->m->view_list = 'index';
        $this->m->view_form = 'form';
		
	}
	 


	public function index($eqtype,$sort = null)
    { 

    	return $this->m->index($eqtype,$sort);
    }
    
     

    public function jump($type){

       return $this->m->jump($type);
    }
     
    public function create($eqtype,$id=null)
    {
    	 
    	return $this->m->create($eqtype,$id);
    }

    public function sort($eqtype,$page=null){

        return $this->m->sort($eqtype,$page);

    }
    
    public function save($eqtype,$id = null){
    	return $this->m->save($eqtype,$id);
    	
    }
    


    
    


 

}