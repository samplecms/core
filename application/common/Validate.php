<?php
// +----------------------------------------------------------------------
// | Validate
// +----------------------------------------------------------------------
// | Copyright (c) 20016
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;
 
class Validate extends \think\Validate{


	
    public  $custom_rule_msg = [
         ///

         'my_unique'      => ':attribute已存在',

    ];

     public function __construct(array $rules = [], $message = [])
    {
    	parent::__construct( $rules , $message );
    	foreach($this->custom_rule_msg as $k=>$v){
    		self::setTypeMsg($k,$v);
    	}
    }

	 /**
     * 验证是否唯一
     * @access protected
     * @param mixed     $value  字段值
     * @param mixed     $rule  验证规则 格式：数据表,字段名,排除ID,主键名
     * @param array     $data  数据
     * @param string    $field  验证字段名
     * @return bool
     */
    protected function my_unique($value, $rule, $data, $field)
    {
    	
        if (is_string($rule)) {
            $rule = explode(',', $rule);
        }
        $db  = \think\Db::name($rule[0]);
        $key = isset($rule[1]) ? $rule[1] : $field;
        if (strpos($key, '^')) {
            // 支持多个字段验证
            $fields = explode('^', $key);
            foreach ($fields as $key) {
                $map[$key] = $data[$key];
            }
        } elseif (strpos($key, '=')) {
            parse_str($key, $map);
        } else {
            $map[$key] = $data[$field];
        }
        $pk = strval(isset($rule[3]) ? $rule[3] : $db->getPk());
        if (isset($rule[2])) {
            $map[$pk] = ['neq', $rule[2]];
        } elseif (isset($data[$pk])) {
            $map[$pk] = ['neq', $data[$pk]];
        }
        
        if($_GET['id']){
        	$find = $db->where($key,$value)->find();
        	$fid = (string)$find['_id'];
        	if($fid && $fid != $_GET['id']){
        		return false;
        	}
        	return true;
        }exit;


        if ($db->where($map)->field($pk)->find()) {
            return false;
        }
        return true;
    }



}