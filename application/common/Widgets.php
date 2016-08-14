<?php
// +----------------------------------------------------------------------
// | widgets
// +----------------------------------------------------------------------
// | Copyright (c) 20016
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;
 
 

class Widgets 
{
	static $arr;
	static $namespace = "app\widgets\Base";
	static function start($name,$par){
		$core = self::$namespace;
		if(!class_exists($core)){
			return;
		}
		
		$core::render($name,$par);
		return $core::$output;
	}
	
	static function render($types = ['css','js','js_code','css_code']){
		static::before_render();
		foreach($types as $v){
			echo @static::$arr[$v];
		}
	
	}
	
	static function before_render(){
		$core = self::$namespace;
		if(!class_exists($core)){
			return;
		}
	
		$full = $core::$exists['_unique'];
		if(!$full){
			return;
		}
		$full = $core::level($full);
	
		if(!$full){
			return;
		}
		$js = $css = $jsCode = $cssCode = "";
		foreach ($full as $obj){
			if($obj->scriptLink){
				 
				$js .= helper_link ($obj->scriptLink);
			}
			if($obj->script){
				foreach($obj->script as $v){
					$jsCode .= $v."\n";
				}
			}
	
			if($obj->cssLink){
				 
				$css .= helper_link ($obj->cssLink);
			}
			if($obj->css){
				foreach($obj->css as $v){
					$cssCode .= $v."\n";
				}
			}
	
		}
		if($js){
			static::$arr['js'] = $js;
		}
		if($css){
			static::$arr['css'] = $css;
		}
		if($jsCode){
			$script = "<script type=\"text/javascript\">\n$(function(){\n";
			$script .=$jsCode;
			$script .="\n});\n</script>\n";
			static::$arr['js_code'] = $script;
		}
	
		if($cssCode){
			$script = "<style>\n";
			$script .= $cssCode;
			$script .="\n</style>\n";
			static::$arr['css_code'] = $script;
		}
	}
	
	
}