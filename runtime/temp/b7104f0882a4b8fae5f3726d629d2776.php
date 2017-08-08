<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:62:"D:\phpStudy\WWW\hkshop/application/admin\view\login\index.html";i:1498615338;}*/ ?>
﻿<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"> 
		<title>登录页面</title> 
		<link rel="stylesheet" type="text/css" href="/public/admin/assets/css/login.css" />     
		<script type="text/javascript" src="/public/admin/assets/js/jquery-1.9.1.min.js"></script>     
		<script type="text/javascript">
			$(function(){
				//得到焦点
				$("#password").focus(function(){
					$("#left_hand").animate({
						left: "150",
						top: " -38"
					},{step: function(){
						if(parseInt($("#left_hand").css("left"))>140){
							$("#left_hand").attr("class","left_hand");
						}
					}}, 2000);
					$("#right_hand").animate({
						right: "-64",
						top: "-38px"
					},{step: function(){
						if(parseInt($("#right_hand").css("right"))> -70){
							$("#right_hand").attr("class","right_hand");
						}
					}}, 2000);
				});
				//失去焦点
				$("#password").blur(function(){
					$("#left_hand").attr("class","initial_left_hand");
					$("#left_hand").attr("style","left:100px;top:-12px;");
					$("#right_hand").attr("class","initial_right_hand");
					$("#right_hand").attr("style","right:-112px;top:-12px");
				});
			});
		</script>	
		<meta name="generator" content="mshtml 11.00.9600.17496">
	</head> 
	<body>
		<div class="top_div"></div>
		<div style="background: rgb(255, 255, 255); margin: -100px auto auto; border: 1px solid rgb(231, 231, 231); border-image: none; width: 400px; height: 200px; text-align: center;">
		<div style="width: 165px; height: 96px; position: absolute;">
			<div class="tou"></div>
			<div class="initial_left_hand" id="left_hand"></div>
			<div class="initial_right_hand" id="right_hand"></div>
		</div>
		<form action="<?php echo url('login/action_login'); ?>" method="post">
			<p style="padding: 30px 0px 10px; position: relative;"><span class="u_logo"></span>         
				<input class="ipt" name="name" type="text" placeholder="请输入用户名" value=""> 
			</p>
			<p style="position: relative;"><span class="p_logo"></span>         
				<input class="ipt" name="password" id="password" type="password" placeholder="请输入密码" value="">   
			</p>
			<div style="height: 50px; line-height: 50px; margin-top: 30px; border-top-color: rgb(231, 231, 231); border-top-width: 1px; border-top-style: solid;">
					<p style="margin: 0px 35px 20px 45px;">
						<span style="float: left;">
							<!-- <a style="color: rgb(204, 204, 204);" href="#">忘记密码?</a> -->
						</span> 
			           <span style="float: right;">
			           <!-- <a style="color: rgb(204, 204, 204); margin-right: 10px;" href="#">注册</a>   -->
			              <button type="submit" style="background: rgb(0, 142, 173); padding: 7px 10px; border-radius: 4px; border: 1px solid rgb(26, 117, 152); border-image: none; color: rgb(255, 255, 255); font-weight: bold;">登录</button>  
			           </span>         
			        </p>
			    </div>
			</div>
		</form>
	</body>
</html>
