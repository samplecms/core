
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\model;
use app\common\Hook;
class Post extends Base{
	public $field_title = '文章';
	public $table = 'posts';
	
	public $allowField = ['title','content','type','status','sort','files'];
 
	public $message = [
			'title.require'  =>  ['title'=>'标题必须'],
			'title.min'  =>  ['title'=>'标题字符不少于3'],
			'content' => ['content'=>'内容必须'],
	];
	
	
	public $rule = [
			'title'  =>  'require|min:3',
			'content' =>  'require',
	];
	//列表显示字段
	public $query_list = [
		'title'=>'{value}',
		'create_at'=>"{value}",

	];

	//列表可排序字段 
	public $query_sort = [
		'title','create_at'
	];

	public $query_form = [

		'title'=>[
			
			'element'=>'input',
			'condition'=>[
				['op'=>'like','condition'=>'{value}']
				
			],
				
		],


	];
	

	public $field_label = [
		'title'=>'标题',
		'create_at'=>'创建时间',
	];

	


	public $field_form = [
		'title'=>[
			'label'=>'标题',	
			'element'=>'input',
				
		],
		'content'=>[
				'label'=>'内容',
				'element'=>'editor'
		],
		'files'=>[
				'label'=>'图片',
				'element'=>'upload',
				'option'=>[
					'call'=>"
						$('.form-field-files img').click(function(){
							 	console.log($(this).attr('src'));
								redactor_content.insertHtml('<img src=\"'+$(this).attr('rel')+'\" />');	
						});
						
					",
				]
		],
		'files_search'=>[
				'element'=>'html',
				'option'=>[
					'html'=>
						"
						<a href='/helper/img/ajax' class='ajax_img'>
						<span class='glyphicon glyphicon-search'></span>
						</a>
						<div id='ajax_img'></div>
						"	
					,
					'css'=>"
						.ajax_img{
							position: relative;
						    top: -54px;
						    left: 80px;
						}
					",
					'js'=>"
						ajax_img('.ajax_img','#ajax_img');
				
						function ajax_img(cls,id){
	
						$(cls).click(function(){
					   	 $.post($(this).attr('href'),function(c){
					   		 $(id).html(c);
					   		 
					   		 $(id+' img').click(function(){
					   			 	
					   			redactor_content.insertHtml(\"<img src='\"+$(this).attr('rel')+\"' />\");
					   			 
					   		 });
							$('.img_all_remove').click(function(){
								$(id).html('');
							});
						ajax_img($(id+' a'),'#ajax_img');
					   		 return false;
					   	 });
					   	 
					   	 return false;
					    });
						
					}
					"
				]
					 
			],
		'type'=>[
				'label'=>'分类',
				'element'=>'select',
				'data'=>"Type::element_select",
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
			'add'   =>  ['title','content'],
			'edit'  =>  ['title','content'],
	];
	

	 public function init_hook(){
		parent::init_hook();
		Hook::add('admin.field.before_insert','app\model\Post@before_insert');
		 


		
	}
	
	

	static function before_insert(&$data){
		$data['sort'] = time();
	}


	public function getFilesAttr($value){  
		if(!$value){
			return [ 
				theme_url().'misc/img/slide-2.jpg'
			];
		}
		return $value;
	}
	 
	
	
}