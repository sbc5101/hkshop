<?php
	namespace app\api\controller;

	use app\api\controller\Base;
	use think\Validate;
	// use think\db\Query;
	use think\Db;
	use think\Request;
	use think\Cache;

	/**
	* @Author: Yoshop
	* 首页类接口
	* @Date:   2016-12-27 15:38:14
	* @Last Modified time: 2016-12-27 16:20:06
	*/
	class Index extends Base
	{
		public function index()
		{
			return 'index';
		}
		/**
		 * 首页轮播图接口
		 * @param  [int] $status  [暂定]
		 * @return [type]         [返回首页轮播图接口数据]
		 */
		public function carousel($status)
		{	
			$sta = is_numeric($status);

			if($sta){
				if(Cache::get('carousel')){
					$data = Cache::get('carousel'.$status);
				}else{
					$data = Db::name('carousel')
							->where('status',$status)
							->where('display','0')
							->order('sort')
							->select();
					Cache::set('carousel'.$status,$data,3600);
				}
				return json(['data'=>$data,'code'=>200,'message'=>'操作成功']);
			}else{
				return json(['data' => '','code' => 400,'message' => '请求参数错误']);
			}
		}

		/**
		 * 首页活动接口
		 * @param  [int] $status  [暂定]
		 * @return [type]         [返回活动接口数据]
		 */
		public function activity($status)
		{
			$sta = is_numeric($status);
			if($sta){
				if(Cache::get('activity')){
					$data = Cache::get('activity'.$status);
				}else{
					$data = Db::name('activity')
							->field('id,goods_id,act_image,act_title,act_price,act_type,start_time,end_time')
							->where('act_type',$status)
							->where('display','eq','0')
							->where('is_delete','eq','0')
							->order('sort')
							->select();
					Cache::set('activity'.$status,$data,3600);
				}
				return json(['data'=>$data,'code'=>200,'message'=>'操作成功']);
			}else{
				return json(['data' => '','code' => 400,'message' => '请求参数错误']);
			}
		}

		// public function 

	}
 