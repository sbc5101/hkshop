<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:60:"D:\phpStudy\WWW\yoshop/application/erp\view\login\index.html";i:1498641404;}*/ ?>
﻿<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"> 
		<title>登录页面</title> 
		<link rel="stylesheet" type="text/css" href="/public/erp/static/css/font-awesome-4.4.0/css/font-awesome.min.css" />     
		<link rel="stylesheet" type="text/css" href="/public/erp/static/css/layout.css" />     	
	</head> 
	<body>
		<div class="sign-overlay"></div>
		<div class="signpanel"></div>

		<div class="panel signin">
		    <div class="panel-heading">
		        <h4 class="panel-title" style="color: white;">都市贵族ERP</h4>
		    </div>
		    <div class="panel-body">
		      <button class="btn btn-primary btn-quirk btn-fb btn-block">进销存系统</button>
		      <div class="or">or</div>
		        <form action="<?php echo url('login/action_login'); ?>" method="post" id="login-form">
		        	<div class="input-group">
		        		<span class="input-group-addon"><i class="fa fa-user"></i></span>
		        		<input class="form-control" name="name" type="text" placeholder="请输入用户名" value=""> 
		        	</div>
		        	<div class="input-group" style="margin:25px 0;">
		        		<span class="input-group-addon"><i class="fa fa-lock"></i></span>       
		        		<input class="form-control" name="password" id="password" type="password" placeholder="请输入密码" value="">   
		        	</div>
        			<div class="input-group col-md-12">
        	             <button type="submit" class='col-md-12 btn btn-success btn-quirk btn-block'>登录</button>         
        	        </div>
		        </form>
		    </div>
		</div><!-- panel -->
	</body>
</html>
