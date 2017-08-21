<?php
	/**
	* @Author: Hkshop
	* 支付管理类
	* @Date:   2017-08-18 10:33:14
	* @Last Modified time: 2017-08-18 10:33:14
	*/

	namespace app\admin\controller;

	use app\admin\controller\Base;
	use think\Validate;
	use think\Db;
	use think\Request;

	class Pay extends Base
	{
		/**
		 * 支付展示
		 * @return [type] [description]
		 */
		public function index()
		{
			$data = Db::name('pay')
						->paginate(20);
			return $this->fetch('index',['data' => $data]);
		}

		/**
		 * 添加支付操作
		 */
		public function add_pay()
		{
			return $this->fetch('add_pay');
		}

		/**
		 * 添加支付动作
		 * @return [type] [添加支付是否成功]
		 */
		public function action_add_pay()
		{
			// 接收數據
			$data = Request::instance()->post();
			
			// 判断數據不能為空
			$rule = [
				['title','require','支付方式名不能為空'],
			];
			$msg = [
				'title'  => $data['title'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);
			// 插入数据

			$res = Db::name('pay')
					->insert($data);

			if($res){
				$this->run_log('新增支付方式數據操作。'.$data['title']);
				$this->success('支付方式添加成功！','pay/add_pay');
			}else{
				$this->error('支付方式添加失敗！');
			}	
			
		}

		
		/**
		 * 修改支付信息操作
		 * @param  [type] $id [支付id]
		 * @return [type]     [description]
		 */
		public function rev_pay($id)
		{
			$data = Db::name('pay')
					->where('id',$id)
					->find();
			return $this->fetch('rev_pay',[
					'data' => $data
				]);
		}

		/**
		 * 支付修改动作
		 * @return [type] [是否修改成功]
		 */
		public function action_rev_pay()
		{
			$data = Request::instance()->post();

			// 判断數據不能為空
			$rule = [
				['title','require','支付方式名不能為空'],
			];
			$msg = [
				'title'  => $data['title'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			$res = Db::name('pay')
					->where('id',$data['id'])
					->update($data);
			if($res !== false){
				$this->run_log('修改支付方式數據操作。'.$data['title']);
				$this->success('修改成功！');
			}else{
				$this->error('修改失敗！');
			}

		}

		/**
		 * 支付方式刪除动作
		 * @param  [type] $id [支付方式ID]
		 * @return [type]     [description]
		 */
		public function action_del_pay($id)
		{
			$title = Db::name('pay')
							->field('title')
							->where('id',$id)
							->find()['title'];

			$res = Db::name('pay')
					->where('id',$id)
					->delete();

			if($res !== false){
				$this->run_log('删除支付方式數據操作。'.$title);
				$this->success('删除成功！');
			}else{
				$this->error('删除失敗！');
			}

		}
	}
