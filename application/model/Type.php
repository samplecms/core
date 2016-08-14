<?php
// +----------------------------------------------------------------------
// | 分类
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\model;
class Type extends Base{
	public $field_title = '分类';
	public $table = 'type';
	
	public $allowField = ['title','status','sort','name'];
	
	public $message = [
			'title.require'  =>  ['title'=>'标题必须'],
			'title.min'  =>  ['title'=>'标题字符不少于3'],
			'name.require'  =>  ['name'=>'唯一标识必须'],
			'name.unique'  =>  ['name'=>'唯一标识重复'],
	];
	
	
	public $rule = [
			'title'  =>  'require|min:3',
			'name'=>'require|unique:type,name'
	];
	
	public $field_form = [
		'title'=>[
			'label'=>'标题',	
			'element'=>'input',
				
		],
			
		'name'=>[
				'label'=>'唯一标识',
				'element'=>'input',
		
		],
		
		'status'=>[
				'label'=>'状态',
				'element'=>'select',
				'data'=>[
					1=>'启用',
					-1=>'禁用',
					
				]
		],
			
	];
	 
	
	
	public $scene = [
			'add'   =>  ['title','name'],
			'edit'  =>  ['title','name'],
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