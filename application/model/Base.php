<?php
namespace app\model;

use think\Model;
use think\Db;
class Base extends Model{
	public $field_title;
	protected $autoWriteTimestamp = 'datetime';
	protected $createTime = 'create_at';
	protected $updateTime = 'update_at';
	
	protected $table;
	
	// 字段属性
	protected $field = [];


	//每页显示记录
	public $page = 10;
	public $allowField;
	//列表显示字段
	public $query_list ;
	public $query_sort ;
	public $query_form ;
	public $field_label = [
		'title'=>'标题',
		'create_at'=>'创建时间',
	];


	
	/**
	 * 架构函数
	 * @access public
	 * @param array|object $data 数据
	 */
	public function __construct($data = [])
	{
		
		parent::__construct($data);

		$this->init_hook();
	}

	public function init_hook(){

		\app\common\Hook::add('admin.field.index','app\model\Base@queryList');
	}


	//是否支持排序 
	public function support_query_sort(){

		if($this->allowField && in_array('sort', $this->allowField)){
			return true;
		}
		return false;
	}
	

	static function queryList(&$m){
		if($m->allowField && in_array('sort', $m->allowField)){		 
			$sort = $m->support_query_sort();
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