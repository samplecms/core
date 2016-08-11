<?php
namespace app\widgets;
/**  
 * 
 * @author SUN KANG
 *
 */
 
class  Font extends Base{

	
	function run(){
			
	}
	
	
	function load(){
		$baseUrl = $this->asssets('Font-Awesome-4.6.3');
		 
		$this->cssLink[] = $baseUrl.'css/font-awesome.css';
		 
		
	}
	
}

 