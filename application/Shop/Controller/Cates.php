<?php
	/**
	* @Author: Hkshop
	* 分类管理类
	* @Date:   2016-12-31 15:38:14
	* @Last Modified time: 2016-12-31 16:20:06
	*/

	namespace app\shop\controller;

	use app\shop\controller\Base;
	use think\Db;
	use think\Request;
	use think\Session;
	
	class Cates extends Base
	{

		/**
		 * 分类列表列
		 * @return [type]      [description]
		 */
		public function cate_list()
		{
			$data = Request::instance()->get();
			$total_num = 0;
			$cate_where = empty($data['cid']) ? '' : 'g.cate_id like "%'.$data['cid'].'%"';			
			$title_where = empty($data['title']) ? '' : 'g.title like "%' . $data['title'] . '%"';
			$area_where = empty($data['area']) ? '' : 'g.area_id="' . $data['area'].'"';
			$order = empty($data['order']) ? 2 : $data['order'];
			if($order == 1){
				$order_sort = 'g.click_num desc';
			}elseif($order == 2){
				$order_sort = 'g.sale_number desc';
			}elseif($order == 3){
				$ordorder_sorter = 'g.sort desc';
			}elseif($order == 4){
				$order_sort = 'g.marketprice desc';
			}elseif($order == 5){
				$order_sort = 'g.marketprice asc';
			}
			$is_collection = 0;
			$goods = Db::name('goods')
						->alias('g')
						->join('__GOODS_IMAGES__ i','i.goods_id = g.id')
						->field('i.iname,g.id,g.hk_title,g.eng_title,g.marketprice,g.storeprice,g.cate_id,g.score_id')
 						->where($cate_where)
 						->where($title_where)
 						->where($area_where)
						->where('i.cover',0)
 						->where('g.is_delete',0)
						->where('g.status',0)
						->where('g.is_home',1)
						->where('g.stock','>',0)
						->order($order)
						->select();

			if(!empty($goods)){
				foreach ($goods as $k => &$v) {
					$total_num += 1;
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
				
					// 初始化数据
					$v['score_data'] = '';
					$v['is_collection'] = $is_collection;
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
			// 获取商品区域信息
			$goods_cates = get_goods_area();

			return $this->fetch('cate_list',[
							'goods' 		=> $goods,
							'goods_cate'	=> $goods_cates,
							'area_id'		=> $data['area'],
							'title'			=> $data['title'],
							'total_num'		=> $total_num,
							'order'			=> $order,
							'cid'			=> $data['cid'],
						]);
		}

	}
