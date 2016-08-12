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

        $im = \app\common\Img::get_local_all($content);
        if(!$im){
            return $content;
        }
        foreach($im as $u){
            $n = \app\common\Img::thumb($u,$arr);
            $content = str_replace($u,$n,$content);
        }
        return $content;

    }
}