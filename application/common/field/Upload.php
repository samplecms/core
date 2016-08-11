<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common\field;
use app\common\Hook;
class Upload extends Base{
	public $title = '上传文件';
	public $table = 'system_upload';
	
	public $allowField = [

						'name' ,
						'extension',
						'mime',
						'size',
						'hash' ,
						'sort',
						'uid',
	];
 
	public $message = [
			'name.require'  =>  ['name'=>'标题必须'],
			
			'size' => ['size'=>'大小是必须'],
	];
	
	
	public $rule = [
			'name'  =>  'require',
			'size' =>  'require',
	];
	
	public $field = [
		 
		
	];
	 
	
	
	public $scene = [
			'add'   =>  ['name','size'],
			'edit'  =>  ['name','size'],
	];
	

	  
	 
	
	
}