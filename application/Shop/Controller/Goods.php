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
	use think\Session;
	use think\Validate;
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

		/**
		 * 用户收藏和取消商品
		 * @return [type] [description]
		 */
		public function action_goods_collection()
		{
			$user_id = Session::get('user.id','hk_shop_user');
			$data = Request::instance()->post();
			// 检测用户是否登录
			if(empty($user_id)){
				return json(['code' => 401,'message' => '未登录授权']);
			}
			$rule = [
				['goods_id','require|number','商品ID不能為空|參數錯誤'],
				
			];
			$msg = [
				'goods_id'  => $data['goods_id'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			if(!$result){
			   return json(['code' => '400','message' => $validate->getError()]);
			}
			$goods = Db::name('goods')
						->field('id')
						->where('id',$data['goods_id'])
						->where('is_delete',0)
						->where('status',0)
						->find();
			// 检测商品数据
			if(empty($goods)){
				return json(['code' => 400,'message' => '商品不存在']);
			}else{
				$collection = Db::name('goods_collection')
								->field('id')
								->where('goods_id',$data['goods_id'])
								->where('user_id',$user_id)
								->find();
				if(!empty($collection)){
					$res = Db::name('goods_collection')
							->where('id',$collection['id'])
							->delete();
					if($res == false){
						return json(['code' => 400,'message' => '取消收藏失败','data' => ['is_collection' => 0]]);
					}else{
						return json(['code' => 200,'message' => '取消收藏成功','data' => ['is_collection' => 0]]);
					}
				}else{
					$res = Db::name('goods_collection')
							->insert([
										'goods_id' => $data['goods_id'],
										'user_id' => $user_id,
									]);
					if($res == false){
						return json(['code' => 400,'message' => '收藏失败','data' => ['is_collection' => 1]]);
					}else{
						return json(['code' => 200,'message' => '收藏成功','data' => ['is_collection' => 1]]);
					}
				}
			}

		}
	}
 