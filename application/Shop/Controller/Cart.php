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
			$total = 0;
			if(!empty($cart_data)){
				foreach ($cart_data as $k => &$v) {
					$goods = Db::name('goods')
								->alias('g')
								->join('__GOODS_IMAGES__ i','i.goods_id = g.id')
								->field('g.marketprice,g.hk_title,g.eng_title,g.score_id,i.iname')
								->where('g.id',$v['goods_id'])
								->where('g.is_delete',0)
								->where('g.status',0)
								->where('i.cover',0)
								->find();
					if(!empty($goods)){
						if(!empty($goods['score_id'])){
							$score = Db::name('goods_score')
										->field('score_num,mechanism')
										->where('id','in',$goods['score_id'])
										->select();
							$v['score'] = $score;
						}else{
							$v['score'] = [];
						}
						$v['marketprice'] = $goods['marketprice'];
						$v['hk_title'] = $goods['hk_title'];
						$v['eng_title'] = $goods['eng_title'];
						$v['iname'] = $goods['iname'];
						$total += $goods['marketprice'] * $v['buy_num'];
					}else{
						unset($cart_data[$k]);
					}
				}
			}
			return $this->fetch('shopping_cart',[
										'cart_data' => $cart_data,
										'total' => $total,
										]);
		}

		/**
		 * 删除购物车商品
		 * @return [type] [description]
		 */
		public function del_cart()
		{
			$data = Request::instance()->post();
			$user_id = Session::get('user.id','hk_shop_user');
			// 初始化数据
			$total = 0;
			$cart_data = '';

			if(!empty($user_id)){
				$res = Db::name('cart')
						->where('goods_id',$data['goods_id'])
						->where('user_id',$user_id)
						->delete();
				if($res == false){
					return json(['code' => '400','message' => '删除购物车商品失败']);
				}
				$cart_data = Db::name('cart')
								->where('goods_id',$data['goods_id'])
								->where('user_id',$user_id)
								->select();
			}else{
				$cart_data = Cookie::get('cart_info','hk_shop');
				if(!empty($cart_data)){
					$cart_data = json_decode($cart_goods,true);
					foreach ($cart_data as $k => $v) {
						if($v['goods_id'] == $data['goods_id']){
							unset($cart_data[$k]);
							break;
						}
					}
					Cookie::set('cart_info',json_encode($cart_goods),[
							'prefix'=>'hk_shop',
							'expire' => 0
							]);
				}
			}
			if(!empty($cart_data)){
				foreach ($cart_data as $v) {
					$price = Db::name('goods')
								->field('marketprice')
								->where('id',$v['goods_id'])
								->where('is_delete',0)
								->where('status',0)
								->find()['marketprice'];
					$total += $price * $v['buy_num'];			
				}
			}
			return json([
							'code' => '200',
							'message' => '删除购物车商品成功',
							'data' => ['total' => $total]
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
						'message' => '添加商品成功',
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

		/**
		 * 修改商品数量
		 * @return [type] [description]
		 */
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
			// 购物车商品总金额
			$total = 0;
			if(!empty($user_id)){
				$res = Db::name('cart')
						->where('user_id',$data['goods_id'])
						->update(['buy_num' => $data['buy_num']]);
				if($res == false){
					return json(['code' => '400','message' => '添加商品失敗！']);
				}
				// 查询购物车商品
				$cart_goods = Db::name('cart')
								->where('user_id',$user_id)
								->select();
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
			// 计算购物车商品总金额
			if(!empty($cart_goods)){
				foreach ($cart_goods as $v) {
					$price = Db::name('goods')
								->field('marketprice')
								->where('id',$v['goods_id'])
								->find()['marketprice'];
					$total += $price * $buy_num;
				}
			}
			return json([
						'code' => '200',
						'message' => '添加商品成功！',
						'data' => [
								'total_buy_num' => $total_buy_num,
								'total' => $total_buy_num
								],
						]);
		}
	}
 