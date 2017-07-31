$(function(){
	$(".list_ul li").click(function(){
		var index=$(this).index();
		$(this).addClass("selected").siblings().removeClass("selected");
		if(index==0){
			$(".goods_content1").fadeIn(200).siblings().hide();
		}
		if(index==1){
			$(".goods_content2").fadeIn(200).siblings().hide();
		}
		if(index==2){
			$(".goods_content3").fadeIn(200).siblings().hide();
		}
	})
	$(".goods_content1_ul li").addClass("clearfix");
})