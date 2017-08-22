//注册的正则判断
window.onload=function(){
	$(".first_name").focus();
}

//失去焦点判断
$("input").blur(function(){
	//当光标失去焦点时的判断
	//对名的判断
	if($(this).is(".first_name")){
		var first_name=/^[a-zA-Z\u4e00-\u9fa5]+$/;
		if($(".first_name").val!=""){
			if(!(first_name.test($(".first_name").val()))){
				$(".span1").show();
				$(".span1").text("*名稱輸入不合法");
				return false;
			}else if(first_name){
				$(".span1").hide();
				$(".span1").text("");
				return true;
			}
		}else{
			$(".span1").text("");
		}
	}
	//对姓的判断
	if($(this).is(".Last_name")){
		var last_name=/^[a-zA-Z\u4e00-\u9fa5]+$/;
		if($(".Last_name").val()!=""){
			if(!(last_name.test($(".Last_name").val()))){
				$(".span2").show();
				$(".span2").text("*名稱輸入不合法");
				return false;
			}else if(last_name){
				$(".span2").hide();
				return true;
			}
		}else{
			$(".span2").text("");
		}
	}
	//对邮箱的判断
	if($(this).is(".join_email")){
		var join_email=/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
		if($(".join_email").val()!=""){
			if(!(join_email.test($(".join_email").val()))){
				$(".span3").show();
				$(".span3").text("*郵箱輸入不合法");
				return false;
			}else if(join_email){
				$(".span3").hide();
				return true;
			}
		}else{
			$(".span3").text("");
		}
	}
	//对密码的判断
	if($(this).is(".join_pass")){
		var join_pass= /^[A-Za-z0-9]{6,20}$/;
		if($(".join_pass").val()!=""){
			if(!(join_pass.test($(".join_pass").val()))){
				$(".span4").show();
				$(".span4").text("*密碼輸入不合法");
				return false;
			}else if(join_pass){
				$(".span4").hide();
				return true;
			}
		}else{
			$(".span4").text("");
		}
	}
})

//点击提交按钮验证
$(".join_btn").click(function(){
	var first_name=/^[a-zA-Z\u4e00-\u9fa5]+$/;
	var Last_name=/^[a-zA-Z\u4e00-\u9fa5]+$/;
	var join_email=/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
	var join_pass= /^[A-Za-z0-9]{6,20}$/;
	
	//传递数值
	var post_firstname=$(".first_name").val();
	var post_lastname=$(".Last_name").val();
	var post_email=$(".join_email").val();
	var post_pass=$(".join_pass").val();
	if(first_name.test(post_firstname)&&Last_name.test(post_lastname)&&join_email.test(post_email)&&join_pass.test(post_pass)){
		$.ajax({
			type:"post",
			url:"/shop/register/action_register.html",
			async:true,
			datatype:"json",
			data:{
				"first_name":post_firstname,
				"last_name":post_lastname,
				"email":post_email,
				"password":post_pass			
			},
			success:function(data){
				if(data.code=="200"){
					window.location.href="";
					
				}else{
					alert("提交失败");
				}
			},
			error:function(e){
				//失败的时候打印错误信息
				console.log(e);
			}
			
		});
		
	}else{
		if($(".first_name").val()==""){
			$(".span1").show();
			$(".span1").text('*請輸入名稱');
		}
		if($(".Last_name").val()==""){
			$(".span2").show();
			$(".span2").text('*請輸入名稱');
		}
		if($(".join_email").val()==""){
			$(".span3").show();
			$(".span3").text('*請輸入郵箱')
		}
		if ($(".join_pass").val()==""){
			$(".span4").show();
			$(".span4").text('*請輸入密碼')
		}
	}
})



