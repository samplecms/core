<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:77:"/Library/WebServer/Documents/www/www/public/themes/business-casual/index.html";i:1471149689;s:76:"/Library/WebServer/Documents/www/www/public/themes/business-casual/base.html";i:1471097932;s:78:"/Library/WebServer/Documents/www/www/public/themes/business-casual/header.html";i:1471141857;s:78:"/Library/WebServer/Documents/www/www/public/themes/business-casual/footer.html";i:1471097931;}*/ ?>
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
                    <h2 class="intro-text text-center"> 
                        <strong>吴式太极拳</strong>
                    </h2>
                    <hr>
                </div>
                <div class="col-md-6">
                    <img class="img-responsive img-border-left" src="<?php echo app\common\Img::thumb(theme_url().'img/0.jpg',['w'=>572 ,'h'=>271 ] ); ?>" alt="">
                </div>
                <div class="col-md-6">
                    <p>河北大兴人吴鉴泉，在杨露禅到北京授拳时，其父全佑从学太极拳</p>
                    <p>
                    	后又拜杨之次子杨班侯为师，在杨式小架太极拳的基础上逐步修订，
                    </p>
                    <p>
                    	又经吴鉴泉改进修润而形成了一个流派，即“吴式太极拳”。
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center">团
                        <strong>队</strong>
                    </h2>
                    <hr>
                </div>
                <div class="col-sm-4 text-center">
                    <img class="img-responsive thumbnail" src="<?php echo app\common\Img::thumb(theme_url().'img/liu.jpg',['w'=>300 ,'h'=>300,'thumb_type'=>3 ] ); ?>" alt="">
                    <h3>刘继发
                        <small>师父</small>
                    </h3>
                </div>
                <div class="col-sm-4 text-center">
                    <img class="img-responsive thumbnail" src="<?php echo app\common\Img::thumb(theme_url().'img/sun.jpg',['w'=>300 ,'h'=>300 ,'thumb_type'=>3] ); ?>" alt="">
                    <h3>孙康
                        <small></small>
                    </h3>
                </div>
                <div class="col-sm-4 text-center">
                    <img class="img-responsive thumbnail" src="<?php echo app\common\Img::thumb(theme_url().'img/wei.jpg',['w'=>300 ,'h'=>300 ,'thumb_type'=>3] ); ?>" alt="">
                    <h3>微信联系
                        <small>weichat:sunkangchina</small>
                    </h3>
                </div>
                <div class="clearfix"></div>
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