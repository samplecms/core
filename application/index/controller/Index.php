<?php
namespace app\index\controller;
use app\helper\Db;
use app\common\Img;
use think\Lang;
use app\helper\Title;
use app\helper\Seo;
class Index extends \app\common\FrontController
{

	 
    public function index($type = null)
    {
        if($type){
            $m =  Db::posts_types($type);
        }else{
            $m =  Db::posts();    
        }


        Title::set($type);
        Seo::set('keywords',$type);
        Seo::set('description',$type);

        
        $data['type'] = $type;

        if($m['count']){
                $data['model'] = $m['model'];
                if($m['count'] == 1){
                    return  $this->make('/view',$data ); 
                }
        }else{
            $data['model'] = $m;
        }
        
        
        return  $this->make('/index',$data);
    }



    public function view($id)
    {
 		$p = $data['model'] =  Db::post($id);
        $type = $p->title;
        Title::set($type);
        Seo::set('keywords',$type);
        Seo::set('description',$type);

        return  $this->make('/view',$data);
    }
    
}
