<?php
namespace app\widgets;
/**
 *  
 * 
 * @author SUN KANG
 *
 */
 
class Jquery extends Base{

	
	function run(){
		 	
	}
	
	
	function load(){
		$baseUrl = $this->asssets('jquery');
		$this->scriptLink[] = $baseUrl.'jquery.js';
		 
		
	}
	
}

 