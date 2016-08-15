<?php
// +----------------------------------------------------------------------
// | File
// +----------------------------------------------------------------------
// | Copyright (c) 20016 
// +----------------------------------------------------------------------
// | Author: sunkangchina <weichat>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\model\Upload;

class File extends \app\common\AdminController{

	public function fixedposition($id,$di){
		 
		$m = Upload::where('_id',$id)->find();
		$name = $m->name;
		$file = public_path().$name;
		$image = \think\Image::open($file);
		$image->rotate($di)->save($file);
		
		
		$url = public_path().\app\common\Img::thumb($m->name,['w'=>200,'h'=>'200']);
		$url = str_replace('//', '/', $url);
		@unlink($url);
		return $this->success('操作成功',url('admin/file/index'),null,1);
	}
	
	public function index(){
		$m = Upload::order('sort','desc')->order('_id','desc')->paginate(8);
		
		return $this->make('index',['model'=>$m]);
	}
	
	
	public function remove($id){
		$m = Upload::where('_id',$id)->find();
		$m->delete();
		return $this->success('删除成功',url('admin/file/index'),null,1);
	}
	
	

}