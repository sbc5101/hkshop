<?php
	/**
	* @Author: Hkshop
	* 后台首页类
	* @Date:   2016-12-29 15:38:14
	* @Last Modified time: 2016-12-29 16:20:06
	*/

	namespace app\shop\controller;

	use think\Controller;
	use think\Request;
	use think\Db;
	use think\Cache;
	use think\Session;

	class Index extends Controller
	{
		public function index()
		{
			$area_id = Request::instance()->get('area');
			$title = Request::instance()->get('title');
			// 初始化值
			$user_id = Session::get('user.id','hk_shop_user');
			$area_id = empty($area_id) ? 2 : $area_id;
			$most_goods = [];
			$new_goods = [];
			$red_goods = [];
			$white_goods = [];
			$champagne_goods = [];
			$is_collection = 0;
			// 查询商品信息
			$goods = Db::name('goods')
						->alias('g')
						->join('__GOODS_IMAGES__ i','i.goods_id = g.id')
						->field('i.iname,g.id,g.hk_title,g.eng_title,g.marketprice,g.storeprice,g.cate_id,g.score_id')
						->where('i.cover',0)
						->where('g.area_id',$area_id)
						->where('g.is_delete',0)
						->where('g.status',0)
						->where('g.is_home',1)
						->where('g.stock','>',0)
						->select();
			if(!empty($goods)){
				foreach ($goods as $k => $v) {
					if(!empty($user_id)){
						// 判斷該商品是否收藏
						$collection = Db::name('goods_collection')
										->field('id')
										->where('user_id',$user_id)
										->where('goods_id',$v['id'])
										->find();
						if(!empty($collection)){
							$is_collection = 1;
						}else{
							$is_collection = 0;
						}
					}
					$cate_id = explode(',', $v['cate_id']);
					// MOST POPULAR RED WINE
					if(in_array(382,$cate_id) !== false){
						$most_goods[$k] = $v;
						// 初始化数据
						$most_goods[$k]['score_data'] = '';
						$most_goods[$k]['is_collection'] = $is_collection;
						// 查询获奖数据
						if(!empty($v['score_id'])){
							$most_goods[$k]['score_data'] = Db::name('goods_score')
								->field('score_num,mechanism')
								->where('id','in',$v['score_id'])
								->limit(3)
								->select();
						}
					}
					// NEW ARRIVALS
					if(in_array(386,$cate_id) !== false){
						$new_goods[$k] = $v;
						// 初始化数据
						$new_goods[$k]['score_data'] = '';
						$new_goods[$k]['is_collection'] = $is_collection;
						// 查询获奖数据
						if(!empty($v['score_id'])){
							$new_goods[$k]['score_data'] = Db::name('goods_score')
								->field('score_num,mechanism')
								->where('id','in',$v['score_id'])
								->limit(3)
								->select();
						}					
					}

					// RED WINE
					if(in_array(377,$cate_id) !== false){
						$red_goods[$k] = $v;
						// 初始化数据
						$red_goods[$k]['score_data'] = '';
						$red_goods[$k]['is_collection'] = $is_collection;
						// 查询获奖数据
						if(!empty($v['score_id'])){
							$red_goods[$k]['score_data'] = Db::name('goods_score')
								->field('score_num,mechanism')
								->where('id','in',$v['score_id'])
								->limit(3)
								->select();
						}

					}
					// WHITE WINE
					if(in_array(387,$cate_id) !== false){
						$white_goods[$k] = $v;
						// 初始化数据
						$white_goods[$k]['score_data'] = '';
						$white_goods[$k]['is_collection'] = $is_collection;
						// 查询获奖数据
						if(!empty($v['score_id'])){
							$white_goods[$k]['score_data'] = Db::name('goods_score')
								->field('score_num,mechanism')
								->where('id','in',$v['score_id'])
								->limit(3)
								->select();
						}
					}
					// CHAMPAGNE & SPARKLING
					if(in_array(388,$cate_id) !== false){
						$champagne_goods[$k] = $v;
						// 初始化数据
						$champagne_goods[$k]['score_data'] = '';
						$champagne_goods[$k]['is_collection'] = $is_collection;
						// 查询获奖数据
						if(!empty($v['score_id'])){
							$champagne_goods[$k]['score_data'] = Db::name('goods_score')
								->field('score_num,mechanism')
								->where('id','in',$v['score_id'])
								->limit(3)
								->select();
						}
					}
				}
			}
			
			// 获取商品地区信息
			$goods_areas = $this->get_areas();
			// 获取轮播图广告信息
			$carousel = $this->get_carousel();
			return $this->fetch('index',[
					'most_goods' 		=> $most_goods,
					'new_goods' 		=> $new_goods,
					'red_goods' 		=> $red_goods,
					'white_goods' 		=> $white_goods,
					'champagne_goods' 	=> $champagne_goods,
					'goods_areas' 		=> $goods_areas,
					'area_id' 			=> $area_id,
					'carousel' 			=> $carousel,
				]);
		}

		/**
		 * 获取商品地区信息
		 * @return [type] [description]
		 */
		public function get_areas()
		{
			$area_data = Cache::get('goods_areas');
			if(!empty($area_data)){
				return $area_data;
			}
			// 查询地区信息
			$area_data = Db::name('goods_areas')
							->where('display',1)
							->select();
			Cache::set('goods_areas',$area_data,3600);
			return $area_data;
		}

		/**
		 * 获取轮播图信息
		 * @return [type] [description]
		 */
		public function get_carousel()
		{
			$advert_carousel = Cache::get('advert_carousel');
			if(!empty($advert_carousel)){
				return $advert_carousel;
			}
			// 查询地区信息
			$advert_carousel = Db::name('advert_carousel')
								->where('display',1)
								->order('sort','desc')
								->select();
			Cache::set('advert_carousel',$advert_carousel,3600);
			return $advert_carousel;
		}
	}
 