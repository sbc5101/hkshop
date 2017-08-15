<?php
	/**
	* @Author: Yoshop
	* 商品类
	* @Date:   2016-12-29 15:38:14
	* @Last Modified time: 2016-12-29 16:20:06
	*/

	namespace app\shop\controller;

	use think\Controller;
	use think\Request;
	use think\Db;
	// use think\Cache;

	class Goods extends Controller
	{
		/**
		 * 商品详情页面
		 * @param  [type] $id [description]
		 * @return [type]     [description]
		 */
		public function goods_detail($id)
		{
			// 初始化值
			$chateau_data = [];
			$score_data = [];

			$data = Db::name('goods')
						->where('id',$id)
						->find();

			$goods_images = Db::name('goods_images')
								->where('goods_id',$id)
								->order('cover','asc')
								->select();
			if(!empty($data['score_id'])){
				$score_data = Db::name('goods_score')
								->where('id','in',$data['score_id'])
								->select();
			}
			if(!empty($data['chateau_id'])){
				$chateau_data = Db::name('goods_chateau')
								->where('id',$data['chateau_id'])
								->find();
			}
		
			return $this->fetch('goods_detail',[
					'goods_images' 	=> $goods_images,
					'data' 			=> $data,
					'score_data' 	=> $score_data,
					'chateau_data' 	=> $chateau_data,
				]);
		}

	}
 