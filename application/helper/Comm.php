<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------

namespace app\helper;
class Comm{


	static function admin_menu(){
		$m = config('app.menu');
        foreach($m as $k=>$v){
            if(strpos($v,'/')===false){
                    $m[$k] = field_url_index($v);
            }else{
                $m[$k] = url($v);
            }
        }
        return $m;
	}

    static function replace_content($content,$arr=['w'=>550,'h'=>300]){
        $im = \app\common\Img::get_local_all($content,true);
        if(!$im){
            return $content;
        }
        $im2 = \app\common\Img::get_local_all($content);
        foreach($im2 as $k=>$u){
        	
            $n = \app\common\Img::thumb($u,$arr);
            $n1 = \app\common\Img::thumb($u,['w'=>800,'h'=>600]);
            
            $img = '<a href="'.$n1.'" class="colorbox"  target="blank" >
            			<img class="img-thumbnail" src="'.$n.'" />
            		</a>';
            $replace = $im[$k];
            $content = str_replace($replace,$img,$content);
        }
        return $content;

    }
}