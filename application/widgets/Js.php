<?php
namespace app\widgets;
/**
 *  
 * 
 * @author SUN KANG
 *
 */
 
class Js extends Base{

	public $js_code;
	public $css_code;
	function run(){
		 	
	}
	
	
	function load(){
		if($this->js_code)
			$this->script[] = $this->js_code;
		if($this->css_code)
			$this->css[] = $this->css_code;
	}
	
}

 