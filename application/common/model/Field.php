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
use think\Db;

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

	/**
     * 获取当前模型的数据库查询对象
     * @access public
     * @return Query
     */
    public function db()
    {
        $model = $this->class;
       // if (!isset(self::$links[$model])) {
            // 设置当前模型 确保查询返回模型对象
            $query = Db::connect($this->connection)->model($model);
            // 设置当前数据表和模型名
            if (!empty($this->table)) {
                $query->setTable($this->table);
            } else {
                $query->name($this->name);
            }
            if (!empty($this->field)) {
                if (true === $this->field) {
                    $type = $this->db()->getTableInfo('', 'type');
                } else {
                    $type = [];
                    foreach ((array) $this->field as $key => $val) {
                        if (is_int($key)) {
                            $key = $val;
                            $val = 'varchar';
                        }
                        $type[$key] = $val;
                    }
                }
                $query->setFieldType($type);
                $this->field = array_keys($type);
                $query->allowField($this->field);
            }
            if (!empty($this->pk)) {
                $query->pk($this->pk);
            }
            self::$links[$model] = $query;
      //  }
        // 返回当前模型的数据库查询对象
        return self::$links[$model];
    }
	 



}