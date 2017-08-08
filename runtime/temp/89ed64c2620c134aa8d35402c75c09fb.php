<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"D:\phpStudy\WWW\hkshop/application/shop\view\index\index.html";i:1501581983;}*/ ?>
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
		<link rel="stylesheet" type="text/css" href="/public/shop/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/public/shop/css/index.css" />
		<link rel="stylesheet" type="text/css" href="/public/shop/css/swiper.min.css" />
	</head>
	<body>
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
				<!--分类的列表-->
				<ul class="type_list">
					<li class="on">VARIETAL</li>
					<li>REGION</li>
					<li>SPECIALS</li>
					<li>PRO-SEARCH</li>					
				</ul>
				<!--分类的内容区域-->
				<div class="content">
					<div class="content_area1">
						<!--Red Wine-->
						<p class="wine1">RED WINE</p>
						<ul>
							<li>
								<a href="###">
									<span>Bordeaux Blends</span>
								</a>
							</li>
							<li>
								<a href="###">
									<span>Cabernet Sauvignon</span>
									
								</a>
							</li>
							<li>
								<a href="###">
									<span>Merlot</span>
								</a>
							</li>
							<li>
								<a href="###">
									<span>Pinot Noir</span>
								</a>
							</li>
							<li>
								<a href="###">
									<span>Other Red Blends</span>
								</a>
							</li>
							<li>
								<a href="###">
									<span>Sangiovese</span>
								</a>
							</li>
							<li>
								<a href="###">
									<span>Syrah/ Shiraz</span>
								</a>
							</li>
							<li>
								<a href="###">
									<span>Pinot Gris / Grigio</span>
								</a>
							</li>
						</ul>
						<!---->
						<ul>
							<li></li>
						</ul>
					</div>
					<div class="content_area2">区域2</div>
					<div class="content_area3">区域3</div>
					<div class="content_area4">区域4</div>
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
					<a href="index.html">
						<img src="/public/shop/img/logo.png" alt="" />
					</a>
				</div>
				<div class="right_box">
					<div class="center">
						<a href="personal_center.html">
							<img src="/public/shop/img/icon2.png" alt="" />
						</a>						
					</div>
					<div class="cart">
						<a href="shopping_cart.html">
							<span style="display: inline-block;padding-left: 5px;font-weight: bold;color:#dc143c;">9</span>
						</a>
					</div>
				</div>
			</header>
			<!--+++++++++++++++搜索框区域和下拉框区域,点击菜单栏的时候将其隐藏++++++++++++++++-->
			<div class="contant">
				
			
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
			<!--通知模块-->
			<div class="wine_notice" style="width: 100%;height: 40px;background: #bdbdbd;font-size: 12px;line-height: 40px;text-align: center;">
				Optional ship to HK or ship to China through zero tariff policy
			</div>
			<!--轮播图区域-->
			<div class="swiper-container swiper-img">
			    <div class="swiper-wrapper">
			        <div class="swiper-slide">
			        	<a href="###">
			        		<img src="img/swiper1-1.png"/>
			        	</a>
			        </div>
			        <div class="swiper-slide">
			        	<a href="###">
			        		<img src="img/swiper1-1.png"/>
			        	</a>
			        </div>
			        <div class="swiper-slide">
			        	<a href="###">
			        		<img src="img/swiper1-1.png"/>
			        	</a>
			        </div>
			    </div>
	    		<div class="swiper-pagination"></div>
			</div>
			<!--+++++++++++++第一块商品区域++++++++++-->
			<div class="goods_list1">
				<h2 class="product_headline">&nbsp;&nbsp;MOST POPULAR RED WINE</h2>
				<!--滑动区域-->
				<div class="swiper-container swiper1">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="<?php echo url('shop/register/index'); ?>">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="<?php echo url('shop/goods/goods_detail'); ?>">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			        </div>
		    	</div>
			</div>
			<!--+++++++++++++第二块商品区域+++++++++++-->
			<div class="goods_list1">
				<h2 class="product_headline">&nbsp;&nbsp;NEW ARRIVALS </h2>
				<!--滑动区域-->
				<div class="swiper-container swiper1">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			        </div>
		    	</div>
			</div>
			<!--++++++++++++++第三块商品区域++++++++++++++-->
			<div class="goods_list1" style="background: #dc143c;">
				<h2 class="product_headline" style="color: #fff;border-color: #fff;">&nbsp;&nbsp;RED WINE </h2>
				<!--滑动区域-->
				<div class="swiper-container swiper1">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			        </div>
		    	</div>
			</div>
			<!--+++++++++++第四块商品区域++++++++++++-->
			<div class="goods_list1">
				<h2 class="product_headline">&nbsp;&nbsp;WHITE WINE </h2>
				<!--滑动区域-->
				<div class="swiper-container swiper1">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			        </div>
		    	</div>
			</div>
			<!--++++++++++第五块商品区域++++++++++-->
			<div class="goods_list1 goods_list5">
				<h2 class="product_headline">&nbsp;&nbsp;Champagne & Sparkling </h2>
				<!--滑动区域-->
				<div class="swiper-container swiper1">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			            <div class="swiper-slide">
			            	<div class="goods_img">
			            		<a href="###">
			            		<img src="img/goods_img1.png"/>
			            		</a>
			            	</div>
			            	<div class="goods_desc">
			            		<p class="En_name">Screaming Eagle Cabernet Sauvignon</p>
			            		<p class="Cn_name">啸鹰赤霞珠</p>
			            		<div class="score">
			            			<ul>
			            				<li>
			            					<span class="score1">WE</span>
			            					<span class="score2">94</span>
			            				</li>
			            			</ul>
			            		</div>
			            		<!--价格-->
			            		<p>
			            			<span class="price">HK$ 88882</span>
			            			<span class="marketprice">HK$ 99992</span>
			            		</p>
			            	</div>
			            	<!--收藏和加入购物车-->
			            	<div class="bot_areas">
			            		<div class="collect">
			            			<img src="img/icon4.png" alt="" />
			            		</div>
			            		<div class="addTo_car">
			            			<img src="img/icon6.png" alt="" />
			            		</div>
			            	</div>
			            </div>
			        </div>
		    	</div>
			</div>
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
<script type="text/javascript" src="/public/shop/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="/public/shop/js/swiper-3.4.1.min.js"></script>
<script type="text/javascript" src="/public/shop/js/index.js"></script>
<!--<script type="text/javascript" src="js/swiper-3.4.1.min.js"></script>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/index.js"></script>-->
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
</script>