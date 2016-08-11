<?php
namespace app\widgets;
/**
 *  
 * 
 * @author SUN KANG
 *
 */
 
class Redactor extends Base{

	
	function run(){
		 	
	}
	
	
	function load(){
		$baseUrl = $this->asssets('redactor');
		$this->scriptLink[] = $baseUrl.'redactor.js';
		$this->cssLink[] = $baseUrl.'redactor.css';
		$this->script[] = "
			
				var redactor_".substr($this->ele,1)." = $('".$this->ele."').redactor({
					fixed: true
				});
			";
		
	}
	
}

 