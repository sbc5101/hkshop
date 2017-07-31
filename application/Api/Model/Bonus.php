<?php 
	namespace app\api\model;
	use think\Validate;
	use think\Log;
	use think\Db;
	class Bonus extends \think\Model
	{

		// 访问微商城数据库
		protected  $db1 = [
			    	// 数据库类型
				    'type'     => 'mysql',
				    // 服务器地址
				    'hostname' => '114.55.145.114',
				    // 数据库名
				    'database' => 'ce_chat',
				    // 数据库用户名
				    'username' => 'root',
				    // 数据库密码
				    'password' => 'QxfasdXASD23asd32h',
				    // 数据库连接端口
				    'hostport' => '3306',
				    // 数据库连接参数
				    'params'   => [],
				    // 数据库编码默认采用utf8
				    'charset'  => 'utf8',
				    // 数据库表前缀
				    'prefix'   => '',
				];
		/**
		 * 分享分红
		 * @param  [type] $order [订单数据]
		 * @param  [type] $user  [用户数据]
		 * @return [type]        [description]
		 */
		public function share_bonus($order,$user)
		{
			if(!empty($user)){
				if(!empty($user['superior_id'])){

					$goods = Db::name('shop_order_goods')
							->where('orderid',$order['id'])
							->find();

					if($order['shop_id'] > 0){
						$order_goods = Db::name('shop_order_goods')
									->alias('og')
									->field('g.productprice as price,g.product_category as status,og.goods_num as num')
									->join('__SHOP_GOODS__ sg','sg.id = og.goodsid')
									->join('__GOODS__ g','g.id = sg.goods_id')
									->where('og.orderid',$order['id'])
									->select();
					}else{
						$order_goods = Db::name('shop_order_goods')
									->alias('og')
									->field('g.productprice as price,g.product_category as status,og.goods_num as num')
									->join('__GOODS__ g','g.id = og.goodsid')
									->where('og.orderid',$order['id'])
									->select();
					}

					//判断商品类型
					if($goods['activity_type'] == 0){
						if($goods['goods_type'] == 0){
							$profit_star = Db::name('share_bonus')
										->where('type',0)
										->where('status',0)
										->find();
							$profit_me = Db::name('share_bonus')
										->where('type',0)
										->where('status',1)
										->find();
						}elseif($goods['goods_type'] == 1){
							$profit_star = Db::name('share_bonus')
										->where('type',1)
										->where('status',0)
										->find();
							$profit_me = Db::name('share_bonus')
										->where('type',1)
										->where('status',1)
										->find();
						} 
					}elseif($goods['activity_type'] == 3){
						$profit_star = Db::name('share_bonus')
										->where('type',2)
										->where('status',0)
										->find();
						$profit_me = Db::name('share_bonus')
										->where('type',2)
										->where('status',1)
										->find();
					}

					$province_price = 0;
					$city_price 	= 0;
					$area_price 	= 0;
					foreach ($order_goods as $v) {
						if($v['status'] == 0){
							$province_price += sprintf("%.2f", $v['price'] * ($profit_star['province'] / 100));
							$city_price 	+= sprintf("%.2f", $v['price'] * ($profit_star['city'] / 100));
							$area_price 	+= sprintf("%.2f", $v['price'] * ($profit_star['area'] / 100));
						}else{
							$province_price += sprintf("%.2f", $v['price'] * ($profit_me['province'] / 100));
							$city_price 	+= sprintf("%.2f", $v['price'] * ($profit_me['city'] / 100));
							$area_price 	+= sprintf("%.2f", $v['price'] * ($profit_me['area'] / 100));
						}
					}
 					$p_pagent['id'] = '';
 					$c_pagent['id'] = '';
 					$pagent['id'] = '';

					// 查询上级代理人合伙人用户
					$account = Db::name('users')
								->where('id',$user['superior_id'])
								->find();
					// 省代
					if($account['agent_id'] == 1){
						// 插入下关数据
						Db::name('users')
							->where('id', $account['id'])
							->setInc('share_amount',$province_price);

						Db::name('order_profit')
							->insert(['uid' => $account['id'],'order_num' => $order['order_num'],'profit' => $province_price,'platform_type' => 1]);

						Db::name('order_report')
							->insert(['p_uid' => $account['id'],'order_num' => $order['order_num'],'p_profit' => $province_price,'platform_type' => 1]);	

					}elseif($account['agent_id'] == 2){//市代
						// 查询市代上级
						$superior = Db::name('users')
									->where('id',$account['superior_id'])
									->find();
						if(!empty($superior['id'])){
							// 查询省代信息
							$pagent['id'] = $superior['id'];
					
							// 插入下关数据
							Db::name('users')
								->where('id',$superior['id'])
								->setInc('share_amount',$province_price);

							Db::name('order_profit')
								->insert(['uid' => $superior['id'],'order_num' => $order['order_num'],'profit' => $province_price,'platform_type' => 1]);	
						}

						// 插入下关数据
						Db::name('users')
							->where('id',$account['id'])
							->setInc('share_amount',$city_price);

						Db::name('order_profit')
							->insert(['uid' => $account['id'],'order_num' => $order['order_num'],'profit' => $city_price,'platform_type' => 1]);
						
						Db::name('order_report')
							->insert(['p_uid' => $pagent['id'],'order_num' => $order['order_num'],'p_profit' => $province_price,'c_uid' => $superior['id'],'c_profit' => $city_price,'platform_type' => 1]);
					}elseif($account['agent_id'] == 3){//业务员
						// 查询业务员上级
						$city_superior = Db::name('users')
										->where('id',$account['superior_id'])
										->find();
						if(!empty($city_superior['superior_id'])){
							if($city_superior['agent_id'] == 2){//市代
								$c_pagent['id'] = $city_superior['id'];
								// 插入下关数据
								Db::name('users')
									->where('id',$city_superior['id'])
									->setInc('share_amount',$city_price);
								Db::name('order_profit')
									->insert(['uid' => $city_superior['id'],'order_num' => $order['order_num'],'profit' => $city_price,'platform_type' => 1]);			
								// 查询市代上级
								if(!empty($city_superior['superior_id'])){
									// 查询省代信息
									$p_pagent = Db::name('users')
												->where('id',$city_superior['superior_id'])
												->find();
									
									// 插入下关数据
									Db::name('users')
										->where('id',$p_pagent['id'])
										->setInc('share_amount',$province_price);
									Db::name('order_profit')
										->insert(['uid' => $p_pagent['id'],'order_num' => $order['order_num'],'profit' => $province_price,'platform_type' => 1]);
								}
							}elseif($city_superior['agent_id'] == 1){//省代
								// 插入下关数据
								$p_pagent['id'] = $city_superior['id'];
								Db::name('users')
									->where('id',$city_superior['id'])
									->setInc('share_amount',$province_price);
								Db::name('order_profit')
									->insert(['uid' => $city_superior['id'],'order_num' => $order['order_num'],'profit' => $province_price,'platform_type' => 1]);
							}
						}
						// 插入下关数据
						Db::name('users')
							->where('id',$account['id'])
							->setInc('share_amount',$area_price);
						Db::name('order_profit')
							->insert(['uid' => $account['id'],'order_num' => $order['order_num'],'profit' => $area_price,'platform_type' => 1]);
						Db::name('order_report')
							->insert(['p_uid' => $p_pagent['id'],'p_profit' => $province_price,'c_uid' => $c_pagent['id'],'c_profit' => $city_price,'cl_uid' => $account['id'],'order_num' => $order['order_num'],'cl_profit' => $area_price,'platform_type' => 1]);
					}
				}
			}
		}
	}






 ?>