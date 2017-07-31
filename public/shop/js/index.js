//点击菜单栏控制菜单的显示和隐藏
$(function(){
	var n=0;
	var windowH=$(window).height();
	$(".alert_box").height(windowH-54);
	$(".anniu").click(function(){
		$(".alert_box").slideToggle(250);
		if(n==0){
			$('.contant').fadeOut();
			$(".center").hide();
			$(".cart").hide();
			$(".menu img").attr("src","img/icon11.png")
			n=1;			
		}else{
			$('.contant').fadeIn();
			$(".center").show();
			$(".cart").show();
			$(".menu img").attr("src","img/icon1.png")
			n=0;
			
		}
		
	})
	
})


//点击分类列表的切换
$(function(){
	$('.type_list li').click(function(){
		var index=$(this).index();
		$(this).addClass("on").siblings().removeClass("on");
		if(index==0){
			$(".content_area1").fadeIn(200).siblings().hide();
		}
		if(index==1){
			$(".content_area2").fadeIn(200).siblings().hide();
		}
		if(index==2){
			$(".content_area3").fadeIn(200).siblings().hide();
		}
		if(index==3){
			$(".content_area4").fadeIn(200).siblings().hide();
		}
	})
})
