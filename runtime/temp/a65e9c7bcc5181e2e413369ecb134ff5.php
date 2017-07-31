<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:64:"D:\phpStudy\WWW\hkshop/application/shop\view\register\index.html";i:1501492942;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>加入wineBuyBuy</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    	<meta name="apple-mobile-app-capable" content="yes">
    	<meta name="description" content="">
    	<meta name="keywords" content="">
    	<meta http-equiv="Cache-Control" content="no-siteapp">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="/public/shop/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/public/shop/css/join.css" />
	</head>
	<body style="background: #fff;">
		<div class="container">
			<div class="title"></div>
			<div class="joinWrap">
				<p class="join_title">Join WineBuyBuy.com</p>
				<form action="<?php echo url('shop/register/action_login'); ?>" method="post" class="join_form">
					<input type="text" class="first_name input_box" name="first_name" placeholder="First Name"/>
					<input type="text" name="last_name" class="Last_name input_box" placeholder="Last Name"/>
					<input type="email" name="username" class="join_email input_box" placeholder="Email"/>
					<input type="password" name="password" class="join_pass input_box" placeholder="Password"/>
					<p class="notice">I acknowledge that I am at least 18 years old</p>
					<button class="join_btn">Create Account</button>
				</form>
				<a href="###" class="joinByFacebook">
					Or Join with Facebook
				</a>
				<div class="join_other">
					<a href="###">
						Existing Customer? 
						<span class="join_blue">Sign in</span>
					</a>
				</div>
			</div>
		</div>
	</body>
</html>
