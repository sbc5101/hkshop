<?php
	/**
	* @Author: Hkshop
	* 后台广告管理类
	* @Date:   2017-08-14 15:38:14
	* @Last Modified time: 2017-08-14 16:20:06
	*/

	namespace app\admin\controller;

	use app\admin\controller\Base;
	use app\admin\model\ExcelToArrary;
	use think\Validate;
	use think\Db;
	use think\Request;
	use think\Cache;

	class Advert extends Base
	{
		/**
		 * 轮播图列表
		 * @return [type] [description]
		 */
		public function carousel_list()
		{
			$data = Db::name('advert_carousel')
					->order('sort','desc')
					->paginate(20);

			return $this->fetch('carousel_list',['data' => $data]);
		}

		/**
		 * 添加轮播图操作
		 */
		public function add_carousel()
		{
			return $this->fetch('add_carousel');
		}

		/**
		 * 添加轮播图动作
		 * @return [type] [添加轮播图是否成功]
		 */
		public function action_add_carousel()
		{
			// 接收数据
			$msg = Request::instance()->post();
			$file = Request::instance()->file('image');
	
			if(empty($file) && !isset($file)){
					$this->error('轮播图不能为空！');
			}else{
				$filemsg = $this->upload($file);
				if(!$filemsg){
					$this->error($filemsg);
				}
			}
			// 插入数据
			$msg['create_time'] = date('Y-m-d H:i:s',time());
			$msg['img_name'] = str_replace('\\','/','/public/uploads/'.date('Ymd') .'/'. $filemsg);

			// 添加商品数据
			$res = Db::name('advert_carousel')
						->cache('advert_carousel')
						->insertGetId($msg);
			if($res){
				$this->run_log('新增轮播图广告数据操作。');
				$this->success('添加成功！');
			}else{
				$this->error('添加失败！');
			}	
			
		}

		/**
		 * 修改轮播图操作
		 * @param  [type] $id [轮播图id]
		 * @return [type]     [description]
		 */
		public function rev_carousel($id)
		{	
			$data = Db::name('advert_carousel')
					->where('id',$id)
					->find();

			return $this->fetch('rev_carousel',[
					'id' 	=> $id,
					'data' 	=> $data,
				]);
		}

		/**
		 * 轮播图修改动作
		 * @return [type] [是否修改成功]
		 */
		public function action_rev_carousel()
		{
			$msg = Request::instance()->post();
			$file = Request::instance()->file('image');
			$img_name = '';
			if(!empty($file) && isset($file)){
				$filemsg = $this->upload($file);
				if(!$filemsg){
					$this->error($filemsg);
				}
				$msg['img_name'] = str_replace('\\','/','/public/uploads/'.date('Ymd') .'/'. $filemsg);
				$img_name = Db::name('advert_carousel')
							->field('img_name')
							->where('id',$msg['id'])
							->find()['img_name'];
			}

			$res = Db::name('advert_carousel')
					->where('id',$msg['id'])
					->cache('advert_carousel')
					->update($msg);
			if($res !== false){
				if(!empty($img_name)){
					//  删除原图
					@unlink(ROOT_PATH . str_replace('/','\\',ltrim($img_name,'/')));
				}
				$this->run_log('修改轮播图操作。');
				$this->success('修改成功！');
			}else{
				$this->error('修改失败！');
			}

		}

		/**
		 * 轮播图删除动作
		 * @param  [type] $id [商品id]
		 * @return [type]     [是否彻底删除成功]
		 */
		public function action_del_carousel($id)
		{
			$img_name = Db::name('advert_carousel')
							->field('img_name')
							->where('id',$msg['id'])
							->find()['img_name'];
			$res = Db::name('advert_carousel')
					->where('id',$id)
					->cache('advert_carousel')
					->delete();			
			if($res){
				if(!empty($img_name)){
					//  删除原图
					@unlink(ROOT_PATH . str_replace('/','\\',ltrim($img_name,'/')));
				}
				$this->run_log('删除轮播图操作。');
				$this->success('删除成功！');
			}else{
				$this->error('删除失败！');
			}
		}

	
	}
