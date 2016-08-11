<?php
namespace app\widgets;
/*
 *
 * widgets('Plupload',[
 *	  			'ele'=>'file',
 *	  			'option'=>[
 *		  			'CKEDITOR'=>'body',
 *					'maxSize'=>'100',
 *					'class'=>'picture',
 *					'count'=>1	,
 *					'data'=>$data->file,
 * 					'url'=>''
 *		  		]
 *		]);
 *
 * 如有问题请在微博中 @太极拳那点事儿 http://weibo.com/sunkangchina
 *
 */
use app\common\Str as str;
class Plupload extends Base{

	public $version = 1.0;
	public $var ;
	public $uploadBtn;

	function setELE(){
		$this->var =  "uploader_".Str::rand(4);
		$this->uploadBtn = "uploader_btn_".Str::rand(4);
	}
	function run(){

		$this->option['count'] = $this->option['count']?:1;
		$this->option['size'] = $this->option['size']?:5; //10M
		$this->option['maxSize'] = $this->option['maxSize']?:5; //10M
		$this->option['ext'] = $this->option['ext']?:'jpg,jpeg,gif,png';
		$this->option['url'] = $this->option['url']?:"/service/upload/index";
		$this->option['urlHash'] = $this->option['urlHash']?:"/service/upload/hash";
		$this->option['class'] = $this->option['class']?:"upload";
		$this->option['label'] = $this->option['label']?:"上传文件";
		$this->ele = $this->ele?:'file';

		$data = $this->option['data'];

			

		$this->setELE();
		$var = $this->var;

		unset($dataString);
		if($data){
			foreach ($data as $vo){
				$dataString .=  "<div class='pluploadCkeditor '>
					<span class='fa fa-remove pluploadRemoveFile'></span>
					<img class='img-thumbnail' style='5px 5px 0px 0px;width:200px;height:200px;' src='".$vo."' />";
				$dataString .=  "<input type='hidden' name='".$this->ele."[]' value='".$vo."' ></div>";
			}
		}

		$out =  '
				<a  title="'.$this->option['label'].'"id="'.$this->uploadBtn.'" class="'.$this->uploadBtn.' uploader glyphicon glyphicon-upload '.$this->option['class'].'" href="javascript:;"></a>
				<div id="'.$this->uploadBtn.'_percent"></div>
				<div id="'.$this->uploadBtn.'_0" class="uploader">'.$dataString.'</div>
				<script>var globalHashFile = new Array;</script>
			';
		$this->script[] = "
				insertHtmlPlupload();
				pluploadRemoveFile();
				function insertHtmlPlupload(){
					$(\".pluploadCkeditor img\").click(function(){
						var str = '<img src=\"'+$(this).attr(\"src\")+'\"/>';

					});
				}

				function pluploadRemoveFile(){
					$('.pluploadRemoveFile').hide();
					$('.pluploadCkeditor').mouseover(function(){
						$(this).find('.pluploadRemoveFile').show();
					}).mouseout(function(){
							$('.pluploadRemoveFile').hide();
					});
					$('.pluploadRemoveFile').click(function(){
						$(this).parent('.pluploadCkeditor').remove();
					});
				}
		
								"
				;
				if($this->option['CKEDITOR']){
					$str = "insertHtmlPlupload();pluploadRemoveFile();";
				}

				$var = $this->var;

				////CKEDITOR.instances.".$this->option['CKEDITOR'].".insertHtml(str);


				$this->script[] = "
			var ".$var." =
			new plupload.Uploader({
			browse_button: '".$this->uploadBtn."',
			runtimes : 'html5,flash,silverlight,html4',
			url : '".$this->option['url']."',
			max_total_file_count : ".$this->option['count'].",
			
			multipart:true,
			filters : {
				max_file_size : '".$this->option['maxSize']."mb',
				mime_types: [
					{title : \"选择文件\", extensions : '".$this->option['ext']."'}
				]
			},
			rename: true,
			sortable: true,
			dragdrop: true,
			views: {
				list: true
			},
			flash_swf_url : '/assets/plupload/js/Moxie.swf',
			silverlight_xap_url : '/assets/plupload/js/Moxie.xap',
			unique_names: true,
			init: {
				FilesAdded: function(up, files) {
					var files_hash=[];
					var ServerMSG = {
							Checksum : \"Checksumming\",
							Uploaded : \"Uploaded\",
							Unupload : \"Unupload\"

						};
					function hash_file(file, worker) {
						var i, buffer_size, block, threads, reader, blob, handle_hash_block, handle_load_block;
					 	handle_load_block = function(event) {
					 			threads += 1;
					 			worker.postMessage({
					 				'message': event.target.result,
					 				'block': block
					 			});

					 	};
					 	handle_hash_block = function(event) {
					 		threads -= 1;
					 		if (threads === 0) {
					 			if (block.end !== file.size) {
					 				block.start += buffer_size;
					 				block.end += buffer_size;

					 				if (block.end > file.size) {
					 					block.end = file.size;
					 				}
					 				reader = new mOxie.FileReader();
					 				reader.onload = handle_load_block;
					 				blob = file.slice(block.start, block.end);
					 				reader.readAsArrayBuffer(blob);
					 			}
					 		}
					 	};
					 	buffer_size = 64 * 16 * 1024;

					 	block = {
					 		'file_size': file.size,
					 		'start': 0
					 	};

					 	block.end = buffer_size > file.size ? file.size : buffer_size;
					 	threads = 0;

					 	worker.addEventListener('message', handle_hash_block);

					 	reader = new mOxie.FileReader();
					 	reader.onload = handle_load_block;
					 	blob = file.slice(block.start, block.end);
					 	reader.readAsArrayBuffer(blob);
					}
					function handle_worker_event(file,workerObj){
						return function(event){
							if(event.data.result){
								var f = {
									fileName : file.name,
									fileId : file.id,
									fileHash : event.data.result
								};
								files_hash.push(f);
								file.hash = event.data.result;
								if(files_hash.length == files.length){
									send_to_server();
								}
								workerObj.terminate();
						 	}
			
						}

					}

					function handle_file_select(files) {

					 	var i, file, worker;

					 	for (i = 0; i < files.length; i += 1) {
					 		file = files[i].getSource();
					 		file.id = files[i].id;
							files[i].serverMsg = ServerMSG.Checksum;
					 		var workerObj = new Worker('/assets/plupload/js/sha1/worker.sha1.js');
					 		workerObj.addEventListener('message', handle_worker_event(file,workerObj));
					 		isChecksum = true;
					 		hash_file(file, workerObj);
			

					 	}
					}

					function send_to_server(){
						var hash = JSON.stringify(files_hash);
						$.ajax({
							url : '".$this->option['urlHash']."',
							data : {
								files : hash
							},
							type : 'post',
							dataType : 'json',
							success : function(data){
								isChecksum = false;
								$.each(data , function(i,item){
									globalHashFile.push({'id':item.id,'onserver':item.onserver,'hash':item.hash });
			
								});
								up.start();
								$('.plupload_start').removeClass('ui-button-disabled').removeClass('ui-state-disabled');
							}
						});
					}
		

					if (window.applicationCache) {
		 				handle_file_select(files);
					}
					else{
						up.start();
					}

				}
			}

		});
					
				".$var." .bind('UploadProgress', function(up, file) {
             		 $('#".$this->uploadBtn."_percent').html(file.percent+'%');
          		}),

              ".$var." .bind('Error', function(up, err) {
             		 $('#".$this->uploadBtn."_percent').html('上传文件发生错误');
          		}),
			".$var." .bind('FileUploaded', function(up,file,response) {
				$('#".$this->uploadBtn."_percent').html('');
				var res = $.parseJSON(response.response);
				if(res.error){
					$('#'+file.id+ \" .plupload_file_name_wrapper\").css('color','red').html('图片有问题');
				}else{
					var img = \"<img class='img-thumbnail' style='5px 5px 0px 0px;width:200px;height:200px;' src='\"+res.name+\"'/>\";
					var html = \"<div class='pluploadCkeditor'><span class='glyphicon glyphicon-remove pluploadRemoveFile'></span>\"+img+\"<input type='hidden' name='".$this->ele."[]' value='\"+res.name+\"' ></div>\";
					$('#".$this->uploadBtn."_0').append(html);
					".$str."
				}
				pluploadRemoveFile();
			});
			".$var." .init();

		";
		
		
		return $out;		
	}


	function load(){
		$baseUrl = $this->asssets('plupload');

		$this->scriptLink[] = $baseUrl.'js/moxie.js';
		$this->scriptLink[] = $baseUrl.'js/plupload.dev.js';
		$this->css[] = "
			.pluploadCkeditor{
				float:left;
				position:relative ;
			}
			.pluploadRemoveFile {
			    cursor: pointer;
			    position: absolute;
			    top: 6px;
			    left: 168px;
			    color: red;
			}
		";



	}

}