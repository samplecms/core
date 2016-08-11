<?php
namespace app\widgets;

use app\common\Arr as arr;
use app\common\File as file;
use think\Request;

class Base{
	public $load;
	public $ele;
	public $par = [];
	public $script;
	public $scriptLink;
	public $css;
	public $cssLink;
	static $exists;
	public $option;
	public $version = 1.0;
	public $id;
	protected $request;
	static $output;
	function __construct(){
		$this->request = Request::instance();
		$this->init();
	}
	function init(){
		$this->option = array_key_exists('option', $this->par)?$this->par['option']:[];
		if($this->ele){
			$this->id = substr($this->ele,1);
		}elseif($this->id){
			$this->ele = "#".$this->id;
		}
	}

	function toJson($arr){
		return json_encode($arr,JSON_PRETTY_PRINT);
	}
	function asssets($name){
		$dir = 'assets/'.$name.'/';
		$to = APP_PATH.'/../public/'.$dir;
		if(!is_dir($to)){
			@file::cpdir(__DIR__.'/'.$dir,$to);
		}
		return $this->request->root().'/'.$dir;
	}

	static function render($name,$par = []){

		$over = "\widgets\\".$name;
		$core = "\\app\widgets\\".$name;
		$e = "";

		if(class_exists($over)){
			$e = $over;
		}elseif(class_exists($core)){
			$e =  $core;
		}
			
		$obj = self::$exists[$e];
		if(!$obj && class_exists($e)){
			$obj = new $e;
			self::$exists[$e]  = $obj;
		}



		if(is_object($obj) && $par){
			foreach($par as $k=>$v){
				$obj->$k = $v;
			}

		}
		if($obj){
				
			if(method_exists($obj,'load') && !$obj->load[$name]){
				$obj->load();
				$obj->load[$name] = true;
			}
				
			static::$output = $obj->run();
		}

		self::$exists['_unique'][$name] = $obj;
		return self::$exists['_unique'];
		
	}

	static function level($full){
		$i = 1000000;
		foreach($full as $k=>$v){
			$j = $v->level;
			if($j){
				$out[$j][$k] = $v;
				$out[$j]['level'] = $j;
			}else{
				$out[$i][$k] = $v;
				$out[$i]['level'] = $j;
			}
			$i--;
		}

		$out = arr::order_by($out,'level',SORT_DESC);
		foreach($out as $v){
			foreach($v as $key=>$value){
				if($key == 'level'){
					continue;
				}
				$new[$key] = $value;
			}
		}
		return $new;
	}
}