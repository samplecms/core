<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------

namespace app\helper;
class Db{

    static function post($id){
         return field_model('Post')->where('_id',$id)->find();
    }


	static function posts(){
		 return field_model('Post')->order('sort','desc')->order('_id','desc')->paginate(10);
	}

    static function types(){
         return field_model('Type')->order('sort','desc')->order('_id','desc')->paginate(10);
    }

    static function posts_types($title){

         $m = field_model('Type')->where('title',$title)->find();
         if($m){
            $id = (string)$m->_id;
             
            return field_model('Post')
                    ->where('type',$id)
                     ->order('sort','desc')
                     ->order('_id','desc')
                     ->paginate(10);
         }      
         return field_model('Post')->order('sort','desc')->order('_id','desc')->paginate(10);   
    }

    static function type($id){
         return field_model('Type')->where('_id',$id)->find();
    }

}