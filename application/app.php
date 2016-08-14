<?php
$c['menu'] = [
		
	'文章' => 'Post',	
	
	'分类' => 'Type',

	'管理员' => 'UserAdmin',
	'退出系统' => 'admin/index/logout',
];

$c['minify_css'] = true;
$c['minify_js'] = true;
$c['minify_html'] = true;
$c['version'] = "2.0";
$c['host'] = "http://t0.wstaichi.com";

$c['helper']['title'] = [
	'index.index.index'=>'起合|吴式太极拳',
	'index.index.view'=>'上海太极拳,孙康太极拳,',
];

$c['seo']['keywords'] = [
	'index.index.index'=>'test1',
	'index.index.view'=>'查看',

];

$c['seo']['description'] = [
	'index.index.index'=>'test2',
	'index.index.view'=>'查看',

];

return $c;