<?php
// +----------------------------------------------------------------------
// | 字段 
// +----------------------------------------------------------------------
// | Copyright (c) 20016
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;


use app\common\db\Field as Model;
use app\common\Field as FieldForm;
use app\common\Hook;
class FieldSave extends \app\common\AdminController{
	
	protected $m;
	public $url_full;
	public $title;
	
	public $url = 'admin/field/';
	public $hook = 'admin.field.';
	public $view_list = 'index';
	public $view_form = 'form';
	protected function load_model($eqtype){
		$this->field = ucfirst($eqtype);
		$a =  "\app\model\\".$this->field;
		$this->m = new $a;
		$this->url_full = url($this->url.'index',['eqtype'=>$this->field]);
		$this->title = $this->m->field_title;
	}


	public function index($eqtype,$sort = null)
    {
        
		 
    	$this->load_model($eqtype);
    	  
        $m = $this->m;

        
        $asc_decs = "desc";

        if($sort){
            $sort_arr = explode(',', $sort);
            $m = $m->order($sort_arr[0],$sort_arr[1]);

            if($sort_arr[1] == 'desc'){
                $asc_decs = 'asc';
            }


        }else{
            Hook::listen($this->hook.'index',$m);
        }

        $qlist = $this->m->query_list;
        $field0 = \app\common\Arr::get($this->m->field_form)['k'];
    	

        ////////////////
        //form
        $query_form  = $this->m->query_form;
        if($query_form){
            foreach($query_form as $k=>$v){
                $ele_data = $v['data'];
                unset($datas,$attr);
                if(is_string($ele_data)){
                    $ele_data = explode('::',$ele_data);
                    $q1 = $ele_data[0];
                    $q2 = $ele_data[1];
                    $ns =  "\app\\model\\".$q1;
                    $datas = $ns::$q2();
                }elseif(is_array($ele_data)){
                    $datas = $ele_data;
                }
                $type1 = $v['element'];
                $attr['label'] = $v['label']?:$this->m->field_label[$k];
                $attr['value'] = $values[$k];
                $attr['option'] = $v['option'];
                if($datas){
                    $attr['data'] = $datas;
                }
                $attr['field'] = $k;
                $form.= FieldForm::$type1($attr);

                $query_condition[$k] = $v['condition'];
            }
        }

        if($_GET){
            foreach ($_GET as $key => $value) {
                $e = $query_condition[$key];
                if($e){
                    foreach ($e as $keys) {

                        $cvalue = str_replace('{value}', $value, $keys['condition']);
                        $op = $keys['op'];
                        
                        $m = $m->where($key,$op,$cvalue);
                    }
                    
                }
            }
        }





        ////////////////


    	$query = $data['list'] = $m->paginate($this->m->page?:10);
        //
        if($qlist){
            foreach($qlist as $k=>$v){
                $show_files[$k] = $k;
            }
            foreach($query as $key => $vo){
                
                 foreach($qlist as $k=>$v){
                     $value = $vo->$k;
                     $v = str_replace('{value}',$value,$v);
                     $vo->$k = $v;
                 }
                 $query[$key] = $vo;
            }
        }else{
            $show_files[$field0] = $field0;
        }


        

    	$data['title'] = $this->title;
    	$data['type'] = $this->field;
        $data['field0'] = $field0;
        $data['sort'] = $this->m->support_query_sort()?"sort_table ajax_form":"";
        $data['show_files'] = $show_files;
        $ls = $this->m->field_label;

        $query_sort = $this->m->query_sort;

        if($query_sort){
            foreach($ls as $k=>$v){
                if(in_array($k,$query_sort)){
                    $ls[$k] = "<a href='".url('admin/field/index',['eqtype'=>$eqtype,'sort'=>$k.','.$asc_decs])."'>$v</a>";
                }
            }
        }
        $data['labels'] = $ls;
        $data['form'] = $form;

    	return $this->make($this->view_list,$data);
    }
    
     

    public function jump($type){

        $this->success('操作成功', url($this->url.'index',['eqtype'=>$type]) , '',1);
    }
     
    public function create($eqtype,$id=null)
    {
    	 
    	$this->load_model($eqtype);
    	 
    	$action = url($this->url.'save',['eqtype'=>$eqtype,'id'=>$id]);
    	if($id){
    		$values = $this->m->find($id)->toArray();
    	}
    	$field  = $this->m->field_form;
    	foreach($field as $k=>$v){
    		$ele_data = $v['data'];
    		unset($datas,$attr);
    		if(is_string($ele_data)){
    			$ele_data = explode('::',$ele_data);
    			$q1 = $ele_data[0];
    			$q2 = $ele_data[1];
    			$ns =  "\app\\model\\".$q1;
    			$datas = $ns::$q2();
    		}elseif(is_array($ele_data)){
    			$datas = $ele_data;
    		}
    		$type1 = $v['element'];
    		$attr['label'] = $v['label']?:$this->m->field_label[$k];
    		$attr['value'] = $values[$k];
            $attr['option'] = $v['option'];
    		if($datas){
    			$attr['data'] = $datas;
    		}
    		$attr['field'] = $k;
    		$form.= FieldForm::$type1($attr);
    	}
        Hook::listen($this->hook.'form',$form);
    	$data['form'] = $form;
    	$data['action'] = $action;
    	$data['title'] = $this->title;
    	$data['id'] = $id;
    	$data['type'] = $eqtype;


    	return $this->make($this->view_form,$data);
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
    	$this->load_model($eqtype);
    	 
    
    	foreach($_POST as $k=>$v){
			if(!is_array($v)){
				$v = trim($v);
			}
			if($v){
				$data[$k] = $v;
			}
    	}


        //////////////
        // Validate
        /////////////

        $rules = $this->m->rule;
        $messages = $this->m->message;
        $scene = $this->m->scene;

        $sc = 'add';
        if($id){
           $sc = 'edit';
        }
        $qr = $scene[$sc];
        if($qr){
            foreach($rules as $k=>$v){
                if(!in_array($k,$qr)){
                        unset($rules[$k]);

                }
            }
        }
        
     

         
        $validate = new \think\Validate($rules,$messages);
          

        if (!$validate->check($data)) {
            $error  = $validate->getError();
            if($error){
                echo json_encode(['msg'=>$error]);
            
                exit;    
            }
            
        }


        if(count($data)<1){
            $output['msg'] = ['title'=>'请正确填写！'];
            $output['status'] = 0;
            echo json_encode($output);
            exit;
        }
    	
    	


        Hook::listen($this->hook.'before_save',$data);


        $validate = \think\Loader::validate('Field');
        $validate->rule($rule);
        $validate->message($message);

    	if($id){
            Hook::listen($this->hook.'before_update',$data);
            //过滤非允许字段
            $this->m->filter_data($data);
            //
    		$result = $this->m->save($data,['_id'=>$id]);
            $data['_result'] = $result;
            Hook::listen($this->hook.'update',$data);
            Hook::listen($this->hook.'save',$data);
    	}else{
            Hook::listen($this->hook.'before_insert',$data);
            //过滤非允许字段
            $this->m->filter_data($data);
            //
    		$result = $this->m->save($data);
            $data['_result'] = $result;
            Hook::listen($this->hook.'insert',$data);
            Hook::listen($this->hook.'save',$data);
    	}
		
    	
    	 
    	if(false === $result){
    		// 验证失败 输出错误信息
    		$output['msg'] = $this->m->getError();
    		echo json_encode($output);
    		exit;
    	}else{
    		// 验证失败 输出错误信息
    		//$output['msg'] = ['title'=>'成功'];
    		$output['page_goto'] = url($this->url.'jump',['type'=>$eqtype]);
            
    		echo json_encode($output);
    		exit;
    	}
    	
    	
    }
    


    
    


 

}