<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>	
<head>
<title>后台登录</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<meta name="keywords" content="Flat Dark Web Login Form Responsive Templates, Iphone Widget Template, Smartphone login forms,Login form, Widget Template, Responsive Templates, a Ipad 404 Templates, Flat Responsive Templates" />

 <link rel="stylesheet" type="text/css" href="/first/Public/css/login.css" />
<!--webfonts-->


<!--//webfonts-->
<meta charset="utf-8">
</head>
<body>
<script>$(document).ready(function(c) {
	$('.close').on('click', function(c){
		$('.login-form').fadeOut('slow', function(c){
	  		$('.login-form').remove();
		});
	});	  
});
</script>
 <!--SIGN UP-->
 <h1>UniSoft后台登录</h1>
<div class="login-form">
		<div class="head-info">
			<label> 用户登录</label>

		</div>
			<div class="clear"> </div>
	<div class="avtar">
		<img src="/first/Public/img/avtar.png" />
	</div>
			<form  id="form" action="<?php echo U('Login/index');?>" method="post">
					<input type="text" class="text" name="username">
					<div class="key">
					<input type="password" name="password">
					</div>
                    <div class="signin">
					<input type="submit" value="登录" >
					</div>
			</form>
	
</div>
 <div class="copy-rights">
					<p>Copyright &copy; 2016.Company name All rights reserved.More Templates <a href="http://www.wanghome.com/" target="_blank" title="汪之厌胃">汪之厌胃</a> - Collect from <a href="http://www.wanghome.com/" title="汪之厌胃" target="_blank">汪之厌胃</a></p>
			</div>

</body>
</html>