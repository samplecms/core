<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"/Library/WebServer/Documents/www/www/public/themes/admin/admin/field/index.html";i:1471097932;s:67:"/Library/WebServer/Documents/www/www/public/themes/admin/admin.html";i:1471153357;}*/ ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo theme_info('title'); ?></title>


<?php echo helper_link([
base_url().'misc/bootstrap/css/bootstrap.min.css',
base_url().'misc/Flat-UI/dist/css/flat-ui.min.css',
theme_url().'misc/css.css',

]); ?>
 
<?php echo widgets('Font'); ?>
<?php echo widgets('JqueryUi'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body id='body'>

 
<div class="container" id='page'>

<div class="row">
  <div class="col-xs-2 menu_left"  id='left' >
  		<?php $admin_menu_list = app\helper\Comm::admin_menu(); ?>
  		<div class="list-group ">
   				<?php if(is_array($admin_menu_list) || $admin_menu_list instanceof \think\Collection): $key = 0; $__LIST__ = $admin_menu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($key % 2 );++$key;?>
				<a href="<?php echo $v; ?>" class='list-group-item  <?php  if(strpos($_SERVER["REQUEST_URI"],$v)!==false){ echo "list-group-item-info";} ?> '>
					<?php echo $key; ?><?php echo $eqtype; ?>
				</a>
				<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>

  		
    
  </div>
  <div class="col-xs-10 main" id='main'> 
    	
	

<p><?php echo $title; ?>

<a href="<?php echo url('admin/field/create',['eqtype'=>$type]); ?>">
<span class='label label-info'>创建</span>
</a>

 

</p>

<form method="post" class="<?php echo $sort; ?>" action="<?php echo url('admin/field/sort',['eqtype'=>$type]); ?>">
    <div class='info'></div>
    <table class="table table-bordered " >
      <thead>
        <tr>
          <th>标题</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <tr>
          <th><?php echo $v->$field0 ?>
          <input type='hidden' value="<?php echo $v['_id']; ?>" name="sorttable[]">
          </th>
          <td>
          	<a class='glyphicon glyphicon-edit' href="<?php echo url('admin/field/create',['eqtype'=>$type,'id'=>$v['_id']]); ?>"></a>
          </td>
        </tr>
      <?php endforeach; endif; else: echo "" ;endif; ?>
        
      </tbody>
    </table>
    <input type="submit" id='submit' value="保存排序?" style='display: none;'>
 </form>
  	<?php echo $list->render(); ?>  
    

  </div>
</div>


</div>






<?php echo helper_link([
base_url().'misc/jquery.js',
base_url().'misc/jquery.form.js',
base_url().'misc/jquery.pajax.js',
base_url().'misc/Flat-UI/dist/js/flat-ui.min.js',
theme_url().'misc/js.js',
]); ?>
 
 
<?php echo widgets(); ?>


 </body>
</html>