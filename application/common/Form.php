<?php
// +----------------------------------------------------------------------
// | 表单
// +----------------------------------------------------------------------
// | Copyright (c) 20016
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;


/**
*
*<code>
*  
echo Form::open('form',['class'=>'ajax']);
echo Form::label(__('Title'));
echo Form::input('title',['value'=>$post['title'],'class'=>'form-control']);
echo Form::label(__('Content'));
echo Form::text('content',['value'=>$post['content'],'class'=>'form-control']);
echo Form::submit('Submit',[]);
echo Form::close();
* </code>
*/
class Form
{  
	/**
	* 参数
	*/
	static  $par = []; 
	/**
	* 内部函数 ,创建表单元素 
	*
	* @param string $name 　 
	* @param string $type 　 
	* @param string $close 　 
	* @param string $value 　 
	* @return  string
	*/
	static function element($name = null , $type, $close = false,$value=null){
		if($name){ 
			if(!static::$par['id'])
				static::$par['id'] = $name;
			static::$par['name'] = $name; 
		}
		$call = static::$par['call'];
		unset(static::$par['call']);
		if(static::$par){
			foreach(static::$par as $k=>$v){
				if($v && !is_array($v))
					$str .= " $k='{$v}' ";
			}
		}
		if(true === $close)
			$close = "</{$type}>";
		if($type!='label' && $call){
		 	$value2 = static::$par['value'];
		 	if(!$value2 || !is_array($value2)) $value2 = [];
		 	$c = call_user_func($call,$name,$value2);
		}
		
		return "<{$type} $str>".$value.$close.$c;
	}
 	/**
	*  静态方法实现
	*/
 	static function __callStatic($method,$par = []){  
  		$name = $par[0]; 
  		static::$par = $par[1]; 
  		$data = static::$par['data']; 
  		unset(static::$par['element'],static::$par['data'],static::$par['form']);
 		//自动加载POST的值 
 		if(!static::$par['value']){   
	 				static::$par['value'] =  $_POST[$name];
	 		 	if(!static::$par['value'])
	 				static::$par['value'] =  $_GET[$name]; 
		} 
		$value = static::$par['value']; 
 		switch($method){
 			case 'hidden':
 				static::$par['type'] = "hidden";
 				return static::element($name,'input',$data);
 				break;
 			case 'open':
 				unset(static::$par['value']);
 				static::$par['method'] = static::$par['method']?:'POST';
 				return static::element($name,'form');
 				break;
 			case 'close':
 				return "</form>";
 				break;
 			case 'label': 
 				return static::element(NULL,'label',true,$name);
 				break;
 			case 'html': 
 				$html = static::$par['element_code'];
 				unset(static::$par['element_code']);
 				return $html;
 				break;
 			case 'submit':
 				static::$par['value'] = $name?:'submit'; 
 				static::$par['type'] = 'submit'; 
 				return static::element(null,'input');
 				break;
 			case 'input': 
 				return static::element($name,'input');
 				break;
 			case 'file': 
 				static::$par['type'] = 'file'; 
 				return static::element($name,'input');
 				break;	
 			case 'image': 
 				static::$par['type'] = 'file'; 
 				return static::element($name,'input');
 				break; 
 			case 'password':
 				static::$par['type'] = 'password';
 				return static::element($name,'input');
 				break;
 			case 'email':
 				static::$par['type'] = 'email';
 				return static::element($name,'input');
 				break;
			case 'url':
 				static::$par['type'] = 'url';
 				return static::element($name,'input');
 				break;
 			case 'text': 
 				unset(static::$par['value']);
 				return static::element($name,'textarea',true,$value);
 				break;
 			case 'select': 
 				foreach($data as $v=>$label){ 
 					$selected = null;
 					if(is_array($value) && in_array($v,$value))
 						$selected = "selected";	
 					elseif(!empty($value) && $v==$value)  $selected = "selected";
 					
 					$str .= "<option value='".$v."' $selected >".$label."</option>";
 				}
 				return static::element($name,'select',true,$str);
 				break;
 			case 'checkbox':   
 			 	static::$par['type'] = 'checkbox';
 				return static::element($name,'input',false,$data);
 				break;
 			case 'checkboxs':   
 				if(is_array($value)){
 					foreach($value as $v){
 						if(is_array($v)){
 							foreach($v as $_v){
 								$new_value[] = $_v;
 								continue;
 							}
 						}else{
 							$new_value[] = $v;
 						}
 					}
 				}
 				foreach($data as $key=>$data){
	 			 	static::$par['type'] = 'checkbox';
	 			 	static::$par['value'] = $key;
	 			 	unset(static::$par['checked']);
	 			 	if(is_array($new_value) && in_array($key,$new_value)){
	 			 		static::$par['checked'] = 'checked';
	 			 	}
	 				$str .=static::element($name.'[]','input',false,$data);
	 			}
	 			return $str;
 				break;
 		}
 		 
 	}
  
 
	
 
}