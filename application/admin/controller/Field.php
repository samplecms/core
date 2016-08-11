<?php
// +----------------------------------------------------------------------
// | 自动生成表单及列表 功能。
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\admin\controller;
use app\common\db\Field as Model;
use app\common\Field as FieldForm;
use app\common\Hook;
class Field extends \app\common\AdminController{
	//允许没有权限访问规则 
	public $allowAction;
	
	public $field;
	protected $field_class;
	protected $m;
	public $url;
	public $title;
	public function init(){
		parent::init();
		
		
	}
	
	protected function __set_load($eqtype){
		$this->field = ucfirst($eqtype);
		$a =  "\app\common\\field\\".$this->field;
		$this->field_class = new $a;
		$this->url = url('admin/field/index',['eqtype'=>$this->field]);
		$this->title = $this->field_class->title;
	}
	public function index($eqtype)
    {
		 
    	$this->__set_load($eqtype);
    	$this->__m();
        $this->m->set_filed_class_name($eqtype);
        $m = $this->m;
        Hook::listen('admin.field.index',$m);

        $field0 = \app\common\Arr::get($this->field_class->field)['k'];
    	
    	$data['list'] = $m->paginate($this->field_class->page?:10);
    	$data['title'] = $this->title;
    	$data['type'] = $this->field;
        $data['field0'] = $field0;
        $data['sort'] = $this->field_class->support_query_sort()?"sort_table ajax_form":"";
    	return $this->make('index',$data);
    }
    
    
    protected function __m(){
    	//设置验证规则
    	$rule  = $this->field_class->rule;
    	$message  = $this->field_class->message;
    	$a = "\app\common\model\Field";
    	$a::reset_table($this->field_class->table);
    	 
    	$this->m = new $a();
    }
    

    public function jump($type){

        $this->success('操作成功', url('admin/field/index',['eqtype'=>$type]) , '',1);
    }
     
    public function create($eqtype,$id=null)
    {
    	 
    	$this->__set_load($eqtype);
    	$this->__m();
    	$action = url('admin/field/save',['eqtype'=>$eqtype,'id'=>$id]);
    	if($id){
    		$values = $this->m->find($id)->toArray();
    	}
    	$field  = $this->field_class->field;
    	foreach($field as $k=>$v){
    		$ele_data = $v['data'];
    		unset($datas,$attr);
    		if(is_string($ele_data)){
    			$ele_data = explode('::',$ele_data);
    			$q1 = $ele_data[0];
    			$q2 = $ele_data[1];
    			$ns =  "\app\common\\field\\".$q1;
    			$datas = $ns::$q2();
    		}elseif(is_array($ele_data)){
    			$datas = $ele_data;
    		}
    		$type1 = $v['element'];
    		$attr['label'] = $v['label'];
    		$attr['value'] = $values[$k];
            $attr['option'] = $v['option'];
    		if($datas){
    			$attr['data'] = $datas;
    		}
    		$attr['field'] = $k;
    		$form.= FieldForm::$type1($attr);
    	}
        Hook::listen('admin.field.form',$form);
    	$data['form'] = $form;
    	$data['action'] = $action;
    	$data['title'] = $this->title;
    	$data['id'] = $id;
    	$data['type'] = $eqtype;


    	return $this->make('form',$data);
    }

    public function sort($eqtype,$page=null){

        $arr = $_POST['sorttable'];
        $time = time();
        $n  = count($arr);
        
        $m = field_model($eqtype);

        foreach($arr as $id){
            $q = $time+$n;
            
            $m->save(['sort'=>$q],['_id'=>$id]);

            $n = $n-10;
            
        }

        echo json_encode(['msg'=>'排序成功']);
        exit;


    }
    
    public function save($eqtype,$id = null){
    	$this->__set_load($eqtype);
    	//设置验证规则
    	$rule  = $this->field_class->rule;
    	$message  = $this->field_class->message;
    	$a = "\app\common\model\Field";
    	$a::reset_table($this->field_class->table);
    	 
        
    	$this->m = new $a( );
        	 
    	 
    	foreach($_POST as $k=>$v){
			if(!is_array($v)){
				$v = trim($v);
			}
			if($v){
				$data[$k] = $v;
			}
    	}
    	
    	if(count($data)<1){
    		$output['msg'] = ['title'=>'请正确填写！'];
    		$output['status'] = 0;
    		echo json_encode($output);
    		exit;
    	}


        Hook::listen('admin.field.before_save',$data);


        $validate = \think\Loader::validate('Field');
        $validate->rule($rule);
        $validate->message($message);

    	if($id){
            Hook::listen('admin.field.before_update',$data);
            //过滤非允许字段
            $this->field_class->filter_data($data);
            //
    		$result = $this->m->validate('Field.edit')->save($data,['_id'=>$id]);
            $data['_result'] = $result;
            Hook::listen('admin.field.update',$data);
            Hook::listen('admin.field.save',$data);
    	}else{
            Hook::listen('admin.field.before_insert',$data);
            //过滤非允许字段
            $this->field_class->filter_data($data);
            //
    		$result = $this->m->validate('Field.add')->save($data);
            $data['_result'] = $result;
            Hook::listen('admin.field.insert',$data);
            Hook::listen('admin.field.save',$data);
    	}
		
    	
    	 
    	if(false === $result){
    		// 验证失败 输出错误信息
    		$output['msg'] = $this->m->getError();
    		echo json_encode($output);
    		exit;
    	}else{
    		// 验证失败 输出错误信息
    		//$output['msg'] = ['title'=>'成功'];
    		$output['page_goto'] = url('admin/field/jump',['type'=>$eqtype]);
            
    		echo json_encode($output);
    		exit;
    	}
    	
    	
    }
    


    
    


 

}