<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:61:"D:\phpStudy\WWW\hkshop/application/shop\view\index\index.html";i:1502954498;s:63:"D:\phpStudy\WWW\hkshop/application/shop\view\Public\public.html";i:1502877782;}*/ ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    
	<title>wineBuyBuy</title>

    <!--优先使用IE最新版本和Chrome-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- 是否启用 WebApp 全屏模式，删除苹果默认的工具栏和菜单栏 -->
    <meta name="apple-mobile-app-capable" content="yes">
    <!-- 页面描述 -->
    <meta name="description" content="">
    <!-- 页面关键词 -->
    <meta name="keywords" content="">
    <!--禁止百度转码-->
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />

    <!-- 公共css -->
    <link rel="stylesheet" type="text/css" href="/public/shop/css/base.css" />
    <link rel="stylesheet" type="text/css" href="/public/shop/css/index.css" />
    <!-- 公共js -->
    <script type="text/javascript" src="/public/shop/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="/public/shop/js/swiper-3.4.1.min.js"></script>   
  </head>
  <body  >
    <div class="container">
      <div class="alert_box">
        <section class="searchBar">
          <form class="formWarp clearfix" action="/serach">
            <label class="select_label">
              <span class="select_labelText">Ship to:</span>
              <select class="selectContent">
                <option value="DL">DL</option>
                <option value="HK" selected="selected">HK</option>
                <option value="TW">TW</option>
              </select>
            </label>
            <div class="search_box">
              <input class="search_input" type="search" placeholder="Search Wine Buy Buy.com" />
            </div>
          </form>
        </section>
        <?php  $cates = get_cates();   $i = 1;  ?>
        <!--分类的列表-->
        <ul class="type_list">
          <?php  if(!empty($cates)){   foreach($cates as $v){   if($v['pid'] == 0){   if($i > 4){ breack;} ?>
          <li <?php  if($i == 1){ echo 'class="on"';}  ?>><?php  echo $v['cname']  ?></li>
          <?php  $i++;   }   }   }  ?>
        </ul>
        <!--分类的内容区域-->
        <div class="content">
          <div class="content_area1">
            <?php  if(!empty($cates)){   foreach($cates as $v){   if($v['pid'] == 373){  ?>
            <p class="wine1"><?php  echo $v['cname']  ?></p>
              <?php  foreach($cates as $val){   if($val['pid'] == $v['id']){  ?>
              <ul>
                <li>
                  <a href="###">
                    <span><?php  echo $val['cname']  ?></span>
                  </a>
                </li>
              </ul>
              <?php  }   }   }   }   }  ?>
          </div>
          <div class="content_area2">
            <?php  if(!empty($cates)){   foreach($cates as $v){   if($v['pid'] == 374){  ?>
            <p class="wine1"><?php  echo $v['cname']  ?></p>
              <?php  foreach($cates as $val){   if($val['pid'] == $v['id']){  ?>
              <ul>
                <li>
                  <a href="###">
                    <span><?php  echo $val['cname']  ?></span>
                  </a>
                </li>
              </ul>
              <?php  }   }   }   }   }  ?>
          </div>
          <div class="content_area3">
            <?php  if(!empty($cates)){   foreach($cates as $v){   if($v['pid'] == 375){  ?>
            <p class="wine1"><?php  echo $v['cname']  ?></p>
              <?php  foreach($cates as $val){   if($val['pid'] == $v['id']){  ?>
              <ul>
                <li>
                  <a href="###">
                    <span><?php  echo $val['cname']  ?></span>
                  </a>
                </li>
              </ul>
              <?php  }   }   }   }   }  ?>
          </div>
          <div class="content_area4">
            <?php  if(!empty($cates)){   foreach($cates as $v){   if($v['pid'] == 376){  ?>
            <p class="wine1"><?php  echo $v['cname']  ?></p>
              <?php  foreach($cates as $val){   if($val['pid'] == $v['id']){  ?>
              <ul>
                <li>
                  <a href="###">
                    <span><?php  echo $val['cname']  ?></span>
                  </a>
                </li>
              </ul>
              <?php  }   }   }   }   }  ?>
          </div>
        </div>
      </div>
      <div class="top">
        
      </div>
      <!--头部的区域-->
      <header>
        <div class="menu">
          <img src="/public/shop/img/icon1.png" alt="" class="anniu"/>
        </div>
        <div class="logo_area">
          <a href="<?php echo url('shop/index/index'); ?>">
            <img src="/public/shop/img/logo.png" alt="" />
          </a>
        </div>
        <div class="right_box">
          <div class="center">
            <a href="<?php echo url('shop/member/personal_center'); ?>">
              <img src="/public/shop/img/icon2.png" alt="" />
            </a>            
          </div>
          <div class="cart">
            <a href="<?php echo url('shop/cart/shopping_cart'); ?>">
              <span style="display: inline-block;padding-left: 5px;font-weight: bold;color:#dc143c;"><?php  echo get_total_buy_num()  ?></span>
            </a>
          </div>
        </div>
      </header>
      <!--+++++++++++++++搜索框区域和下拉框区域,点击菜单栏的时候将其隐藏++++++++++++++++-->
      <div class="contant">
         
        
    <link rel="stylesheet" type="text/css" href="/public/shop/css/swiper.min.css" />
	<section class="searchBar">
		<form class="formWarp clearfix" action="/serach">
			<label class="select_label">
				<span class="select_labelText">Ship to:</span>
				<select class="selectContent">
					<?php if(is_array($goods_areas) || $goods_areas instanceof \think\Collection): $i = 0; $__LIST__ = $goods_areas;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo $v['id']; ?>" <?php if($v['id'] == $area_id): ?> selected <?php endif; ?>><?php echo $v['area_name']; ?></option>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</label>
			<div class="search_box">
				<input class="search_input" type="search" placeholder="Search Wine Buy Buy.com" />
			</div>
		</form>
	</section>
	<!--通知模块-->
	<div class="wine_notice" style="width: 100%;height: 40px;background: #bdbdbd;font-size: 12px;line-height: 40px;text-align: center;">
		Optional ship to HK or ship to China through zero tariff policy
	</div>
	<!--轮播图区域-->
	<div class="swiper-container swiper-img">
	    <div class="swiper-wrapper">
	    	<?php if(is_array($carousel) || $carousel instanceof \think\Collection): $i = 0; $__LIST__ = $carousel;if( count($__LIST__)==0 ) : echo "<div class=" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
	        <div class="swiper-slide">
	        	<a href="<?php echo $v['url']; ?>">
	        		<img src="<?php echo $v['img_name']; ?>"/>
	        	</a>
	        </div>
	        <?php endforeach; endif; else: echo "<div class=" ;endif; ?>
	    </div>
		<div class="swiper-pagination"></div>
	</div>
	<!--+++++++++++++第一块商品区域++++++++++-->
	<div class="goods_list1">
		<h2 class="product_headline">&nbsp;&nbsp;MOST POPULAR RED WINE</h2>
		<!--滑动区域-->
		<div class="swiper-container swiper1">
	        <div class="swiper-wrapper">
		        <?php if(is_array($most_goods) || $most_goods instanceof \think\Collection): $i = 0; $__LIST__ = $most_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
	            <div class="swiper-slide">
	            	<div class="goods_img">
	            		<a href="<?php echo url('shop/goods/goods_detail',['id' => $v['id']]); ?>">
	            		<img src="<?php echo $v['iname']; ?>"/>
	            		</a>
	            	</div>
	            	<div class="goods_desc">
	            		<p class="En_name"><?php echo $v['eng_title']; ?></p>
	            		<p class="Cn_name"><?php echo $v['hk_title']; ?></p>
	            		<div class="score">
	            			<ul>
	            			 	<?php if(is_array($v['score_data']) || $v['score_data'] instanceof \think\Collection): $i = 0; $__LIST__ = $v['score_data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
	            				<li>
	            					<span class="score1"><?php echo $val['mechanism']; ?></span>
	            					<span class="score2"><?php echo $val['score_num']; ?></span>
	            				</li>
	            				<?php endforeach; endif; else: echo "" ;endif; ?>
	            			</ul>
	            		</div>
	            		<!--价格-->
	            		<p>
	            			<span class="price">HK$ <?php echo $v['marketprice']; ?></span>
	            			<span class="marketprice">HK$ <?php echo $v['storeprice']; ?></span>
	            		</p>
	            	</div>
	            	<!--收藏和加入购物车-->
	            	<div class="bot_areas">
	            		<div class="collect" data-id="<?php echo $v['id']; ?>">
	            			<img src="/public/shop/img/icon4.png" alt="" />
	            		</div>
	            		<div class="addTo_car" data-id="<?php echo $v['id']; ?>">
	            			<img src="/public/shop/img/icon6.png" alt="" />
	            		</div>
	            	</div>
	            </div>
	            <?php endforeach; endif; else: echo "" ;endif; ?>
	        </div>
		</div>
	</div>
	<!--+++++++++++++第二块商品区域+++++++++++-->
	<div class="goods_list1">
		<h2 class="product_headline">&nbsp;&nbsp;NEW ARRIVALS </h2>
		<!--滑动区域-->
		<div class="swiper-container swiper1">
	        <div class="swiper-wrapper">
	        	<?php if(is_array($new_goods) || $new_goods instanceof \think\Collection): $i = 0; $__LIST__ = $new_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
	            <div class="swiper-slide">
	            	<div class="goods_img">
	            		<a href="<?php echo url('shop/goods/goods_detail',['id' => $v['id']]); ?>">
	            		<img src="<?php echo $v['iname']; ?>"/>
	            		</a>
	            	</div>
	            	<div class="goods_desc">
	            		<p class="En_name"><?php echo $v['eng_title']; ?></p>
	            		<p class="Cn_name"><?php echo $v['hk_title']; ?></p>
	            		<div class="score">
	            			<ul>
	            				<?php if(is_array($v['score_data']) || $v['score_data'] instanceof \think\Collection): $i = 0; $__LIST__ = $v['score_data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
	            				<li>
	            					<span class="score1"><?php echo $val['mechanism']; ?></span>
	            					<span class="score2"><?php echo $val['score_num']; ?></span>
	            				</li>
	            				<?php endforeach; endif; else: echo "" ;endif; ?>
	            			</ul>
	            		</div>
	            		<!--价格-->
	            		<p>
	            			<span class="price">HK$ <?php echo $v['marketprice']; ?></span>
	            			<span class="marketprice">HK$ <?php echo $v['storeprice']; ?></span>
	            		</p>
	            	</div>
	            	<!--收藏和加入购物车-->
	            	<div class="bot_areas">
	            		<div class="collect" data-id="<?php echo $v['id']; ?>">
	            			<img src="/public/shop/img/icon4.png" alt="" />
	            		</div>
	            		<div class="addTo_car" data-id="<?php echo $v['id']; ?>">
	            			<img src="/public/shop/img/icon6.png" alt="" />
	            		</div>
	            	</div>
	            </div>
	          	<?php endforeach; endif; else: echo "" ;endif; ?>
	        </div>
		</div>
	</div>
	<!--++++++++++++++第三块商品区域++++++++++++++-->
	<div class="goods_list1" style="background: #dc143c;">
		<h2 class="product_headline" style="color: #fff;border-color: #fff;">&nbsp;&nbsp;RED WINE </h2>
		<!--滑动区域-->
		<div class="swiper-container swiper1">
	        <div class="swiper-wrapper">
	        	<?php if(is_array($red_goods) || $red_goods instanceof \think\Collection): $i = 0; $__LIST__ = $red_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
	            <div class="swiper-slide">
	            	<div class="goods_img">
	            		<a href="<?php echo url('shop/goods/goods_detail',['id' => $v['id']]); ?>">
	            		<img src="<?php echo $v['iname']; ?>"/>
	            		</a>
	            	</div>
	            	<div class="goods_desc">
	            		<p class="En_name"><?php echo $v['eng_title']; ?></p>
	            		<p class="Cn_name"><?php echo $v['hk_title']; ?></p>
	            		<div class="score">
	            			<ul>
	            				<?php if(is_array($v['score_data']) || $v['score_data'] instanceof \think\Collection): $i = 0; $__LIST__ = $v['score_data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
	            				<li>
	            					<span class="score1"><?php echo $val['mechanism']; ?></span>
	            					<span class="score2"><?php echo $val['score_num']; ?></span>
	            				</li>
	            				<?php endforeach; endif; else: echo "" ;endif; ?>
	            			</ul>
	            		</div>
	            		<!--价格-->
	            		<p>
	            			<span class="price">HK$ <?php echo $v['marketprice']; ?></span>
	            			<span class="marketprice">HK$ <?php echo $v['storeprice']; ?></span>
	            		</p>
	            	</div>
	            	<!--收藏和加入购物车-->
	            	<div class="bot_areas">
	            		<div class="collect" data-id="<?php echo $v['id']; ?>">
	            			<img src="/public/shop/img/icon4.png" alt="" />
	            		</div>
	            		<div class="addTo_car" data-id="<?php echo $v['id']; ?>">
	            			<img src="/public/shop/img/icon6.png" alt="" />
	            		</div>
	            	</div>
	            </div>
	          	<?php endforeach; endif; else: echo "" ;endif; ?>
	        </div>
		</div>
	</div>
	<!--+++++++++++第四块商品区域++++++++++++-->
	<div class="goods_list1">
		<h2 class="product_headline">&nbsp;&nbsp;WHITE WINE </h2>
		<!--滑动区域-->
		<div class="swiper-container swiper1">
	        <div class="swiper-wrapper">
	        	<?php if(is_array($white_goods) || $white_goods instanceof \think\Collection): $i = 0; $__LIST__ = $white_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
	            <div class="swiper-slide">
	            	<div class="goods_img">
	            		<a href="<?php echo url('shop/goods/goods_detail',['id' => $v['id']]); ?>">
	            		<img src="<?php echo $v['iname']; ?>"/>
	            		</a>
	            	</div>
	            	<div class="goods_desc">
	            		<p class="En_name"><?php echo $v['eng_title']; ?></p>
	            		<p class="Cn_name"><?php echo $v['hk_title']; ?></p>
	            		<div class="score">
	            			<ul>
	            				<?php if(is_array($v['score_data']) || $v['score_data'] instanceof \think\Collection): $i = 0; $__LIST__ = $v['score_data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
	            				<li>
	            					<span class="score1"><?php echo $val['mechanism']; ?></span>
	            					<span class="score2"><?php echo $val['score_num']; ?></span>
	            				</li>
	            				<?php endforeach; endif; else: echo "" ;endif; ?>
	            			</ul>
	            		</div>
	            		<!--价格-->
	            		<p>
	            			<span class="price">HK$ <?php echo $v['marketprice']; ?></span>
	            			<span class="marketprice">HK$ <?php echo $v['storeprice']; ?></span>
	            		</p>
	            	</div>
	            	<!--收藏和加入购物车-->
	            	<div class="bot_areas">
	            		<div class="collect" data-id="<?php echo $v['id']; ?>">
	            			<img src="/public/shop/img/icon4.png" alt="" />
	            		</div>
	            		<div class="addTo_car" data-id="<?php echo $v['id']; ?>">
	            			<img src="/public/shop/img/icon6.png" alt="" />
	            		</div>
	            	</div>
	            </div>
	            <?php endforeach; endif; else: echo "" ;endif; ?>
	        </div>
		</div>
	</div>
	<!--++++++++++第五块商品区域++++++++++-->
	<div class="goods_list1 goods_list5">
		<h2 class="product_headline">&nbsp;&nbsp;Champagne & Sparkling </h2>
		<!--滑动区域-->
		<div class="swiper-container swiper1">
	        <div class="swiper-wrapper">
		        <?php if(is_array($white_goods) || $white_goods instanceof \think\Collection): $i = 0; $__LIST__ = $white_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
	            <div class="swiper-slide">
	            	<div class="goods_img">
	            		<a href="<?php echo url('shop/goods/goods_detail',['id' => $v['id']]); ?>">
	            		<img src="<?php echo $v['iname']; ?>"/>
	            		</a>
	            	</div>
	            	<div class="goods_desc">
	            		<p class="En_name"><?php echo $v['eng_title']; ?></p>
	            		<p class="Cn_name"><?php echo $v['hk_title']; ?></p>
	            		<div class="score">
	            			<ul>
	            				<?php if(is_array($v['score_data']) || $v['score_data'] instanceof \think\Collection): $i = 0; $__LIST__ = $v['score_data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
	            				<li>
	            					<span class="score1"><?php echo $val['mechanism']; ?></span>
	            					<span class="score2"><?php echo $val['score_num']; ?></span>
	            				</li>
	            				<?php endforeach; endif; else: echo "" ;endif; ?>
	            			</ul>
	            		</div>
	            		<!--价格-->
	            		<p>
	            			<span class="price">HK$ <?php echo $v['marketprice']; ?></span>
	            			<span class="marketprice">HK$ <?php echo $v['storeprice']; ?></span>
	            		</p>
	            	</div>
	            	<!--收藏和加入购物车-->
	            	<div class="bot_areas">
	            		<div class="collect" data-id="<?php echo $v['id']; ?>">
	            			<img src="/public/shop/img/icon4.png" alt="" />
	            		</div>
	            		<div class="addTo_car" data-id="<?php echo $v['id']; ?>">
	            			<img src="/public/shop/img/icon6.png" alt="" />
	            		</div>
	            	</div>
	            </div>
	         	<?php endforeach; endif; else: echo "" ;endif; ?>
	        </div>
		</div>
	</div>
	<script type="text/javascript" src="/public/shop/js/index.js"></script>
	<script type="text/javascript">
		var mySwiper = new Swiper('.swiper-img',{
	    //pagination: '.swiper-pagination',
	    paginationClickable: true,
	    loop:true,
	    autoplay:2500
	    });
	    
	    //初始化商品列表的滚动列表
	    var swiper = new Swiper('.swiper1', {
	        //pagination: '.swiper-pagination',
	        slidesPerView: 2.3,
	        paginationClickable: true,
	        spaceBetween: 10,
	        freeMode: true
	    });

	    $('.addTo_car').click(function(){
	    	var goods_id = $(this).attr('data-id');
	    	var url = "<?php echo url('shop/cart/add_cart'); ?>";
	    	$.post(url,{'goods_id':goods_id,'buy_num':1},function(data){
	    		console.log(data);
	    	},'json');
	    })
	    $('.collect').click(function(){
	    	var goods_id = $(this).attr('data-id');
	    	var url = "<?php echo url('shop/goods/action_goods_collection'); ?>";
	    	$.post(url,{'goods_id':goods_id},function(data){
	    		console.log(data);
	    	},'json');
	    })
	</script>

        
        
          <!--客服聊天-->
          <div class="chat">
            chat online
          </div>
          <!--底部区域-->
          <div class="bottom">
            <p>
              <a href="tel:400666666" style="text-decoration: underline;font-size: 14px;">Call</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a style="text-decoration: underline;font-size: 14px;" href="mailto:woshixdoyf@163.com">Email</a>          
            </p>
            <ul class="relation clearfix">
              <li>
                <a href="www.facebook.com">                         
                  <div>
                    <img src="/public/shop/img/icon7.png" alt="" style="width: 11.5px;height: 22px;"/>
                  </div>
                  <p>
                    Facebook
                  </p>
                </a>
              </li>
              <li>
                <a href="###">                          
                  <div>
                    <img src="/public/shop/img/icon8.png" alt="" style="width: 20.26px;height: 21.5px;"/>
                  </div>
                  <p>
                    Youtobe
                  </p>
                </a>
              </li>
              <li>
                <a href="###">                          
                  <div>
                    <img src="/public/shop/img/icon9.png" alt="" style="width: 21px;height: 21.5px;"/>
                  </div>
                  <p>
                    Privacy Policy
                  </p>
                </a>
              </li>
              <li>
                <a href="###">                          
                  <div>
                    <img src="/public/shop/img/icon10.png" alt="" style="width: 18px;height: 21.5px;"/>
                  </div>
                  <p>
                    Terms
                  </p>
                </a>
              </li>
            </ul>
          </div>
        
      
      </div>
    </div>
  </body>
</html>

