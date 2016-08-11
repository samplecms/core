<?php
// +----------------------------------------------------------------------
// | 主题支持，public/themes/default,public/themes/blue. 当模板文件不存在时将使用默认的view
// +----------------------------------------------------------------------
// | Copyright (c) 20016
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\common;
use think\Controller;
use think\Config;
use think\Request;
use think\View;
use think\App;
use think\Log;
 

class Theme extends Controller
{
    public $theme;
    protected static $view_instance;
    static $default_view_setting;
    public function __construct(Request $request = null)
    {
        $this->init();
        return parent::__construct($request);
    }

    public function init(){
        if($this->theme){
            $this->set_theme($this->theme);
        }
    }
    
    
	protected function set_theme($name = null ){
		$tmp = Config::get('template');
        if(!self::$default_view_setting){
            self::$default_view_setting = $tmp;
        }
        if(!$name){
            return Config::set('template',self::$default_view_setting); 
        }
        if($name){
            $tmp['view_path'] = realpath(APP_PATH.'../public/themes/'.$name). DS;
            $tmp['view_url'] = 'themes/'.$name. DS;
        }else{
            $tmp['view_path'] = "";
        }
		 
        Config::set('template',$tmp); 
	}

    protected function _theme_view($template,$bool = true){
            $m = $this->request->module();
            $c = $this->request->controller();
            $a =  $template?:$this->request->action();
            if(substr($a,0,1)=='/'){
                    $file =  Config::get('template.view_path').substr($a,1).'.'.Config::get('template.view_suffix');
                    $template = $a;
            }   
            else{
                $file =  Config::get('template.view_path').$m.DS.$c.DS.$a.'.'.Config::get('template.view_suffix'); 
                if($bool === true){
                    $template = $m.DS.$c.DS.$a;
                }else{
                    $template = $a;
                }

            }
            return [$file,$template];
    }
    /**
     * 加载模板输出
     * @access protected
     * @param string $template 模板文件名
     * @param array  $vars     模板输出变量
     * @param array $replace     模板替换
     * @param array $config     模板参数
     * @return mixed
     */
    public function make($template = '', $vars = [], $replace = [], $config = [])
    {
        $view = $this->view;
        if($this->theme){
            $gt = $this->_theme_view($template);
            $file = $gt[0];
            $template_new = $gt[1];
            
            if(!is_file($file)){
                $this->set_theme();
                $gt = $this->_theme_view($template,$bool = false);
                $file = $gt[0];
                $template_new = $gt[1];
                Log::record("主题文件不存在".$file,'notice');
                $this->set_theme('');
                if (is_null(self::$view_instance)) {
                    self::$view_instance = new View(Config::get('template'), Config::get('view_replace_str'));
                }
                $view =  self::$view_instance;
            }else{
                
                Log::record("主题文件使用".$file,'notice');

            }


        }
        
        
        return $view->fetch($template_new, $vars, $replace, $config);
                
    }
}