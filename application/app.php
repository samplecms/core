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
$c['host'] = "http://s0.wstaichi.com";

$c['helper']['title'] = [
	'index.index.index'=>'起合|吴式太极',
	'index.index.view'=>'起合|吴式太极',
];

$c['seo']['keywords'] = [
	'index.index.index'=>'起合|吴式太极,孙康,上海太极拳,孙康太极拳,孙康吴式太极拳',
	'index.index.view'=>'起合|吴式太极,孙康,上海太极拳,孙康太极拳,孙康吴式太极拳',

];

$c['seo']['description'] = [
	'index.index.index'=>'学习太极拳,从今天开始学习太极拳.',
	'index.index.view'=>'学习太极拳,从今天开始学习太极拳.',

];

return $c;