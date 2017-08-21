<?php
	/**
	* @Author: Hkshop
	* 快递管理类
	* @Date:   2017-08-18 10:33:14
	* @Last Modified time: 2017-08-18 10:33:14
	*/

	namespace app\admin\controller;

	use app\admin\controller\Base;
	use think\Validate;
	use think\Db;
	use think\Request;

	class Express extends Base
	{
		/**
		 * 快遞展示
		 * @return [type] [description]
		 */
		public function index()
		{
			$data = Db::name('express')
						->paginate(20);
			return $this->fetch('index',['data' => $data]);
		}

		/**
		 * 添加快遞操作
		 */
		public function add_express()
		{
			return $this->fetch('add_express');
		}

		/**
		 * 添加快遞动作
		 * @return [type] [添加快遞是否成功]
		 */
		public function action_add_express()
		{
			// 接收數據
			$data = Request::instance()->post();
			
			// 判断數據不能為空
			$rule = [
				['e_title','require','快遞名稱不能為空'],
			];
			$msg = [
				'e_title'  => $data['e_title'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);
			// 插入数据

			$res = Db::name('express')
					->insert($data);

			if($res){
				$this->run_log('新增快遞數據操作。'.$data['e_title']);
				$this->success('快遞添加成功！','express/add_express');
			}else{
				$this->error('快遞添加失敗！');
			}	
			
		}

		
		/**
		 * 修改快遞信息操作
		 * @param  [type] $id [快遞id]
		 * @return [type]     [description]
		 */
		public function rev_express($id)
		{
			$data = Db::name('express')
					->where('id',$id)
					->find();
			return $this->fetch('rev_express',[
					'data' => $data
				]);
		}

		/**
		 * 快遞修改动作
		 * @return [type] [是否修改成功]
		 */
		public function action_rev_express()
		{
			$data = Request::instance()->post();

			// 判断數據不能為空
			$rule = [
				['e_title','require','快遞名不能為空'],
			];
			$msg = [
				'e_title'  => $data['e_title'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			$res = Db::name('express')
					->where('id',$data['id'])
					->update($data);
			if($res !== false){
				$this->run_log('修改快遞數據操作。'.$data['e_title']);
				$this->success('修改成功！');
			}else{
				$this->error('修改失敗！');
			}

		}

		/**
		 * 快遞刪除动作
		 * @param  [type] $id [快遞ID]
		 * @return [type]     [description]
		 */
		public function action_del_express($id)
		{
			$e_title = Db::name('express')
							->field('e_title')
							->where('id',$id)
							->find()['e_title'];

			$res = Db::name('express')
					->where('id',$id)
					->delete();

			if($res !== false){
				$this->run_log('删除快遞數據操作。'.$e_title);
				$this->success('删除成功！');
			}else{
				$this->error('删除失敗！');
			}

		}
	}
