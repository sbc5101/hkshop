<?php 
	use think\Session;
	use think\Db;
	use think\Cookie;
	use think\Cache;

	/**
	 * 获取分类数据
	 * @return [type] [description]
	 */
	function get_cates()
	{
		if(!empty(Cache::get('shop_cates'))){
			return Cache::get('shop_cates');
		}
		$data = Db::name('cates')
					->cache('shop_cates',3600)
					->select();
		// 排序
		return $data;
	}

	/**
	 * 获取商品地区信息
	 * @return [type] [description]
	 */
	function get_goods_area()
	{
		$data = Db::name('goods_areas')
					->where('display',1)
					->select();
		return $data;
	}

	/**
	 * 获取购物车所有商品数量
	 * @return [type] [description]
	 */
	function get_total_buy_num()
	{
		$user_id = Session::get('user.id','hk_shop_user');
		$cart_data = Cookie::get('cart_info','hk_shop');
		$total_buy_num = 0;
		$cookie_buy_num = 0;
		if(!empty($user_id)){
			$total_buy_num = Db::name('cart')
								->where('user_id',$user_id)
								->sum('buy_num');
			if(!empty($cart_goods)){
				$cart_data = json_decode($cart_data,true);
				foreach ($cart_data as $v) {
					$cookie_buy_num += $v['buy_num'];
				}
			}
			$total_buy_num += $cookie_buy_num;
		}else{
			if(!empty($cart_goods)){
				$cart_data = json_decode($cart_data,true);
				foreach ($cart_data as $v) {
					$total_buy_num += $v['buy_num'];
				}
			}
		}
		return $total_buy_num;
	}
 ?>