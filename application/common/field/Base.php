<?php
namespace app\common\field;
class Base{
	//每页显示记录
	public $page = 10;
	public $allowField;
	public function __construct(){  
		$this->init();
	}

	public function init(){

		\app\common\Hook::add('admin.field.index','app\common\field\Base@queryList');
	}


	//是否支持排序 
	public function support_query_sort(){

		if($this->allowField && in_array('sort', $this->allowField)){
			return true;
		}
		return false;
	}
	

	static function queryList(&$m){
		if($m->filed_class_name){
			$model = field_class($m->filed_class_name);	
			$sort = $model->support_query_sort();
		}
		
		if($sort)
			$m = $m->order('sort','desc');
		
		$m = $m->order('_id','desc');
	}



	////////////////////////////////////////////////////////////////////////////////
	////
	////////////////////////////////////////////////////////////////////////////////

	//过滤非允许字段          
	public function filter_data(&$data){
			 $allowField = $this->allowField;
             if($allowField){
                foreach($data as $k=>$v){
                    if(!in_array($k,$allowField)){
                        unset($data[$k]);
                    }
                }

             }
             return $data;
	}
}