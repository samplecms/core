<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"/Library/WebServer/Documents/www/www/public/themes/admin/admin/index/login.html";i:1471097932;s:66:"/Library/WebServer/Documents/www/www/public/themes/admin/base.html";i:1471097932;}*/ ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>标题</title>


<?php echo helper_link([
base_url().'misc/bootstrap/css/bootstrap.min.css',
base_url().'misc/Flat-UI/dist/css/flat-ui.min.css',
theme_url().'misc/css.css',

]); ?>
 
<?php echo widgets('Font'); ?>
<?php echo widgets('JqueryUi'); ?>

</head>
<body>


<div class="container">

	


<form class='ajax_form' method="post">
  <div class="form-group">
    <label for="">用户名</label>
    <input type="text" class="form-control" name='user' placeholder="">
    <div class='error error_user'></div>
  </div>
  <div class="form-group">
    <label for="">密码</label>
    <input type="password" class="form-control" name="pwd">
    <div class='error error_pwd'></div>
  </div>
   
  <div class="form-group">
    <label for="">验证码</label>
    <input type="captcha" class="form-control" name="captcha">
    
    <img src="<?php echo captcha_src(); ?>" class='captcha hand' alt="captcha" />
    <div class='error error_captcha'></div>
  </div>

   
  <button type="submit" class="btn btn-default">登录</button>
</form>


	 
 

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