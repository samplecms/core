<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:76:"/Library/WebServer/Documents/www/www/public/themes/business-casual/page.html";i:1471097931;s:76:"/Library/WebServer/Documents/www/www/public/themes/business-casual/base.html";i:1471097932;s:78:"/Library/WebServer/Documents/www/www/public/themes/business-casual/header.html";i:1471141857;s:78:"/Library/WebServer/Documents/www/www/public/themes/business-casual/footer.html";i:1471097931;}*/ ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php if($title): ?><?php echo $title; ?>,<?php endif; ?><?php echo app\helper\Title::get(); ?></title>


<?php echo helper_link([
 
theme_url().'misc/css/business-casual.css',
theme_url().'css.css',

]); ?>
<?php echo widgets('Bootstrap'); ?>

<?php echo helper_link([
base_url().'misc/jquery.js',
base_url().'misc/holder.js',

]); ?>
 
 
<?php echo widgets(); ?>


<?php echo minify_css(); ?>

 

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="<?php echo app\helper\Seo::get('keywords'); ?>" />
<meta name="description" content="<?php echo app\helper\Seo::get('description'); ?>" />


</head>
<body >

 
 
   		
		 
  		 
		 <div class="brand"><a href="/"><?php echo theme_info('title'); ?></a></div>
    <div class="address-bar"><?php echo theme_info('subtitle'); ?></div>

    <!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="/"><?php echo theme_info('title'); ?></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li <?php if($type=='吴式太极拳'): ?> class="active"<?php endif; ?>>
                        <a href="<?php echo url('index/index/page',['type'=>'吴式太极拳']); ?>">吴式太极拳</a></li>
                    <li <?php if($type=='课程安排'): ?> class="active"<?php endif; ?>>
                      <a href="<?php echo url('index/index/page',['type'=>'课程安排']); ?>">课程安排</a></li>
                    <li <?php if($type=='招生简章'): ?> class="active"<?php endif; ?>>
                      <a href="<?php echo url('index/index/page',['type'=>'招生简章']); ?>">招生简章</a></li>
                    <li <?php if($type=='联系方式'): ?> class="active"<?php endif; ?>>
                      <a href="<?php echo url('index/index/page',['type'=>'联系方式']); ?>">联系方式</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
 



 
		<div class="container">
    	
 
 <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center"><?php echo $type; ?>
                        <strong></strong>
                    </h2>
                    <hr>
                </div>
                <?php if(is_array($model) || $model instanceof \think\Collection): $i = 0; $__LIST__ = $model;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <div class="col-lg-12 text-center">
                    
                    <img class="img-responsive img-border " src="<?php echo app\common\Img::thumb($v->files[0],['w'=>5500,'h'=>'300']); ?>" alt="">
               
                    <h2><?php echo $v->title; ?>
                        <br>
                        <small><?php echo $v->create_at; ?></small>
                    </h2>
                    <p><?php echo app\common\Str::cut(strip_tags($v->content),200); ?></p>
                    <a href="<?php echo url('index/index/view',['id'=>$v->_id]); ?>" class="btn btn-default btn-lg">阅读全部</a>
                    <hr>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
        
      
  				<?php echo $model->render(); ?>  


            </div>
        </div>

   


		</div>

 		<footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                <p>Copyright &copy;  2016</p>
            </div>
        </div>
    </div>
</footer>

 







<?php echo minify_js(); ?>

 </body>
</html>