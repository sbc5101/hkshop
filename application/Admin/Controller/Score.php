<?php
	/**
	* @Author: Yoshop
	* 后台商品评分管理类
	* @Date:   2017-07-21 14:55:14
	* @Last Modified time: 2017-07-21 16:20:06
	*/

	namespace app\admin\controller;

	use app\admin\controller\Base;
	use think\Db;
	use think\Request;
	use think\Validate;

	class score extends Base
	{
		/**
		 * 评分列表
		 * @return [type] [description]
		 */
		public function score_list()
		{
			$data = Db::name('goods_score')
					->paginate(20);
			return $this->fetch('score_list',['data' => $data]);
		}

		/**
		 * ajax获取评分信息
		 * @return [type] [description]
		 */
		public function ajax_get_score()
		{
			$data = Request::instance()->post();
			if(empty($data['id'])){
				return json(['code' => 400,'message' => 'ID參數不能為空']);
			}

			$score = Db::name('goods_score')
					->where('id',$data['id'])
					->find();
			if(!empty($score)){
				return json(['code' => 200,'message' => '成功','data' => $score]);
			}else{
				return json(['code' => 400,'message' => '失敗']);
			}
		}

		/**
		 * 添加评分动作
		 * @return [type] [description]
		 */
		public function action_add_score()
		{
			$data = Request::instance()->post();
			
			// 判断数据不能为空
			$rule = [
				['score_num','require','評分分數不能為空'],
				['mechanism','require','評論機構不能為空'],
				['score_name','require','評論人姓名不能為空'],
			];
			$msg = [
				'score_num'  => $data['score_num'],
				'mechanism'  => $data['mechanism'],
				'score_name'  => $data['score_name'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			if(!$result){
			    $this->error($validate->getError());
			}

		    $res = Db::name('goods_score')
		    		->insert($data);
		    if($res){
		    	$this->success('添加成功！');
		    }else{
		    	$this->error('添加失敗！');
		    }
		}

		/**
		 * 修改评分动作
		 * @return [type] [description]
		 */
		public function action_rev_score()
			{
				$data = Request::instance()->post();
				// 判断数据不能为空
				$rule = [
					['score_num','require','評分分數不能為空'],
					['mechanism','require','評論機構不能為空'],
					['id','require','ID不能为空'],
					['score_name','require','評論人姓名不能為空'],
				];
				$msg = [
					'score_num'  => $data['score_num'],
					'mechanism'  => $data['mechanism'],
					'id'  		 => $data['id'],
					'score_name' => $data['score_name'],
				];

				$validate = new Validate($rule);
				$result   = $validate->check($msg);

				if(!$result){
				    $this->error($validate->getError());
				}
				
			    $res = Db::name('goods_score')
			    		->where('id',$data['id'])
			    		->update($data);
			    if($res !== false){
			    	$this->success('修改成功！');
			    }else{
			    	$this->error('修改失敗！');
			    }
		}

		/**
		 * 删除评分动作
		 * @param  [type] $id [评分ID]
		 * @return [type]     [description]
		 */
		public function action_del_score($id)
		{
			$res = Db::name('goods_score')
					->where('id',$id)
					->delete();
			if($res !== false){
				$this->success('删除成功！');
			}else{
				$this->error('删除失敗！');
			}
		}
	}
 