<?php
	/**
	* @Author: Hkshop
	* 店铺管理类
	* @Date:   2017-08-18 10:33:14
	* @Last Modified time: 2017-08-18 10:33:14
	*/

	namespace app\admin\controller;

	use app\admin\controller\Base;
	use app\admin\model\ExcelToArrary;
	use think\Validate;
	use think\Db;
	use think\Request;

	class Shop extends Base
	{
		/**
		 * 店铺展示
		 * @return [type] [description]
		 */
		public function shop_list()
		{
			$data = Db::name('shop')
						->paginate(20);
			return $this->fetch('shop_list',['data' => $data]);
		}

		/**
		 * 添加店铺操作
		 */
		public function add_shop()
		{
			return $this->fetch('add_shop');
		}

		/**
		 * 添加店铺动作
		 * @return [type] [添加店铺是否成功]
		 */
		public function action_add_shop()
		{
			// 接收數據
			$data = Request::instance()->post();
			
			// 判断數據不能為空
			$rule = [
				['shop_title','require','門店名不能為空'],
			];
			$msg = [
				'shop_title'  => $data['shop_title'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);
			// 插入数据
			$data['create_time'] = date('Y-m-d H:i:s',time());

			$res = Db::name('shop')
					->insert($data);

			if($res){
				$this->run_log('新增门店數據操作。'.$data['shop_title']);
				$this->success('门店添加成功！','shop/add_shop');
			}else{
				$this->error('门店添加失敗！');
			}	
			
		}

		
		/**
		 * 修改店铺信息操作
		 * @param  [type] $id [店铺id]
		 * @return [type]     [description]
		 */
		public function rev_shop($id)
		{
			$data = Db::name('shop')
					->where('id',$id)
					->find();
			return $this->fetch('rev_shop',[
					'data' => $data
				]);
		}

		/**
		 * 店铺修改动作
		 * @return [type] [是否修改成功]
		 */
		public function action_rev_shop()
		{
			$data = Request::instance()->post();

			// 判断數據不能為空
			$rule = [
				['shop_title','require','門店名不能為空'],
			];
			$msg = [
				'shop_title'  => $data['shop_title'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			$res = Db::name('shop')
					->where('id',$data['id'])
					->update($data);
			if($res !== false){
				$this->run_log('修改門店數據操作。'.$data['shop_title']);
				$this->success('修改成功！');
			}else{
				$this->error('修改失敗！');
			}

		}

		/**
		 * 店铺刪除动作
		 * @param  [type] $id [店铺ID]
		 * @return [type]     [description]
		 */
		public function action_del_shop($id)
		{
			$shop_title = Db::name('shop')
							->field('shop_title')
							->where('id',$id)
							->find()['shop_title'];

			$res = Db::name('shop')
					->where('id',$id)
					->delete();

			if($res !== false){
				$this->run_log('删除門店數據操作。'.$shop_title);
				$this->success('删除成功！');
			}else{
				$this->error('删除失敗！');
			}

		}
	}
