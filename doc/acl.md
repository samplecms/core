后台权限简单说明

控制器继承   \app\common\AdminController 

如

	class Login extends \app\common\AdminController{
		//允许没有权限访问规则 
		public $allowAction = ['index'];
		//任何用户都可以访问
		public function index(){
		
		}
		//没权限的用户是不能访问的
		public function logout(){
		
		}
		
	}
	
