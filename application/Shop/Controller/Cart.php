<?php
	/**
	* @Author: Yoshop
	* 购物车类
	* @Date:   2016-12-29 15:38:14
	* @Last Modified time: 2016-12-29 16:20:06
	*/

	namespace app\shop\controller;

	use think\Controller;
	use think\Request;
	use think\Db;
	use think\Cookie;
	use think\Session;
	use think\Validate;

	class Cart extends Controller
	{
		public function shopping_cart()
		{
			$user_id = Session::get('user.id','hk_shop_user');
			if(!empty($user_id)){
				$cart_data = Cookie::get('cart_info','hk_shop');
				if(!empty($cart_data)){
					$cart_data = json_decode($cart_data,true);
					foreach ($cart_data as $v) {
						$res = Db::name('cart')
								->field('id')
								->where('user_id',$user_id)
								->where('goods_id',$v['goods_id'])
								->find();
						if(empty($res)){
							Db::name('cart')
								->insert([
									'user_id' 	=> $user_id,
									'goods_id' 	=> $v['goods_id'],
									'buy_num' 	=> $v['buy_num']
									]);
						}
					}
					Cookie::delete('cart_info','hk_shop');
				}else{
					$cart_data = Db::name('cart')
									->where('user_id',$user_id)
									->select();
				}
			}
			return $this->fetch('shopping_cart',[
										'cart_data' => $cart_data,
										]);
		}

		/**
		 * 添加商品到购物车
		 */
		public function add_cart()
		{
			$data = Request::instance()->post();
			$user_id = Session::get('user.id','hk_shop_user');
			// 检测数据
			$check_data = $this->check_data($data);

			if(!empty($check_data)){
				return $check_data;
			}
			// 检测商品是否存在
			$stock = Db::name('goods')
					->field('id,stock')
					->where('id',$data['goods_id'])
					->where('is_delete',0)
					->where('status',0)
					->find()['stock'];
			if(empty($stock)){
				return json(['code' => '400','message' => '商品不存在！']);
			}
			//购物车所有商品数量
			$total_buy_num = 0;

			if(!empty($user_id)){
				$cart_data = Db::name('cart')
								->field('id,buy_num')
								->where('user_id',$user_id)
								->where('goods_id',$data['goods_id'])
								->find()['id'];
				if($stock == 0 || $stock < $cart_data['buy_num'] + $data['buy_num']){
					return json(['code' => '400','message' => '商品庫存不足']);
				}
				if(!empty($cart_data)){
					$res = Db::name('cart')
							->where('id',$cart_data['id'])
							->setInc('buy_num',$data['buy_num']);
				}else{
					if($stock == 0 || $stock < $data['buy_num']){
						return json(['code' => '400','message' => '商品庫存不足']);
					}
					$res = Db::name('cart')
							->insert([
									'user_id' 	=> $user_id,
									'goods_id' 	=> $data['goods_id'],
									'buy_num' 	=> $data['buy_num']
									]);
				}
				if($res == false){
					return json(['code' => '400','message' => '添加商品失敗！']);
				}
				$total_buy_num = Db::name('cart')
									->where('user_id',$user_id)
									->sum('buy_num');
			}else{
				$cart_goods = Cookie::get('cart_info','hk_shop');
				if(!empty($cart_goods)){
					// 初始化数据
					$cart_goods = json_decode($cart_goods,true);
					$i = 0;
					// 判断数据是否存在
					$is_exist = 1;
					foreach ($cart_goods as &$v) {
						if($v['goods_id'] == $data['goods_id']){
							$v['buy_num'] = $v['buy_num'] + $data['buy_num'];
							$is_exist = 0;
							$cookie_buy_num = $v['buy_num'] + $data['buy_num'];
						}
						$i++;
					}
					// 不存在累加
					if($is_exist == 1){
						$cart_goods[$i] = [
							'goods_id' => $data['goods_id'],
							'buy_num' => $data['buy_num'],
						];
					}
				}else{
					$cart_goods[0] = [
						'goods_id' => $data['goods_id'],
						'buy_num' => $data['buy_num'],
					];
					if($stock == 0 || $stock < $data['buy_num']){
						return json(['code' => '400','message' => '商品庫存不足']);
					}
				}
				
				foreach ($cart_goods as $v) {
					$total_buy_num += $v['buy_num'];
				}
				Cookie::set('cart_info',json_encode($cart_goods),[
							'prefix'=>'hk_shop',
							'expire' => 0
							]);
			}

			return json([
						'code' => '200',
						'message' => '添加商品成功！',
						'data' => [
								'total_buy_num' => $total_buy_num
								],
						]);
		}

		/**
		 * 检测数据
		 * @param  [type] $data [description]
		 * @return [type]       [description]
		 */
		public function check_data($data)
		{
			$rule = [
				['goods_id','require|number','商品ID不能為空|參數錯誤'],
				['buy_num','require|number','購買数量不能為空|參數錯誤'],
				
			];
			$msg = [
				'goods_id'  => $data['goods_id'],
				'buy_num'  => $data['buy_num'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			if(!$result){
			   return json(['code' => '400','message' => $validate->getError()]);
			}
		}

		public function rev_cart_goods()
		{
			$data = Request::instance()->post();
			// 检测数据
			$check_data = $this->check_data($data);

			if(!empty($check_data)){
				return $check_data;
			}

			// 检测商品是否存在
			$stock = Db::name('goods')
					->field('id,stock')
					->where('id',$data['goods_id'])
					->where('is_delete',0)
					->where('status',0)
					->find()['stock'];
			if(empty($stock)){
				return json(['code' => '400','message' => '商品不存在！']);
			}
			if($stock == 0 || $data['buy_num'] > $stock){
				return json(['code' => '400','message' => '商品庫存不足']);
			}
			$user_id = Session::get('user.id','hk_shop_user');
			//购物车所有商品数量
			$total_buy_num = 0;
			if(!empty($user_id)){

				$res = Db::name('cart')
						->where('user_id',$data['goods_id'])
						->update(['buy_num' => $data['buy_num']]);
				if($res == false){
					return json(['code' => '400','message' => '添加商品失敗！']);
				}
				$total_buy_num = Db::name('cart')
									->where('user_id',$user_id)
									->sum('buy_num');
			}else{
				$cart_goods = Cookie::get('cart_info','hk_shop');
				if(!empty($cart_goods)){
					// 初始化数据
					$cart_goods = json_decode($cart_goods,true);
					$i = 0;
					foreach ($cart_goods as &$v) {
						if($v['goods_id'] == $data['goods_id']){
							$v['buy_num'] = $data['buy_num'];
						}
						$i++;
					}
					$cart_goods[$i] = [
						'goods_id' => $data['goods_id'],
						'buy_num' => $data['buy_num'],
					];
				}else{
					$cart_goods[0] = [
						'goods_id' => $data['goods_id'],
						'buy_num' => $data['buy_num'],
					];
				}
				foreach ($cart_goods as $v) {
					$total_buy_num += $v['buy_num'];
				}
			}
			return json([
						'code' => '200',
						'message' => '添加商品成功！',
						'data' => [
								'total_buy_num' => $total_buy_num
								],
						]);
		}
	}
 