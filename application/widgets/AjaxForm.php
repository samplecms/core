<?php
namespace app\widgets;
/**  
 * 
 * @author SUN KANG
 *
 */
 
class  AjaxForm extends Base{

	
	function run(){
			
	}
	
	
	function load(){
		$baseUrl = $this->asssets('ajax_from');
		 
		$this->scriptLink[] = $baseUrl.'jquery.form.js';
		 
		
	}
	
}

 