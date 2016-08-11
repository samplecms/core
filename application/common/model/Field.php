<?php

// +----------------------------------------------------------------------
// | 字段模型
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------

namespace app\common\model;

use think\Model;


class Field extends Model
{
	
	protected $autoWriteTimestamp = 'datetime';
	protected $createTime = 'create_at';
	protected $updateTime = 'update_at';
	
	protected $table;
	
	// 字段属性
	protected $field = [];
	
	static $reset_table;
	static $reset_field;

	public $filed_class_name;
	/**
	 * 架构函数
	 * @access public
	 * @param array|object $data 数据
	 */
	public function __construct($data = [])
	{
		
		parent::__construct($data);
		
		$this->table = self::reset_table();
		$this->field = self::reset_field();
		
		
		
	}
	//filed_class_name 对应 app\common\field\*
	public function set_filed_class_name($name){
		$this->filed_class_name = $name;
	}
	 
	static  function reset_field($field = [] ){
		if(!$field){
			return self::$reset_field;
		}
		self::$reset_field = $field;
	}
	
	static  function reset_table($table = null){
		if(!$table){
			return self::$reset_table;
		}
		self::$reset_table = $table;
	}





}