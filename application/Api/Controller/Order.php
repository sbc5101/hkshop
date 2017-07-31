<?php
	namespace app\api\controller;

	use app\api\controller\Base;
	use app\api\model\Pay;
	use app\api\model\Customs;
	use app\api\model\Express;
	use app\api\model\Bonus;
	use think\Db;
	use think\Request;
	use vendor\alipay\aop\AopClient;
	// use vendor\oms\SvcCall;

	/**
	* @Author: Yoshop
	* 订单生成类接口
	* @Date:   2016-12-27 15:38:14
	* @Last Modified time: 2016-12-27 16:20:06
	*/
	class Order extends Base
	{

		/**
		 * 获取海关订单列表
		 * @return [type] [description]
		 */
		public function get_customs_order_list()
		{
		    $params = array(
		        'order_code' => '000088-170504-0001',
		    );

			vendor('oms.SvcCall');
		    $svc = new SvcCall(); 
		    $res = $svc->getOrderByCode($params);

		    return $res;
		}
	
		/**
		 * 海关回复信息
		 * @return [type] [description]
		 */
		public function back_customs()
		{
			$data = $_POST;
			$customs = new Customs;
			$res = $customs->back_customs($data);
			return $res;
		}

		/**
		 * 再次支付
		 * @return [type] [description]
		 */
		public function after_order()
		{
			$data = Request::instance()->get();

			// 初始化数据
			$mg_id = '';
			$m_code = '';
			$c_id = '';

			// 连接售货机数据库
			$mac = Db::connect([
			    // 数据库类型
			    'type'     => 'mysql',
			    // 服务器地址
			    'hostname' => '120.24.167.2',
			    // 数据库名
			    'database' => 'redwine',
			    // 数据库用户名
			    'username' => 'redwine',
			    // 数据库密码
			    'password' => 'customersmima',
			    // 数据库连接端口
			    'hostport' => '3306',
			    // 数据库连接参数
			    'params'   => [],
			    // 数据库编码默认采用utf8
			    'charset'  => 'utf8',
			    // 数据库表前缀
			    'prefix'   => '',
			]);

			if(empty($data['payType'])){
            	return json(['data' => '','code' => 400,'message' => '没有获取付款方式！']);
				die;
            }
            $id = $data['cart_id'];
            $order_data = Db::name('shop_order')
            			->where('id',$id)
            			->find();

            if($order_data['status'] == 0){
            	// 检测是否有优惠劵
            	if(!empty($data['coupon_id'])){
            		$coupon = Db::name('coupon')
            					->where('id',$data['coupon_id'])
            					->where('user_id',$data['uid'])
            					->find();
            		if(!empty($coupon)){
            			if(strtotime($coupon['limit_time']) < time()){
            				return json(['data' => '','code' => 400,'message' => '该优惠券已经过期！']);
            				die;
            			}
            			if($coupon['is_use'] = 0){
            				return json(['data' => '','code' => 400,'message' => '该优惠券已经使用！']);
            				die;
            			}
            			$order['price'] = $order_data['actualprice'] - $coupon['money'];
            			$order['bonusprice'] = $coupon['money'];
            			$order['hasbonus'] = 1;
            		}
            	}
				// 获取地址数据
				if($data['is_machine'] == 1){
					$seller_address = Db::name('seller_shop')
									->where('machine_code',$m_code)
									->find();
					$order['sendtype'] = 1;
					$order['machine_address'] = $seller_address['address'];
					$order['pick_code'] = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT).str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

				}else{
					$users_address = Db::name('users_address')
								->field('province,city,area,address,mobile,user_name,code')
								->where('id',$data['address_id'])
								->find();

					$order['sendtype'] = 0;
					$order['address_province'] = $users_address['province'];
					$order['address_city'] = $users_address['city'];
					$order['address_area'] = $users_address['area'];
					$order['address_address'] = $users_address['address'];
					$order['address_mobile'] = $users_address['mobile'];
					$order['addressid'] = $data['address_id'];
					$order['recipients'] = $users_address['user_name'];
					$order['postcode'] = $users_address['code'];
					if(!empty($data['idCardName'])){
						$order['idcard'] = $data['idCardNum'];
						$order['username'] = $data['idCardName'];
					}
				}
				$res = Db::name('shop_order')
						->where('order_num',$order_data['order_num'])
						->update($order);
				if($res !== false){
	            	return $this->to_pay($order_data['order_num'],$data['payType'],1);
				}
            }else{
            	$order_goods = Db::name('shop_order_goods')
            					->where('orderid',$order_data['id'])
            					->select();
     
        		// 提取订单商品数据
        		foreach ($order_goods as $k => $v) {
        			if($data['is_machine'] == 1){//售货机商品
        				$machine = $mac
								->name('container_info')
								->field('goods_id,num,dev_no')
								->where('id',$v['mg_id'])
								->find();
						$goods_info = $mac
								->name('goods_info')
								->where('id',$machine['goods_id'])
								->find();
						if($goods_info['is_cuxiao'] == 1){
							$price = $goods_info['cuxiao_price'];
						}else{
							$price = $goods_info['price'];
						}
        				if(empty($machine)){
        					return json(['data' => '','code' => 400,'message' => '该商品已在售货机下架！']);
        					die;
        				}

        				if($machine['num'] <= 0 || $machine['num'] < $v['goods_num']){
        					return json(['data' => '','code' => 400,'message' => $goods_info['goods_name'].'该商品库存不足！']);
        					die;
        				}
        			}else{
        				if($v['activity_type'] == 0){//没有活动
        					if($v['shop_id'] == 0){//自营店铺
        						$goods[$k] = Db::name('goods')
        									->find();
        						if($goods[$k]['status'] == 1){
    								return json(['data' => '','code' => 400,'message' => $goods[$k]['title'].'该商品已下架！']);
    								die;
        						}
        					}else{//商家店铺
        						$goods[$k] = Db::name('shop_goods')
        										->find();

        							if($goods[$k]['status'] == 1){
        								return json(['data' => '','code' => 400,'message' => $goods[$k]['title'].'该商品已下架！']);
        								die;
        							}
        					}

        				}elseif($v['activity_type'] == 1){// 限时抢购
        					$goods[$k] = Db::name('activity_tlimit')
        							->alias('t')
        							->join('yo_goods g','g.id = t.goods_id')
        							->field('g.status')
        							->where('t.id',$v['goodsid'])
        							->find();

        					if($goods[$k]['status'] == 1){
        						return json(['data' => '','code' => 400,'message' => $goods[$k]['act_title'].'该商品已下架！']);
        						die;
        					}
        				}elseif($v['activity_type'] == 2){// 促销活动
        					$goods[$k] = Db::name('activity_festival')
        							->alias('f')
        							->join('yo_goods g','g.id = f.goods_id')
        							->field('g.tax_point,g.record_goosnum,g.type,g.marketprice,f.goods_id,f.stock,f.act_title,f.discount,f.act_image')
        							->where('f.id',$v['goods_id'])
        							->find();

        					if($goods[$k]['status'] == 1){
        						return json(['data' => '','code' => 400,'message' => $goods[$k]['act_title'].'该商品已下架！']);
        						die;
        					}
        				}
        			}
        		}
        		$order['price'] = $order_data['price'];
        		$order['actualprice'] = $order_data['actualprice'];
            	// 检测是否有优惠劵
            	if(!empty($data['coupon_id'])){
            		$coupon = Db::name('coupon')
            					->where('id',$data['coupon_id'])
            					->where('user_id',$data['uid'])
            					->find();
            		if(!empty($coupon)){
            			if(strtotime($coupon['limit_time']) < time()){
            				return json(['data' => '','code' => 400,'message' => '该优惠券已经过期！']);
            				die;
            			}
            			if($coupon['is_use'] = 0){
            				return json(['data' => '','code' => 400,'message' => '该优惠券已经使用！']);
            				die;
            			}
            			$order['price'] = $order_data['actualprice'] - $coupon['money'];
            			$order['bonusprice'] = $coupon['money'];
            			$order['hasbonus'] = 1;
            		}
            	}
				// 获取地址数据
				if($data['is_machine'] == 1){
					$seller_address = Db::name('seller_shop')
									->where('machine_code',$m_code)
									->find();
					$order['sendtype'] = 1;
					$order['machine_address'] = $seller_address['address'];
				}else{
					$users_address = Db::name('users_address')
								->field('province,city,area,address,mobile,user_name,code')
								->where('id',$data['address_id'])
								->find();

					$order['sendtype'] = 0;
					$order['address_province'] = $users_address['province'];
					$order['address_city'] = $users_address['city'];
					$order['address_area'] = $users_address['area'];
					$order['address_address'] = $users_address['address'];
					$order['address_mobile'] = $users_address['mobile'];
					$order['addressid'] = $data['address_id'];
					$order['recipients'] = $users_address['user_name'];
					$order['postcode'] = $users_address['code'];
					if(!empty($data['idCardName'])){
						$order['idcard'] = $data['idCardNum'];
						$order['username'] = $data['idCardName'];
					}
				}

				// 生成商户数据
				$seller_id = '';
				$seller_id = Db::name('shop')
							->where('id',$data['sid'])
							->find()['seller_id'];

	            // 写入订单相关数据
	            $order['is_invoice'] = $data['is_invoice'];
	            $order['company_title'] = $data['companyTitle'];
	            $order['createtime'] = time();
	            $order['uid'] = $data['uid'];
	            $order['seller_id'] = $seller_id;
	            $order['shop_id'] = $data['sid'];
	        	$order['is_machine'] = $data['is_machine'];
	        	
  				$total_num = '';

	            // 计算总重
	    		$total_weight = $total_num * 750;
	    		$order['total_weight'] = $total_weight;
	    		// 获取立即送配送金额
	    		if($new_data['is_machine'] == 2){
	    			$province_data = $this->get_provinces();
					$cities_data = $this->get_cities();
					foreach ($province_data as $v) {
						if($v['provinceid'] == $shop_data['province']){
							$shop_data['province'] = $v['province'];
						}
					}
					foreach ($cities_data as $v) {
						if($v['cityid'] == $shop_data['city']){
							$shop_data['city'] = $v['city'];
						}
					}
					$str = mb_substr($shop_data['province'],-1,1); 
					if($str == '市'){
						$shop_data['city'] = $shop_data['province'];
					}
					$express = new Express;
		    		$immediately = $express->immediately($order,$shop_data,true);
	    			if($immediately['status'] == 1){
	    				$order['price'] = $order['price'] + $immediately['price'];
	    				$order['immediate_cost'] = $immediately['price'];
	    			}else{
	    				return json(['data' => '','code' => 400,'message' => '获取立即送金额失败！']);
						die;
	    			}
	    		}

	    		// 修改订单信息
	             $res = Db::name('shop_order')
	             			->where('id',$order['id'])
	            	    	->update($order);
            	if($res !== false){
		            return $this->to_pay($order['order_num'],$data['payType'],1);
            	}else{
            		return json(['data' => '','code' => 400,'message' => '订单这次支付失败！']);
					die;
            	}
            }
		}
		/**
		 * 商品订单生成
		 * @return [type] [description]
		 */
		public function make_order()
		{
			$new_data = Request::instance()->get();

			// 初始化数据
			$mg_id = '';
			$m_code = '';
			$c_id = '';
			// 是否购物车购买
			$is_cart = true;
			// 连接售货机数据库
			$mac = Db::connect([
			    // 数据库类型
			    'type'     => 'mysql',
			    // 服务器地址
			    'hostname' => '120.24.167.2',
			    // 数据库名
			    'database' => 'redwine',
			    // 数据库用户名
			    'username' => 'redwine',
			    // 数据库密码
			    'password' => 'customersmima',
			    // 数据库连接端口
			    'hostport' => '3306',
			    // 数据库连接参数
			    'params'   => [],
			    // 数据库编码默认采用utf8
			    'charset'  => 'utf8',
			    // 数据库表前缀
			    'prefix'   => '',
			]);
			if(empty($new_data['payType'])){
            	return json(['data' => '','code' => 400,'message' => '没有获取付款方式！']);
				die;
            }
			if(strstr($new_data['cart_id'],':')){
				$is_cart =false;
			}
		
			// 购物车购买
			if($is_cart == true){

				//获取购物车id
				$cart_id = explode(',',$new_data['cart_id']);
				// 提取购物车商品数据
	            $num = 0;
				foreach ($cart_id as $v) {
					$cart_goods[$v] = Db::name('cart')
									->where('id',$v)
									->find();
					$num += 1;
				}
				if(empty($cart_goods)){
					return json(['data' => '','code' => 400,'message' => '购物车以空,订单已生成！']);
					die;
				}

				// 提取购物车商品数据
				foreach ($cart_goods as $k => $v) {
					if($new_data['is_machine'] == 1){//售货机商品
						// $goods[$k] = Db::name('shop_goods')
						// 			->field('goods_id,m_code')
						// 			->where('id',$v['goods_id'])
						// 			->find();

						// $goods_info = $mac
						// 		->name('goods_info')
						// 		->where('id',$goods[$k]['goods_id'])
						// 		->find();
						// $machine = $mac
						// 		->name('container_info')
						// 		->field('num')
						// 		->where('id',$goods[$k]['goods_id'])
						// 		->find();

						// if(empty($machine)){
						// 	return json(['data' => '','code' => 400,'message' => '该商品已在售货机下架！']);
						// 	die;
						// }

						// if($machine['num'] <= 0 || $machine['num'] < $v['goods_num']){
						// 	return json(['data' => '','code' => 400,'message' => $goods_info['goods_name'].'该商品库存不足！']);
						// 	die;
						// }
						// $cart_goods[$k]['goods_price'] = $goods_info['price'];
						// $cart_goods[$k]['is_machine'] = $new_data['is_machine'];
						// $cart_goods[$k]['image'] = $goods_info['pic_url'];
						// $cart_goods[$k]['title'] = $goods_info['goods_name'];
						// $cart_goods[$k]['stock'] = $machine['num'];
						// $cart_goods[$k]['type'] = 1;
						// $cart_goods[$k]['m_code'] = $goods[$k]['m_code'];
						// $cart_goods[$k]['total'] = sprintf("%.2f", $goods_info['price']* $v['goods_num']);
						// $mg_id = $goods[$k]['goods_id'];
						// $m_code = $goods[$k]['m_code'];
					}else{
						if($v['activity_type'] == 0){//没有活动
							if($v['shop_id'] == 0){//自营店铺
								$goods[$k] = Db::name('goods')
											->alias('g')
											->join('yo_goods_images i','g.id = i.goods_id')
											->field('g.id,g.record_goosnum,g.tax_point,g.stock,g.type,g.title,g.marketprice,g.productprice,g.stock_sta,i.iname')
											->where('g.id',$v['goods_id'])
											->where('i.cover','0')
											->find();

								if($goods[$k]['stock_sta'] == 0){
									if($goods[$k]['stock'] <= 0 || $goods[$k]['stock'] < $v['goods_num']){
										return json(['data' => '','code' => 400,'message' => $goods[$k]['title'].'该商品库存不足！']);
										die;
									}
								}
								// $cart_goods[$k]['goods_price'] = $goods[$k]['productprice'];
								$cart_goods[$k]['goods_price'] = $goods[$k]['marketprice'];
								$cart_goods[$k]['is_machine'] = $new_data['is_machine'];
								$cart_goods[$k]['image'] = $goods[$k]['iname'];
								$cart_goods[$k]['title'] = $goods[$k]['title'];
								$cart_goods[$k]['stock'] = $goods[$k]['stock'];
								$cart_goods[$k]['type'] = $goods[$k]['type'];
								$cart_goods[$k]['sku'] = $goods[$k]['record_goosnum'];
								$cart_goods[$k]['total'] = sprintf("%.2f", $goods[$k]['marketprice'] * $v['goods_num']);
								// $cart_goods[$k]['total'] = sprintf("%.2f", ($goods[$k]['tax_point'] / 100 * $goods[$k]['productprice'] +$goods[$k]['productprice'])* $v['goods_num']);
							}else{//商家店铺
								$goods[$k] = Db::name('shop_goods')
												->alias('sg')
												->join('yo_goods g','g.id = sg.goods_id')
												->join('yo_goods_images i','i.goods_id = sg.goods_id')
												->field('g.id,sg.id as sgid,g.record_goosnum,g.tax_point,sg.stock,g.type,g.title,g.marketprice,g.productprice,i.iname')
												->where('sg.goods_id',$v['goods_id'])
												->where('sg.shop_id',$v['shop_id'])
												->where('i.cover','0')
												->find();

									if($goods[$k]['stock'] <= 0 || $goods[$k]['stock'] < $v['goods_num']){
										return json(['data' => '','code' => 400,'message' => $goods[$k]['title'].'该商品库存不足！']);
										die;
									}

									$cart_goods[$k]['goods_id'] = $goods[$k]['sgid'];
									$cart_goods[$k]['goods_price'] = $goods[$k]['marketprice'];
									$cart_goods[$k]['is_machine'] = $new_data['is_machine'];
									$cart_goods[$k]['image'] = $goods[$k]['iname'];
									$cart_goods[$k]['title'] = $goods[$k]['title'];
									$cart_goods[$k]['stock'] = $goods[$k]['stock'];
									$cart_goods[$k]['type'] = $goods[$k]['type'];
									$cart_goods[$k]['sku'] = $goods[$k]['record_goosnum'];
									$cart_goods[$k]['total'] = sprintf("%.2f", $goods[$k]['marketprice'] * $v['goods_num']);
									// $cart_goods[$k]['total'] = sprintf("%.2f", ($goods[$k]['tax_point'] / 100 * $goods[$k]['productprice'] +$goods[$k]['productprice'])* $v['goods_num']);
							}

						}elseif($v['activity_type'] == 1){// 限时抢购
							$goods[$k] = Db::name('activity_tlimit')
									->alias('t')
									->join('yo_goods g','g.id = t.goods_id')
									->field('g.tax_point,g.record_goosnum,g.type,t.goods_id,t.act_image,t.act_title,t.act_price,t.act_image,t.stock')
									->where('t.id',$v['goods_id'])
									->find();

							if($goods[$k]['stock'] <= 0 || $goods[$k]['stock'] < $v['goods_num']){
								return json(['data' => '','code' => 400,'message' => $goods[$k]['act_title'].'该商品库存不足！']);
								die;
							}

							$cart_goods[$k]['goods_price'] = $goods[$k]['act_price'];
							$cart_goods[$k]['is_machine'] = $new_data['is_machine'];
							$cart_goods[$k]['image'] = $goods[$k]['act_image'];
							$cart_goods[$k]['title'] = $goods[$k]['act_title'];
							$cart_goods[$k]['stock'] = $goods[$k]['stock'];
							$cart_goods[$k]['type'] = $goods[$k]['type'];
							$cart_goods[$k]['sku'] = $goods[$k]['record_goosnum'];
							$cart_goods[$k]['gid'] = $goods[$k]['goods_id'];
							$cart_goods[$k]['total'] = sprintf("%.2f", $goods[$k]['act_price'] * $v['goods_num']);
						}elseif($v['activity_type'] == 2){// 促销活动
							$goods[$k] = Db::name('activity_festival')
									->alias('f')
									->join('yo_goods g','g.id = f.goods_id')
									->field('g.tax_point,g.record_goosnum,g.type,g.marketprice,f.goods_id,f.stock,f.act_title,f.discount,f.act_image')
									->where('f.id',$v['goods_id'])
									->find();

							if($goods[$k]['stock'] <= 0 || $goods[$k]['stock'] < $v['goods_num']){
								return json(['data' => '','code' => 400,'message' => $goods[$k]['act_title'].'该商品库存不足！']);
								die;
							}
							$cart_goods[$k]['goods_price'] = sprintf("%.2f", $goods[$k]['marketprice'] * ($goods[$k]['discount'] / 100));
							$cart_goods[$k]['is_machine'] = $new_data['is_machine'];
							$cart_goods[$k]['image'] = $goods[$k]['act_image'];
							$cart_goods[$k]['title'] = $goods[$k]['act_title'];
							$cart_goods[$k]['stock'] = $goods[$k]['stock'];
							$cart_goods[$k]['type'] = $goods[$k]['type'];
							$cart_goods[$k]['sku'] = $goods[$k]['record_goosnum'];
							$cart_goods[$k]['gid'] = $goods[$k]['goods_id'];
							$cart_goods[$k]['total'] = sprintf("%.2f", $cart_goods[$k]['goods_price'] * $v['goods_num']);
						}
					}
				}
			}else{//直接购买
				// 初始化数据
				$goods_data = explode(':',$new_data['cart_id']);
				$atype = $goods_data[0];//活动类型
				$gid = $goods_data[1];//商品id
				$num = $goods_data[2];//商品数量
				$spec = $goods_data[3];//团购商品规格

				if($spec != 0){
					return json(['data' => '','code' => 400,'message' => '暂无团购商品']);
					die;
				}else{
					if($new_data['is_machine'] == 1){//售货机商品
					
						$machine = $mac
								->name('container_info')
								->field('id,goods_id,num,dev_no')
								->where('id',$gid)
								->find();
						$goods_info = $mac
								->name('goods_info')
								->where('id',$machine['goods_id'])
								->find();
						if($goods_info['is_cuxiao'] == 1){
							$price = $goods_info['cuxiao_price'];
						}else{
							$price = $goods_info['price'];
						}
						if(empty($machine)){
							return json(['data' => '','code' => 400,'message' => '该商品已在售货机下架！']);
							die;
						}

						if($machine['num'] <= 0 || $machine['num'] < $num){
							return json(['data' => '','code' => 400,'message' => $goods_info['goods_name'].'该商品库存不足！']);
							die;
						}
						$m_code = $machine['dev_no'];
						$cart_goods[0]['goods_price'] = $price;
						$cart_goods[0]['is_machine'] = $new_data['is_machine'];
						$cart_goods[0]['image'] = $goods_info['pic_url'];
						$cart_goods[0]['title'] = $goods_info['goods_name'];
						$cart_goods[0]['stock'] = $machine['num'];
						$cart_goods[0]['type'] = 1;
						$cart_goods[0]['m_code'] = $machine['dev_no'];
						$cart_goods[0]['total'] = sprintf("%.2f", $price * $num);
						$cart_goods[0]['sku'] = '';
						$mg_id = $machine['id'];
					}else{
						if($atype == 0){//没有活动
							if($new_data['sid'] == 0){//自营店铺
								$goods[0] = Db::name('goods')
											->alias('g')
											->join('yo_goods_images i','g.id = i.goods_id')
											->field('g.id,g.tax_point,g.record_goosnum,g.stock,g.type,g.title,g.marketprice,g.productprice,g.stock_sta,i.iname')
											->where('g.id',$gid)
											->where('i.cover','0')
											->find();

								if($goods[0]['stock_sta'] == 0){
									if($goods[0]['stock'] <= 0 || $goods[0]['stock'] < $num){
										return json(['data' => '','code' => 400,'message' => $goods[0]['title'].'该商品库存不足！']);
										die;
									}
								}
								// $cart_goods[0]['goods_price'] = $goods[0]['productprice'];
								$cart_goods[0]['goods_price'] = $goods[0]['marketprice'];
								$cart_goods[0]['is_machine'] = $new_data['is_machine'];
								$cart_goods[0]['image'] = $goods[0]['iname'];
								$cart_goods[0]['title'] = $goods[0]['title'];
								$cart_goods[0]['stock'] = $goods[0]['stock'];
								$cart_goods[0]['type'] = $goods[0]['type'];
								$cart_goods[0]['sku'] = $goods[0]['record_goosnum'];
								$cart_goods[0]['total'] = sprintf("%.2f", $goods[0]['marketprice'] * $num);
								// $cart_goods[0]['total'] = sprintf("%.2f", ($goods[0]['tax_point'] / 100 * $goods[0]['productprice'] +$goods[0]['productprice'])* $num);
							}else{//商家店铺
								$goods[0] = Db::name('shop_goods')
												->alias('sg')
												->join('yo_goods g','g.id = sg.goods_id')
												->join('yo_goods_images i','i.goods_id = sg.goods_id')
												->field('g.id,g.record_goosnum,g.tax_point,sg.stock,g.type,g.title,g.productprice,sg.sell_price,i.iname')
												->where('sg.id',$gid)
												->where('i.cover','0')
												->find();

									if($goods[0]['stock'] <= 0 || $goods[0]['stock'] < $num){
										return json(['data' => '','code' => 400,'message' => $goods[0]['title'].'该商品库存不足！']);
										die;
									}
									// $cart_goods[0]['goods_price'] = $goods[0]['productprice'];
									$cart_goods[0]['goods_price'] = $goods[0]['sell_price'];
									$cart_goods[0]['is_machine'] = $new_data['is_machine'];
									$cart_goods[0]['image'] = $goods[0]['iname'];
									$cart_goods[0]['title'] = $goods[0]['title'];
									$cart_goods[0]['stock'] = $goods[0]['stock'];
									$cart_goods[0]['type'] = $goods[0]['type'];
									$cart_goods[0]['sku'] = $goods[0]['record_goosnum'];
									$cart_goods[0]['total'] = sprintf("%.2f", ($goods[0]['sell_price'])* $num);
									// $cart_goods[0]['total'] = sprintf("%.2f", ($goods[0]['tax_point'] / 100 * $goods[0]['productprice'] +$goods[0]['productprice'])* $num);
							}

						}elseif($atype == 1){// 限时抢购
							$goods[0] = Db::name('activity_tlimit')
									->alias('t')
									->join('yo_goods g','g.id = t.goods_id')
									->field('g.tax_point,g.type,g.record_goosnum,t.goods_id,t.act_image,t.act_title,t.act_price,t.act_image,t.stock')
									->where('t.id',$gid)
									->find();

							if($goods[0]['stock'] <= 0 || $goods[0]['stock'] < $num){
								return json(['data' => '','code' => 400,'message' => $goods[0]['act_title'].'该商品库存不足！']);
								die;
							}

							$cart_goods[0]['goods_price'] = $goods[0]['act_price'];
							$cart_goods[0]['is_machine'] = $new_data['is_machine'];
							$cart_goods[0]['image'] = $goods[0]['act_image'];
							$cart_goods[0]['title'] = $goods[0]['act_title'];
							$cart_goods[0]['stock'] = $goods[0]['stock'];
							$cart_goods[0]['type'] = $goods[0]['type'];
							$cart_goods[0]['sku'] = $goods[0]['record_goosnum'];
							$cart_goods[0]['gid'] = $goods[0]['goods_id'];
							$cart_goods[0]['total'] = sprintf("%.2f", $goods[0]['act_price'] * $num);
							// $cart_goods[0]['total'] = sprintf("%.2f", ($goods[0]['tax_point'] / 100 * $goods[0]['act_price'] + $goods[0]['act_price']) * $num);

						}elseif($atype == 2){// 促销活动
							$goods[0] = Db::name('activity_festival')
									->alias('f')
									->join('yo_goods g','g.id = f.goods_id')
									->field('g.tax_point,g.record_goosnum,g.type,g.marketprice,f.goods_id,f.stock,f.act_title,f.discount,f.act_image')
									->where('f.id',$gid)
									->find();

							if($goods[0]['stock'] <= 0 || $goods[0]['stock'] < $num){
								return json(['data' => '','code' => 400,'message' => $goods[0]['act_title'].'该商品库存不足！']);
								die;
							}
							$cart_goods[0]['goods_price'] = sprintf("%.2f", $goods[0]['marketprice'] * ($goods[0]['discount'] / 100));
							$cart_goods[0]['is_machine'] = $new_data['is_machine'];
							$cart_goods[0]['image'] = $goods[0]['act_image'];
							$cart_goods[0]['title'] = $goods[0]['act_title'];
							$cart_goods[0]['stock'] = $goods[0]['stock'];
							$cart_goods[0]['type'] = $goods[0]['type'];
							$cart_goods[0]['sku'] = $goods[0]['record_goosnum'];
							$cart_goods[0]['gid'] = $goods[0]['goods_id'];
							$cart_goods[0]['total'] = sprintf("%.2f", $cart_goods[0]['goods_price'] * $num);
							// $cart_goods[0]['total'] = sprintf("%.2f", ($goods[0]['tax_point'] / 100 * $cart_goods[0]['goods_price'] + $cart_goods[0]['goods_price']) * $num);
						}
					}
				}
				$cart_goods[0]['id'] = $gid;
				$cart_goods[0]['user_id'] = $new_data['uid'];
				$cart_goods[0]['activity_type'] = $atype;
				$cart_goods[0]['goods_num'] = $num;
				$cart_goods[0]['shop_id'] = $new_data['sid'];
				$cart_goods[0]['goods_id'] = $gid;
			}


			// 计算总金额
			$total_price = 0;
			foreach ($cart_goods as $v) {
				$total_price += $v['total'];
			}
			// 订单商品总金额
			// $order['price'] = '0.01';
			$order['price'] = $total_price;
			$order['actualprice'] = $total_price;
	
			// 检测是否有优惠劵
			if(!empty($new_data['coupon_id'])){
				$coupon = Db::name('coupon')
							->where('id',$new_data['coupon_id'])
							->where('user_id',$new_data['uid'])
							->find();
				if(!empty($coupon)){
					if(strtotime($coupon['limit_time']) < time()){
						return json(['data' => '','code' => 400,'message' => '该优惠券已经过期！']);
						die;
					}
					if($coupon['is_use'] = 0){
						return json(['data' => '','code' => 400,'message' => '该优惠券已经使用！']);
						die;
					}
					$order['price'] = $total_price - $coupon['money'];
					$order['bonusprice'] = $coupon['money'];
					$order['coupon_id'] = $new_data['coupon_id'];
					$order['hasbonus'] = 1;
				}
			}
			// 生成店铺数据
			$shop_data = Db::name('shop')
						->where('id',$new_data['sid'])
						->find();
			$seller_id = $shop_data['seller_id'];

			// 获取地址数据
			if($new_data['is_machine'] == 1){
				$seller_address = Db::name('seller_shop')
								->where('machine_code',$m_code)
								->find();
				$order['sendtype'] = 1;
				$order['machine_address'] = $seller_address['address'];
				$order['pick_code'] = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT).str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

			}else{
				$users_address = Db::name('users_address')
							->field('province,city,area,address,mobile,user_name,code')
							->where('id',$new_data['address_id'])
							->find();

				$order['sendtype'] = 0;
				$order['address_province'] = $users_address['province'];
				$order['address_city'] = $users_address['city'];
				$order['address_area'] = $users_address['area'];
				$order['address_address'] = $users_address['address'];
				$order['address_mobile'] = $users_address['mobile'];
				$order['addressid'] = $new_data['address_id'];
				$order['recipients'] = $users_address['user_name'];
				$order['postcode'] = $users_address['code'];
				if(!empty($new_data['idCardName'])){
					$order['idcard'] = $new_data['idCardNum'];
					$order['username'] = $new_data['idCardName'];
				}
			}


			// 生成订单编号

			$order['order_num'] = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

            $randomorder = Db::name('shop_order')
            				->where('order_num',$order['order_num'])
            				->find();
            if(!empty($randomorder))
            {
                $order['order_num'] =  date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

            }


      		
            // 写入订单相关数据
            $order['is_invoice'] = $new_data['is_invoice'];
            $order['company_title'] = $new_data['companyTitle'];
            $order['createtime'] = time();
            $order['uid'] = $new_data['uid'];
            $order['seller_id'] = $seller_id;
        	$order['is_machine'] = $new_data['is_machine'];
        	$order['shop_id'] = $new_data['sid'];
         	$total_num = 0;

			foreach ($cart_goods as $v) {
				$total_num += $v['goods_num'];
            }
    		// 计算总重
    		$total_weight = $total_num * 750;
    		$order['total_weight'] = $total_weight;

    		// 获取立即送配送金额
    		if($new_data['is_machine'] == 2){
    			$province_data = $this->get_provinces();
				$cities_data = $this->get_cities();
				foreach ($province_data as $v) {
					if($v['provinceid'] == $shop_data['province']){
						$shop_data['province'] = $v['province'];
					}
				}
				foreach ($cities_data as $v) {
					if($v['cityid'] == $shop_data['city']){
						$shop_data['city'] = $v['city'];
					}
				}
				$str = mb_substr($shop_data['province'],-1,1); 
				if($str == '市'){
					$shop_data['city'] = $shop_data['province'];
				}
				$express = new Express;
	    		$immediately = $express->immediately($order,$shop_data,true);
    			if($immediately['status'] == 1){
    				$order['price'] = $order['price'] + $immediately['price'];
    				$order['immediate_cost'] = $immediately['price'];
    			}else{
    				return json(['data' => '','code' => 400,'message' => '获取立即送金额失败！']);
					die;
    			}
    		}

    		// 生成订单
            $order_id = Db::name('shop_order')
            			->insertGetId($order);
            if(!empty($order_id)){
            	// 遍历插入商品数据
            	foreach ($cart_goods as $v) {
            		$order_goods = [
            			'orderid' 		=> $order_id,
            			'goodsid' 		=> $v['goods_id'],
            			'price' 		=> $v['goods_price'],
            			// 'price' 		=> '0.01',
            			'total' 		=> $v['total'],
            			'title' 		=> $v['title'],
            			'goods_num' 	=> $v['goods_num'],
            			'createtime' 	=> time(),
            			'iscomment' 	=> 0,
            			'activity_type' => $v['activity_type'],
            			'image' 		=> $v['image'],
            			'is_machine' 	=> $v['is_machine'],
            			'shop_id' 		=> $v['shop_id'],
            			'goods_type' 	=> $v['type'],
            			'mg_id' 		=> $mg_id,
            			'm_code' 		=> $m_code,
            			'record_goosnum'=> $v['sku'],
            		];
            		Db::name('shop_order_goods')
            			->insert($order_goods);
	            	// 减掉商品库存
            		if($v['is_machine'] != 1){
	        			if($v['activity_type'] == 0){
		            		if($v['shop_id'] == 0){
			            		$stock_sta = Db::name('goods')
				            			->field('stock_sta')
										->where('id',$v['goods_id'])
										->find()['stock_sta'];
								if($stock_sta == 0){
									Db::name('goods')
										->where('id',$v['goods_id'])
										->setDec('stock', $v['goods_num']);
								}
		            		}else{
		            			Db::name('shop_goods')
									->where('id',$v['goods_id'])
									->setDec('stock', $v['goods_num']);
		            		}

	        			}elseif($v['activity_type'] == 1){
	        				Db::name('goods')
								->where('id',$v['gid'])
								->setDec('stock', $v['goods_num']);
	        				Db::name('activity_tlimit')
								->where('id',$v['goods_id'])
								->setDec('stock', $v['goods_num']);
	        			}elseif($v['activity_type'] == 2){
	        				Db::name('goods')
								->where('id',$v['gid'])
								->setDec('stock', $v['goods_num']);
	        				Db::name('activity_festival')
								->where('id',$v['goods_id'])
								->setDec('stock', $v['goods_num']);
	        			}
	        		}
            	}

            }else{
            	return json(['data' => '','code' => 400,'message' => '生成订单失败！']);
				die;
            }

            // 清空购物车
            if($is_cart == true){
		       	foreach ($cart_id as $v) {
					Db::name('cart')
						->where('id',$v)
						->delete();
				}
            }
            return $this->to_pay($order['order_num'],$new_data['payType'],1);

		}



		/**
		 * 调用支付接口
		 * @param  string  $order_num [订单号]
		 * @param  string  $type      [支付方式]
		 * @param  integer $seller_id [商家id]
		 * @return [type]             [返回支付生成数据]
		 */
		public function to_pay($order_num='',$type='',$seller_id = 1)
		{
			$order = [];

			// 判断订单号是否为空
			if(empty($order_num)){
				return json(['data' => '','code' => 400,'message' => '获取不到订单号！']);
				die;
			}else{
				$order = Db::name('shop_order')
						->where('order_num',$order_num)
						->find();
			}
			// 获取商家支付信息
			if(!empty($seller_id)){
				$pay_info = Db::name('set_pay')
							->where('seller_id',$seller_id)
							->find();
			}else{
				return json(['data' => '','code' => 400,'message' => '未获得商家信息！']);
				die;
			}

            $Pay = new Pay;//实例化前请先导入类或者使用use语法

           	// 调取支付方式
            if($type == 0){
    //         	$result = $Pay->weixin([
				// 	'body' => $num.'款商品支付',
				// 	'attach' => '一笔订单',
				// 	'out_trade_no' =>  $order['order_num'],
				// 	'total_fee' => $order['price']*100,//订单金额，单位为分，如果你的订单是100元那么此处应该为 100*100
				// 	'time_start' => date("YmdHis"),//交易开始时间
				// 	'time_expire' => date("YmdHis", time() + 604800),//一周过期
				// 	'goods_tag' => '在线充值余额',
				// 	'notify_url' => request()->domain().url('api/order/weixin_notify'),
				// 	'trade_type' => 'APP',
				// 	'spbill_create_ip' => '',
				// ]);

            }elseif($type == 1){
            		$Pay->alipay_config['partner_id'] = $pay_info['ali_partner_id'];
            		$Pay->alipay_config['app_id'] = $pay_info['ali_app_id'];
            		$Pay->alipay_config['public_key'] = $pay_info['ali_public_key'];
            		$Pay->alipay_config['private_key'] = $pay_info['ali_private_key'];

		           	$result = $Pay->alipay($data=array(
		           			'body' => $order_num.'订单支付',
		           			'subject' => '都市贵族红酒',
		           			'out_trade_no' => $order['order_num'],
		           			'timeout_express' => '60m',
		           			'total_amount' => sprintf("%.2f", $order['price']),
		           			// 'total_amount' => '0.01',
		           	));
		           	if($result){
		           		if($order['is_machine'] == 1){
							return json(['data' => $result,'oid' => $order['id'],'pick_code' => $order['pick_code'],'code' => 200,'message' => '支付宝订单生成成功！']);
							die;
		           		}else{
							return json(['data' => $result,'oid' => $order['id'],'pick_code' => '','code' => 200,'message' => '支付宝订单生成成功！']);
							die;
		           		}
		           	}

            }else{
	            // $order['paytypename'] = '银联支付';
            }
		}
		

		/**
		 * 支付宝支付成功回调处理
		 * @return [type] [description]
		 */
		public function back_alipay()
		{
			// 初始化数据
			$data = $_POST;
			$order_num = '';
			$ali_public = '';

			if(!empty($data)){
				$order_num = $data['out_trade_no'];

				// 查询订单信息
				$order = Db::name('shop_order')
						->where('order_num',$order_num)
						->where('status','0')
						->find();
				if(empty($order)){
					Db::name('paylog')
						->insert(['type' => '支付宝','code' => '4000','msg' => '支付异常。订单号：'.$order_num.',该支付订单不存在或已支付！','createtime' => date('Y-m-d H:i:s',time())]);
					die;
				}
				// 查询商户支付信息
				$pay = Db::name('set_pay')
						->where('seller_id','1')
						->find();
				if(empty($pay)){
					Db::name('paylog')
						->insert(['type' => '支付宝','code' => '4001','msg' => '支付异常。订单号：'.$order_num.',该支付订单没有商户支付配置信息！','createtime' => date('Y-m-d H:i:s',time())]);
					die;
				}
				// 获取支付宝公钥
				$ali_public = $pay['ali_public'];
				if(!empty($ali_public)){
					vendor('alipay.aop.AopClient');
					$aop = new AopClient;
					$aop->alipayrsaPublicKey = $ali_public;
					$flag = $aop->rsaCheckV1($data, NULL, "RSA2");
				}
				if(!$flag){
					Db::name('paylog')
						->insert(['type' => '支付宝','code' => '4002','msg' => '支付异常。订单号：'.$order_num.',该支付签名错误！','createtime' => date('Y-m-d H:i:s',time())]);
					die;
				}

				if($order['price'] != $data['total_amount']){
					Db::name('paylog')
						->insert(['type' => '支付宝','code' => '4003','msg' => '支付异常。订单号：'.$order_num.',该支付金额不匹配！','createtime' => date('Y-m-d H:i:s',time())]);
					die;
				}
				if($pay['ali_partner_id'] != $data['seller_id']){
					Db::name('paylog')
						->insert(['type' => '支付宝','code' => '4004','msg' => '支付异常。订单号：'.$order_num.',该支付商家id不匹配！','createtime' => date('Y-m-d H:i:s',time())]);
					die;
				}
				if($pay['ali_app_id'] != $data['app_id']){
					Db::name('paylog')
						->insert(['type' => '支付宝','code' => '4003','msg' => '支付异常。订单号：'.$order_num.',该支付appid不匹配！','createtime' => date('Y-m-d H:i:s',time())]);
					die;
				}
				// 判断是否使用优惠劵
				if($order['hasbonus'] == 1){
					Db::name('coupon')
							->where('id',$order['coupon_id'])
							->update(['is_use' => 0]);
				}
	
				$goods = Db::name('shop_order_goods')
							->where('orderid',$order['id'])
							->find();
				if($order['is_machine'] == 1){
					$url = 'http://wine.frontch.com/app/api/get_order?pcode='.$order['pick_code'].'&id='.$goods['mg_id'].'&order_no='.$order_num;
					file_get_contents($url);
				}
				if($order['is_machine'] == 2){
					$province_data = $this->get_provinces();
					$cities_data = $this->get_cities();
					$shop_data = Db::name('shop')
								->where('id',$order['shop_id'])
								->find();
					foreach ($province_data as $v) {
						if($v['provinceid'] == $shop_data['province']){
							$shop_data['province'] = $v['province'];
						}
					}
					foreach ($cities_data as $v) {
						if($v['cityid'] == $shop_data['city']){
							$shop_data['city'] = $v['city'];
						}
					}
					$str = mb_substr($shop_data['province'],-1,1); 
					if($str == '市'){
						$shop_data['city'] = $shop_data['province'];
					}
					$express = new Express;
		    		$immediately = $express->immediately($order,$shop_data,false);
	    			if($immediately['status'] == 1){
	    				Db::name('shop_order')
							->where('order_num',$order_num)
							->update(['immediately_order_num' => $immediately['orderNo']]);
	    			}else{
	    				return json(['data' => '','code' => 400,'message' => '获取立即送金额失败！']);
						die;
	    			}
				}
				$user = Db::name('users')
						->where('id',$order['uid'])
						->find();
				$order_goods = Db::name('shop_order_goods')
								->where('orderid',$order['id'])
								->select();
				// 跨境商品
				if($goods['goods_type'] == 0){
					$url1 = 'https://customs.openepay.com/customs/mcht_customs_declare.do';
					$customs = new Customs;
					$str = $customs->customs($order_num,$order);
					$this->customs_http($url1,$str);
					Db::name('shop_order')
						->where('order_num',$order_num)
						->update(['customs_request_id' => 'app'.$order_num]);
					$result = $customs->cross_border_oder_push($order,$order_goods);
					Db::name('shop_order')
						->where('order_num',$order_num)
						->update(['customs_order_num' => $result['order_code']]);
				}

				$res = Db::name('shop_order')
						->where('order_num',$order_num)
						->update(['status' => 1,'paytypecode' => 1,'paytypename' => '支付宝']);
				// 增加商品销量
				$this->sales_volume($order_goods);

				// 分享分红
				$bonus = new Bonus();
				$bonus->share_bonus($order,$user);

				if($res !== false){
					$new_data = [
						'title'			=> '订单完成',
						'content'		=> '您的订单;'.$order['order_num'].'|'.$order['id'].';已支付完成。',
						'create_time'	=> date('Y-m-d H:i:s',time()),
						'receiver_type'	=> 0,
						'sid'			=> 0,
						'tid'			=> 3,
						'uid' 			=> $order['uid'],
					];
					$message = Db::name('message')
								->insertGetId($new_data);
					if($message){
						Db::name('message_read')
							->insertGetId(['mid' => $message,'uid' => $order['uid'],'type' => 0,'flag' => 0]);
					}
					Db::name('paylog')
						->insert(['type' => '支付宝','code' => '2000','trade_no' => $data['trade_no'],'msg' => '支付成功。订单号：'.$order_num.'。','createtime' => date('Y-m-d H:i:s',time())]);
					return 'success';
				}

			}

		}

		/**
		 * 微信订单异步通知
		 * @return [type] [description]
		 */
		public function weixin_notify()
		{
			$notify_data = file_get_contents("php://input");//获取由微信传来的数据
			if(!$notify_data){
				$notify_data = $GLOBALS['HTTP_RAW_POST_DATA'] ?: '';//以防上面函数获取到的内容为空
			}
			if(!$notify_data){
				exit('');
			}
			$Pay = new Pay;
			$result = $Pay->notify_weixin($notify_data);//调用模型中的异步通知函数
			exit($result);
		}
	}
