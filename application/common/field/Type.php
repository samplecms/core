<?php
// +----------------------------------------------------------------------
// | 分类
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common\field;
class Type extends Base{
	public $title = '分类';
	public $table = 'type';
	
	public $allowField = ['title','status','sort'];
	
	public $message = [
			'title.require'  =>  ['title'=>'标题必须'],
			'title.min'  =>  ['title'=>'标题字符不少于3'],
	];
	
	
	public $rule = [
			'title'  =>  'require|min:3',
	];
	
	public $field = [
		'title'=>[
			'label'=>'标题',	
			'element'=>'input',
				
		],
		
		'status'=>[
				'label'=>'状态',
				'element'=>'select',
				'data'=>[
					
					0=>'禁用',
					1=>'启用',
				]
		],
			
	];
	 
	
	
	public $scene = [
			'add'   =>  ['title'],
			'edit'  =>  ['title'],
	];
	
	static function element_select(){
		$all = db('type')->order('_id','desc')->select();
		$out[] = '请选择';
		foreach($all as $v){
			$out[(string)$v['_id']] = $v['title'];
		}
		return $out;
	}
	
	
	
}