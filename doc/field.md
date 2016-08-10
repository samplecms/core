后台字段HOOK

application/common/field 目录中存放内容类型。

如需要修改列表排序使用如下Hook

	public function init(){

		\app\common\Hook::add('admin.field.index','app\common\field\Post@queryList');
	}
	
	

	static function queryList(&$m){
		$m = $m->order('_id','desc');
	}
	
	
	
如文章定义Post.php

<code>

<?php
namespace app\common\field;
class Post extends Base{
	public $title = '文章';
	public $table = 'posts_test';
	
 
	public $message = [
			'title.require'  =>  ['title'=>'标题必须'],
			'title.min'  =>  ['title'=>'标题字符不少于6'],
			'content' => ['content'=>'内容必须'],
	];
	
	
	public $rule = [
			'title'  =>  'require|min:6',
			'content' =>  'require',
	];
	
	public $field = [
		'title'=>[
			'label'=>'标题',	
			'element'=>'input',
				
		],
		'content'=>[
				'label'=>'内容',
				'element'=>'editor'
		],
			
		'type'=>[
				'label'=>'分类',
				'element'=>'select',
				'data'=>"Type::element_select",
		],
	];
	 
	
	
	public $scene = [
			'add'   =>  ['title','content'],
			'edit'  =>  ['title','content'],
	];
	
	
	public function query(){


	}
	
	
	
}
</code>
类型定义Type.php
<code>

<?php
namespace app\common\field;
class Type extends Base{
	public $title = '分类';
	public $table = 'type';
	
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
</code>

以上代码将自动生成文章列表 表单验证等等。
