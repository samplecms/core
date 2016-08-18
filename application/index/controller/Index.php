<?php
namespace app\index\controller;
use app\helper\Db;
use app\common\Img;
use think\Lang;
use think\Request;
class Index extends \app\common\FrontController
{
    public $theme = 'business-casual';
    
    public function init(){
        
        parent::init();
         
    }
     
	public function index()
    {
     
        return $this->make('/index');
    }
    public function page($type = null)
    {  
         
        if($type){
            $m =  Db::posts_types($type);
        }else{
            $m =  Db::posts();    
        }

 		$type = $m['seo'];
        //title seo
        $this->title = $type;
        $this->description = $type;
        $this->keywords = $type;
        
        $data['type'] = $type;

        if($m['count']){
                $data['model'] = $m['model'];
                if($m['count'] == 1){
                    return  $this->make('/view',$data ); 
                }
        }else{
            $data['model'] = $m;
        }
 

        

         
        return  $this->make('/page',$data);
    }


    


    public function view($id)
    {
        
        
 		$p = $data['model'] =  Db::post($id);
        $type = $p->title;
        
		
        //title seo
        $this->title = $type;
        $this->description = $type;
        $this->keywords = $type;

        return  $this->make('/view',$data);
    }
    
}
