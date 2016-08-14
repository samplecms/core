<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------

namespace app\helper;
use app\model\Post;
use app\model\Type;
class Db{

    static function post($id){
         return Post::where('_id',$id)->find();
    }


	static function posts(){
		 return Post::order('sort','desc')->order('_id','desc')->paginate(10);
	}

    static function types(){
         return Type::order('sort','desc')->order('_id','desc')->paginate(10);
    }

    static function posts_types($title){

         $m = Type::where('name',$title)->find();
         if($m){
            $id = (string)$m->_id;
            $type = Post::where('type',$id)->find();
            
            $count = Post::where('type',$id)->count();
            if($count==1){
                return ['model'=>Post::where('type',$id)->find(),'count'=>$count,'seo'=>$type->title];
            }
            $all = Post::where('type',$id)
                     ->order('sort','desc')
                     ->order('_id','desc')
                     ->paginate(10);
            return ['model'=>$all,'count'=>$count,'seo'=>$type->title];
         }      
           
    }

    static function type($id){
         return Type::where('_id',$id)->find();
    }

}