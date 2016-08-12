<?php
// +----------------------------------------------------------------------
// | 管理员
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\model;
use app\common\Hook;
class UserAdmin extends Base{
	public $field_title = '管理员';
	public $table = 'users';
	
 	public $allowField = ['user','pwd','email','status','sort'];
	public $message = [
			'user.require'  =>  ['user'=>'用户名必须'],
			'user.min'  =>  ['user'=>'用户名字符不少于3'],
			'user.unique'  =>  ['user'=>'用户名已存在'],
			'email.require'  =>  ['email'=>'邮箱必须'],
			'email.email'  =>  ['email'=>'邮箱格式错误'],
			'pwd' => ['pwd'=>'密码必须'],
	];
	
	
	public $rule = [
			'user'  =>  'require|min:3|unique:users,user',
			'email' => 'require|email',
			'pwd' =>  'require',
	];
	
	public $field_form = [
		'user'=>[
			'label'=>'用户名',	
			'element'=>'input',
				
		],
		'email'=>[
				'label'=>'邮箱（用于）',
				'element'=>'email'
		],
		
		'pwd'=>[
				'label'=>'密码(修改时可为空)',
				'element'=>'password'
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
			'add'   =>  ['user','email'],
			'edit'  =>  ['email'],
	];



	public function init_hook(){
		parent::init_hook();
		Hook::add('admin.field.before_save','app\model\UserAdmin@before_save');
		Hook::add('admin.field.before_update','app\model\UserAdmin@before_update');


		
	}
	
	

	static function before_save(&$data){
		$value = $data['pwd'];
		if(!trim($value)){
            return;
        }
        $data['pwd'] = password_hash(trim($value),PASSWORD_DEFAULT);

	}

	static function before_update(&$data){

		unset($data['user']);
	}

	
	
	


	static function login($data = []){
		$model = field_model('UserAdmin')->find();
		$m = $model->user;
		if(!$m){
			$m = field_model('UserAdmin');
			$data['user'] = 'admin';
			$data['pwd'] = '123456';
			$data['email'] = 'admin@admin.com';
       		$result = $m->validate('User.add')->save($data);
       		if(false === $result){
	            // 验证失败 输出错误信息
	            $output['msg'] = $m->getError();
	            $output['status'] = 0;
	            echo json_encode($output);
	            exit;
	        }
			exit;
		}
		 
		if(!$data){
			$output['msg'] = ['user'=>'error'];
            $output['status'] = 0;
            echo json_encode($output);
            exit;
		}
		$captcha = trim($_POST['captcha']);
		if(!captcha_check($captcha)){
		 	$output['msg'] = ['captcha'=>'验证码错误'];
            $output['status'] = 0;
            echo json_encode($output);
            exit;
		};

		$model = field_model('UserAdmin')->find();

		if ( password_verify($data['pwd'],$model->pwd) ) {
			$output['msg'] = ['user'=>'登录成功'];
             
            $opt = ['expire'=>0];
            cookie('admin_id',$model->_id,$opt);
            cookie('admin_user',$model->user,$opt);
            cookie('admin_email',$model->email,$opt);
            $output['page_goto'] = url('admin/index/index');
            echo json_encode($output);
            exit;

		}else{
            // 验证失败 输出错误信息
            $output['msg'] = ['user'=>'帐号错误'];
            $output['status'] = 0;
            echo json_encode($output);
            exit;
        }



	}


	static function insert($data = []){
		if(!$data){
			$output['msg'] = ['user'=>'error'];
            $output['status'] = 0;
            echo json_encode($output);
            exit;
		}
		$m = field_model('UserAdmin');
        $result = $m->validate('Field.add')->save($data);
        if(false === $result){
            // 验证失败 输出错误信息
            $output['msg'] = $m->getError();
            $output['status'] = 0;
            echo json_encode($output);
            exit;
        }

	}
	 
	
	
	
}