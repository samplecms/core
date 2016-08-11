<?php
namespace app\widgets;
/**
 *  
 * 
 * 如有问题请在微博中 @太极拳那点事儿 http://weibo.com/sunkangchina
 *
 */
 
class Tag extends Base{

	
	function run(){
		 	
	}
	
	
	function load(){
		$baseUrl = $this->asssets('jQuery-Tags-Input');
		$this->scriptLink[] = $baseUrl.'src/jquery.tagsinput.js';
		$this->cssLink[] = $baseUrl.'src/jquery.tagsinput.css';
		
		$this->script[] = "
			
				$('".$this->ele."').tagsInput({
					width: 'auto',
					defaultText:'添加标签',
					//	autocomplete_url:'test/fake_json_endpoint.html'
				});
			";
		
		
	}
	
}

 