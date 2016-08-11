<?php
// +----------------------------------------------------------------------
// | 日期，周，日，月。返回区间值
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;
   class WeekMonthDay{
	   static function week($n = "+0")
	   {
		   	$timestamp = time()+ ((int)$n*7*86400);
		   	$start =  date('w',$timestamp);
		   	$start = ($timestamp-($start-1)*86400);
		   	return [
		   			strtotime( date('Y-m-d 00:00:00',$start) ),
		   			strtotime( date('Y-m-d 23:59:59',$start) ) + 6 * 86400
		   	];
	   }
	   
	   static function month($n = "+0")
	   {
		   	$timestamp = strtotime($n.' month');
		   	$m = date('Y-m',$timestamp);
		   	$next_month = date('Y-m',strtotime('+1 month' , $timestamp));
		   	
		   	$a = $m."-01 00:00:00";
		   	$b = $next_month."-01 00:00:00";
		   	$b = strtotime($b)-86400;
		   	$b = date('Y-m-d 23:59:59',$b);
		    
		   	
		   	return [
		   			strtotime( $a ),
		   			strtotime( $b ) 
		   	];
	   }
	   
	   
	   static function day($n = "+0")
	   {
	   		$timestamp = strtotime($n.' day');
	   		return [
	   			strtotime(date('Y-m-d 00:00:00',$timestamp)),
	   			strtotime(date('Y-m-d 23:59:59',$timestamp)),
	   		];
	   		
	   }
	   
	   
	   
   }