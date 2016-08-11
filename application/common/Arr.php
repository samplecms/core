<?php
// +----------------------------------------------------------------------
// | Array
// +----------------------------------------------------------------------
// | Copyright (c) 20016
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;
 
class Arr{
	static function get($arr , $num = 0){
		$i = 0;
		foreach($arr as $k=>$v){
			if($i==$num){
				return ['k'=>$k,'v'=>$v];
			}
			$i++;
		}
	}
	/**
	 * 所多维数组 转成一维数组
	 *
	 * @param unknown_type $array
	 * @return unknown
	 */
	static function one($array)
	{
		$arrayValues = array();
		$i = 0;
		foreach ($array as $key=>$value)
		{
			if (is_scalar($value) or is_resource($value))
			{
				$arrayValues[$key] =$span.$value;
			}
			elseif (is_array($value) || is_object($value))
			{
				$value = (array)$value;
				$arrayValues = array_merge($arrayValues, self::one($value));
			}
		}
		return $arrayValues;
	}
	/**
	 * 所多维数组 转成一维数组,保留原来的key
	 *
	 * @param unknown_type $array
	 * @return unknown
	 */
	static function one_key($array)
	{
		$arrayValues = array();
		$i = 0;
		foreach ($array as $key=>$value)
		{
			if (is_scalar($value) or is_resource($value))
			{
				$arrayValues[$key] = $value;
			}
			elseif (is_array($value) || is_object($value))
			{
				$value = (array)$value;
				$arrayValues = self::array_merge($arrayValues, self::one($value));
			}
		}
		return $arrayValues;
	}
	static function array_merge($a,$b){
		foreach ($a as $key => $value) {
			$out[$key] = $value;
		}
		foreach ($b as $key => $value) {
			$out[$key] = $value;
		}
		return $out;
	}

	/**
	 *
	 * 对二维数组进行group by操作
	 * @param 数组 $arr
	 * @param group  by 的字段 $group
	 */
	static function group_by($arr,$groupby="sid"){
		static $array = array();
		static $key = array();
		foreach ($arr as $k=>$v){
			$g = $v[$groupby];
			if(!in_array($g,$key)){
				$key[$k] = $g;
			}
			$array[$g][] = $v;
				
		}
		return $array;
	}
	/**
	 * 三维数组转成二维
	 * @param unknown_type $arr
	 */
	static function array_values_one($arr,$exp=null) {
		foreach ( $arr as $v ) {
			if($v){
				foreach ( $v as $val ){
					if($v[$exp]){
						unset($v[$exp]);
					} else
						$new [] = $val;
				}
			}
		}
		return $new;
	}
	/**
	 * 数组排序
	 * arr::order_by($row,$order,SORT_DESC);
	 */
	static function order_by() {
		$args = func_get_args ();
		$data = array_shift ( $args );
		foreach ( $args as $n => $field ) {
			if (is_string ( $field )) {
				$tmp = array ();
				if(!$data) return;
				foreach ( $data as $key => $row )
					$tmp [$key] = $row [$field];
					$args [$n] = $tmp;
			}
		}
		$args [] = &$data;
		if($args){
			call_user_func_array ( 'array_multisort', $args );
			return array_pop ( $args );
		}
		return;
	}
	/*
	 * array_combine存在一个问题，两个array个数必须相同。
	 * 现在的这个函数是为了解决这个问题的
	 * array_combine — Creates an array by using one array for keys and another for its values
	 */
	function array_combine($a,$b){
		$i=0;
		foreach($a as $k){
			$rt[$k] = $b[$i];
			$i++;
		}
		return $rt;
	}

	/**
	 *
	 * 合并数据
	 * accumulated  为true时合并所有值
	 * @param unknown_type $arr
	 * $showky 把 $pk 作为数组key值
	 */
	static function combine($arr,$groupby='sid',$combine_fileds=false){
		$arr = self::array_values_one($arr,$groupby);
		static $new = array();
		foreach($arr as $key => $val){
			foreach($val as $k=>$v){
				$n[$v[$groupby]] = $v;
				foreach($combine_fileds as $c){
					$new[$v[$groupby]][$c] += $v[$c];
				}
			}
		}
		foreach($n as $k=>$v){
			$out[] = array_merge($v,$new[$k]);
		}
		return $out;
	}


}