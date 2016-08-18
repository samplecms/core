<?php
// +----------------------------------------------------------------------
// | {:\app\\common\\Output::assets()}
// +----------------------------------------------------------------------
// | Copyright (c) 20016
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;

class Output{
	static $obj;

	static function assets(){
		if(!static::$obj){
			static::$obj['code'] = widgets();
			static::$obj['css'] = minify_css();
			static::$obj['js'] = minify_js();
		}
		$data = ob_get_contents();
		ob_end_clean();
		$css = static::$obj['css'];
		echo preg_replace_callback('|.*</head>|',function()use($css){
			
			return $css.'</head>';
			
		}, $data);
		echo static::$obj['js'];
		echo static::$obj['code'];
	}
	
	
	
	
	
	 
	
}