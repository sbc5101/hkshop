<?php
	/**
	* @Author: Yoshop
	* 后台商品酒莊管理类
	* @Date:   2017-08-15 14:55:14
	* @Last Modified time: 2017-08-15 16:20:06
	*/

	namespace app\admin\controller;

	use app\admin\controller\Base;
	use think\Db;
	use think\Request;
	use think\Validate;

	class Chateau extends Base
	{
		/**
		 * 商品酒莊列表
		 * @return [type] [description]
		 */
		public function chateau_index()
		{
			$data = Db::name('goods_chateau')
					->paginate('20');

			return $this->fetch('chateau_index',['data' => $data]);
		}

		/**
		 * 添加酒莊
		 * @return [type] [description]
		 */
		public function add_chateau()
		{
			return $this->fetch('add_chateau');
		}

		/**
		 * 添加酒莊动作
		 * @return [type] [description]
		 */
		public function action_add_chateau()
		{
			$data = Request::instance()->post();
			// $file = Request::instance()->file('c_img');

			// 验证数据
			$rule = [
				['c_title','require','酒莊名称不能為空'],
				['c_content','require','酒莊內容不能為空'],
				// ['file','require','酒莊圖片不能為空'],
			];
			$msg = [
				'c_title'  	 => $data['c_title'],
				'c_content'  => $data['c_content'],
				// 'file'  	 => $file,
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			if(!$result){
			    $this->error($validate->getError());
			}

			// // 上传圖片
			// $filemsg = $this->upload($file);
			// if(!$filemsg){
			// 	$this->error($filemsg);
			// }
			// $data['c_img'] = str_replace('\\','/','/public/uploads/'.date('Ymd') .'/'. $filemsg);

			// 插入数据
			$res = Db::name('goods_chateau')
					->insert($data);

			if($res){
				$this->run_log('添加酒莊操作。'.$data['c_title']);
				$this->success('添加成功！');
			}else{
				$this->error('添加失敗！');
			}
			
		}

		/**
		 * 修改酒莊信息
		 * @param  [type] $id [酒莊ID]
		 * @return [type]     [description]
		 */
		public function rev_chateau($id)
		{
			$data = Db::name('goods_chateau')
					->where('id',$id)
					->find();

			return $this->fetch('rev_chateau',['data' => $data,'id' => $id]);
		}


		/**
		 * 修改酒莊动作
		 * @return [type] [description]
		 */
		public function action_rev_chateau()
		{
			$data = Request::instance()->post();
			$id = Request::instance()->post('id');
			// $file = Request::instance()->file('c_img');
			
			// 验证数据
			$rule = [
				['c_title','require','酒莊名称不能為空'],
				['c_content','require','酒莊內容不能為空'],
			];
			$msg = [
				'c_title'  	 => $data['c_title'],
				'c_content'  => $data['c_content'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			if(!$result){
			    $this->error($validate->getError());
			}

			// 上传圖片
			// if(!empty($file)){
			// 	$filemsg = $this->upload($file);
			// 	if(!$filemsg){
			// 		$this->error($filemsg);
			// 	}
			// 	$data['c_img'] = str_replace('\\','/','/public/uploads/'.date('Ymd') .'/'. $filemsg);
			// }

			// 修改数据
			$res = Db::name('goods_chateau')
					->where('id',$id)
					->update($data);

			if($res !== false){
				$this->run_log('修改酒莊操作。'.$data['c_title']);
				$this->success('修改成功！');
			}else{
				$this->error('修改失敗！');
			}
		}

		/**
		 * 删除酒莊信息动作
		 * @param  [type] $id [酒莊ID]
		 * @return [type]     [description]
		 */
		public function action_chateau_del($id)
		{
			$data = Db::name('goods_chateau')
					->field('c_title')
					->where('id',$id)
					->find();
			$res = Db::name('goods_chateau')
					->where('id',$id)
					->delete();
			if($res !== false){
				$this->run_log('删除酒莊操作。'.$data['c_title']);
				$this->success('删除成功！');
			}else{
				$this->error('删除失敗！');
			}
		}

	}
 