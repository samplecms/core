<?php
namespace app\widgets;
/**
 *   
 * 
 * 如有问题请在微博中 @太极拳那点事儿 http://weibo.com/sunkangchina
 *
 */
 
class  Colorbox extends Base{

	public $ele = ".colorbox";

	public $theme = 2;
	
	function run(){
			
	}
	
	
	function load(){

		$baseUrl = $this->asssets('colorbox');
		$this->scriptLink[] = $baseUrl.'jquery.colorbox-min.js';
		$this->cssLink[] = $baseUrl.'example'.$this->theme.'/colorbox.css';
 		if(!$this->option){
			 $this->option = [
			 	 
			 ];
 		}
 		$op = $this->toJson($this->option);
		$this->script[] = "
				 
				$('".$this->ele."').colorbox(".$op.");
		";
		
	}
	
}

 