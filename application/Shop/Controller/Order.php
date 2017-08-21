<?php
	/**
	* @Author: Hkshop
	* 订单
	* @Date:   2017-08-21 15:38:14
	* @Last Modified time: 2017-08-21 16:20:06
	*/

	namespace app\shop\controller;

	use app\shop\controller\Base;
	use think\Db;
	use think\Session;
	use think\Validate;
	use think\Request;

	class Order extends Base
	{
		public function make_order()
		{
			$msg = Request::instance()->post();
			$user_id = Session::get('user.id','hk_shop_user');
			$price = 0;
			// 数据验证
			$rule = [
			    ['pay_id','require','pay_id不能為空'],
			    ['user_name','require','购买人姓名不能為空'],
			    ['user_email','require','购买人邮箱不能為空'],
			    ['shop_id','require','选择店铺id不能為空'],
			    ['pickup_id','require','取货方式不能為空'],
			];
			$data = [
			    'pay_id'  	=> $msg['pay_id'],
			    'user_name' => $msg['user_name'],
			    'user_email'=> $msg['user_email'],
			    'shop_id'  	=> $msg['shop_id'],
			    'pickup_id'  	=> $msg['pickup_id'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($data);

			if(!$result){
				return json(['code' => 400,'message' => $validate->getError()]);
			}
			$cart_goods = Db::name('cart')
							->where('user_id',$user_id)
							->select();
			if(empty($cart_goods)){
				return json(['code' => 404,'message' => '请选择商品']);
			} 
			foreach ($cart_goods as &$v) {
				$goods = Db::name('goods')
							->alias('g')
							->join('__GOODS_IMAGES__ i','i.goods_id=g.id')
							->field('i.iname,g.eng_title,g.hk_title,g.marketprice,g.stock,g.storeprice,g.score_id')
							->where('g.is_delete',0)
							->where('g.id',$v['goods_id'])
							->where('g.is_delete',0)
							->where('g.status',0)
							->where('g.stock','>',0)
							->where('i.cover',0)
							->find();
				if(empty($goods)){
					return json(['code' => 404,'message' => $v['eng_title'].'该商品已下架，请重新选择']);
				}
				if($goods['stock'] < $v['buy_num']){
					if(empty($goods)){
						return json(['code' => 404,'message' => $v['eng_title'].'该商品库存不足，请重新选择']);
					}
				}
				$v['iname'] = $goods['iname'];
				$v['eng_title'] = $goods['eng_title'];
				$v['hk_title'] = $goods['hk_title'];
				$v['marketprice'] = $goods['marketprice'];
				$v['price'] += $goods['marketprice'] * $v['buy_num'];
			}

			$msg['create_time'] = time();
			$msg['user_id'] = $user_id;
			$msg['ordersn'] = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
			$msg['status'] = 1;

			$order_res = Db::name('order')
							->insertGetId($msg);
			if($order_res){
				foreach ($cart_goods as $v) {
					$goods_data =  [
						'goods_id' => $v['id'],
						'price' => $v['marketprice'],
						'iname' => $v['iname'],
						'eng_title' => $v['eng_title'],
						'hk_title' => $v['hk_title'],
						'buy_num' => $v['buy_num'],
						'storeprice' => $v['storeprice'],
						'score_id' => $v['score_id'],
						'order_id' => $order_res,
					];
					$res = Db::name('order_goods')
							->insert($goods_data);
					if(empty($res)){
						return json(['code' => 400,'message' => '订单生成失败']);
					}
					// 减商品库存
					Db::name('goods')
						->where('id',$v['id'])
						->setDec('stock', $v['buy_num']);
				}
			}else{
				return json(['code' => 400,'message' => '订单生成失败']);
			}
			return json(['code' => 200,'message' => '订单生成成功']);
		}

		public function order_detail($oid)
		{
			$order = Db::name('order')
						->where('id',$oid)
						->find();
			if(empty($order)){
				$this->error('訂單不存在!');
			}
			$order['create_time'] = date('d/m/Y H:s',$order['create_time']);
			$order_goods['score_data'] = '';
			$order_goods = Db::name('order_goods')
							->where('order_id',$oid)
							->select();
			$pay_name = Db::name('pay')
						->where('id',$order['pay_id'])
						->find()['title'];
			$pickup = Db::name('pickup')
						->where('id',$order['pickup_id'])
						->find()['pickup_name'];
			$shop = Db::name('shop')
						->where('id',$order['shop_id'])
						->find();
			$total_num = 0;
			if(!empty($order_goods)){
				foreach ($order_goods as &$v) {
					$v['score_data'] = Db::name('goods_score')
						->where('id','in',$v['score_id'])
						->select();
				}
				$total_num += $v['buy_num'];
			}
			return $this->fetch('order_detail',[
					'order' => $order,
					'order_goods' => $order_goods,
					'pay_name' => $pay_name,
					'pickup' => $pickup,
					'shop' => $shop,
					'total_num' => $total_num,
					]);
		}

	}
 