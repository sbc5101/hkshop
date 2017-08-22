<?php
	namespace app\shop\controller;

	use app\shop\controller\Base;
	use think\Validate;
	use think\Db;
	use think\Request;
	use think\Session;
	/**
	* @Author: Yoshop
	* 个人中心类
	* @Date:   2016-12-30 15:38:14
	* @Last Modified time: 2016-12-30 16:20:06
	*/
	class Member extends Base 
	{
		/**
		 * 个人中心
		 * @return [type] [后台会员数据]
		 */
		public function personal_center()
		{	
			$first_name = Session::get('user.first_name','hk_shop_user');
			$last_name = Session::get('user.last_name','hk_shop_user');
			$user_id = Session::get('user.id','hk_shop_user');
			$name =  $last_name . ' ' . $first_name;
			// 获取收藏信息
			$collection = $this->get_collection($user_id);
			// 获取订单信息
			$order = $this->get_order($user_id);
	
			return $this->fetch('personal_center',[
						'name' 			=> $name,
						'collection' 	=> $collection,
						'order' 		=> $order,
					]);
		}

		public function get_order($uid)
		{
			$order = Db::name('order')
						->field('price,create_time,ordersn,id')
						->where('user_id',$uid)
						->select();
			if(!empty($order)){
				foreach ($order as &$v) {
					$v['create_time'] = date('d/m/Y',$v['create_time']);
					$goods = Db::name('order_goods')
									->where('order_id',$v['id'])
									->select();
					$v['goods'] = '';
					$v['total_num'] = 0;
					if(!empty($goods)){
						foreach ($goods as $val) {
							$v['total_num'] += $val['buy_num'];
						}
						$goods[0]['score_data'] = '';
						if(!empty($goods[0]['score_id'])){
							$goods[0]['score_data'] = Db::name('goods_score')
										->field('score_num,mechanism')
										->where('id','in',$goods[0]['score_id'])
										->limit(3)
										->select();
						}
						$v['goods'] = $goods[0];
					}
				}
			}
			return $order;
		}

		/**
		 * 获取用户收藏信息
		 * @param  [type] $uid [用户ID]
		 * @return [type]      [description]
		 */
		public function get_collection($uid)
		{	
			$collection = Db::name('goods_collection')
							->alias('c')
							->join('__GOODS__ g','g.id=c.goods_id')
							->join('__GOODS_IMAGES__ i','i.goods_id=g.id')
							->field('g.id,g.eng_title,g.hk_title,g.marketprice,i.iname,c.create_time,g.storeprice,g.score_id')
							->where('i.cover',0)
							->where('c.user_id',$uid)
							->select();
		
			if(!empty($collection)){
				foreach ($collection as &$v) {
					$v['create_time'] = date('d/m/Y',$v['create_time']);
					// 查询获奖数据
					if(!empty($v['score_id'])){
						$v['score_data'] = Db::name('goods_score')
							->field('score_num,mechanism')
							->where('id','in',$v['score_id'])
							->limit(3)
							->select();
					}
				}
			}
			return $collection;
		}
	}