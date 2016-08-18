<?php
namespace app\index\controller;
use app\helper\Db;
use app\common\Img;
use think\Lang;
use think\Request;
class Pages extends \app\common\FrontController
{
    public $theme = 'business-casual';
    
    public function init(){
        
        parent::init();
         
    }
      

    public function view($id)
    {
        
 		$p = $data['model'] =  Db::post($id);
        $type = $p->title;
        
		
        //title seo
        $this->title = $type;
        $this->description = $type;
        $this->keywords = $type;

        return  $this->make('/weixin',$data);
    }
    
}
