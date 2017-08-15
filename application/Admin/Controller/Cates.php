<?php
	/**
	* @Author: Hkshop
	* 分类管理类
	* @Date:   2016-12-31 15:38:14
	* @Last Modified time: 2016-12-31 16:20:06
	*/

	namespace app\admin\controller;

	use app\admin\controller\Base;
	// use think\Validate;
	use think\Db;
	use think\Request;
	use think\Session;
	
	class Cates extends Base
	{
		public $result = [];
		public $n = 0;

		/**
		 * 分类列表列
		 * @return [type]      [分类数据]
		 */
		public function index()
		{
			$data = self::cate_route_str('cates','cate');
			if(empty(Session::get('cate'))){
				$root = [];
				$r = 0;
				foreach ($data as $v) {
					if($v['pid'] == 0){
						$root[$r] = $v;
						$r++;
					}
				}
				foreach ($root as $k => $v) {
					$this->result[$this->n] = $v;
					$this->n += 1;
					$this->sort_cate($v);
				}
				$result = $this->result;
				Session::set('cate',$this->result);
			}else{
				$result = Session::get('cate');
			}

			return $this->fetch('index',['data' => $result]);
		}

		public function sort_cate($root)
		{
			$data = self::cate_route_str('cates','cate');
			foreach ($data as $k => $v) {
				if($v['pid'] == $root['id']){
					$this->result[$this->n] = $v;
					$this->n += 1;
					$this->sort_cate($v);
				}
			}
		}

		/**
		 * 删除分类动作
		 * @return [type]     [是否删除成功]
		 */
		public function action_del_cate()
		{
			$id = Request::instance()->post('id');

			$result = Db::name('cates','cate')
					->where('pid',$id)
					->find();
			if(isset($result) && !empty($result)){
				return (['code' => 400,'message' => '該分類下還有子分類，無法刪除！']);
			}
			$goods = Db::name('goods')
					->where('cate_id',$id)
					->find();
			if(isset($goods) && !empty($goods)){
				return (['code' => 400,'message' => '該分類下還有商品，無法刪除！']);
			}
			$cname = Db::name('cates')
					->field('cname')
					->where('id',$id)
					->find()['cname'];
					
			$res = Db::name('cates')
					->where('id',$id)
					->delete();
			if($res){
				Session::delete('cate');
				$this->run_log('删除商品分類數據操作。'.$cname);
				return (['code' => 200,'message' => '删除成功！']);
			}else{
				return (['code' => 400,'message' => '删除失败！']);
			}
		}

		/**
		 * 分类修改操作
		 * @return [type]     [description]
		 */
		public function rev_cate()
		{
			$id = Request::instance()->get('id');
			$result = Db::name('cates')
						->field('id,cname,display,sort')
						->where('id',$id)
						->find();
			return json(['code' => 200,'message' => '成功','data' => $result]);
		}

		/**
		 * 分类修改动作
		 * @return [type] [description]
		 */
		public function action_rev_cate()
		{
			$data  = Request::instance()->post();

			if(!empty($data['cname']) && isset($data['cname'])){
				$exis = Db::name('cates')
						->where('cname',$data['cname'])
						->where('id','<>',$data['id'])
						->find();
				if($exis){
					return (['code' => 400,'message' => '該分類名已存在！']);
				}
			}else{
				return (['code' => 400,'message' => '請輸入分類名！']);
			}

			// 执行修改
			$res = Db::name('cates')
					->where('id',$data['id'])
					->update($data);
			if($res !== false){
				$pid = Db::name('cates')
						->field('pid,cname')
						->where('id',$data['id'])
						->find();
				Session::delete('cate');
				$this->run_log('修改商品分類數據操作。'.$pid['cname']);
				return (['code' => 200,'message' => '修改成功！']);
			}else{
				return (['code' => 400,'message' => '修改失败！']);
			}
		}

		/**
		 * 添加分类操作
		 */
		public function add_cate()
		{
			$data = self::cate_route_str('cates','cate');

			return $this->fetch('add_cate',['data' => $data]);
		}

		/**
		 * 添加分类动作
		 * @return [type] [description]
		 */
		public function action_add_cate()
		{
			$data = Request::instance()->post();

			if(!isset($data['display'])){
				$this->error('是否顯示不能為空！');
			}

			if(!empty($data['cname']) && isset($data['cname'])){
				$exis = Db::name('cates')
						->where('cname',$data['cname'])
						->find();
				if($exis){
					$this->error('分類名稱已存在！');
				}
			}else{
				$this->error('分類名稱不能为空！');
			}

			if($data['pid'] == 0){
				$data['path'] = $data['pid'].',';
			}else{
				$path = Db::name('cates') 
						->field('path')
						->where('id',$data['pid'])
						->find();

				$data['path'] = $path['path'].$data['pid'].',';
			}

			// 执行添加
			$res = Db::name('cates')
					->insertGetId($data);
			if($res){
				Session::delete('cate');
				$this->success('添加成功！');
			}else{
				$this->error('添加失敗！');
			}
		}

		/**
		 * 添加子分类动作
		 * @return [type] [description]
		 */
		public function action_add_child_cate()
		{
			$data = Request::instance()->post();

			if(!isset($data['display'])){
				return json(['code' => 400,'message' => '是否顯示不能為空！']);
			}

			if(!empty($data['cname']) && isset($data['cname'])){
				$exis = Db::name('cates')
						->where('cname',$data['cname'])
						->find();
				if($exis){
					return json(['code' => 400,'message' => '分類名稱已存在！']);
				}
			}else{
				return json(['code' => 400,'message' => '分類名稱不能为空！']);
			}

			if($data['pid'] == 0){
				$data['path'] = $data['pid'].',';
			}else{
				$path = Db::name('cates') 
						->field('path')
						->where('id',$data['pid'])
						->find();

				$data['path'] = $path['path'].$data['pid'].',';
			}

			// 执行添加
			$res = Db::name('cates')
					->insertGetId($data);
			if($res){
				$data['id'] = $res;
				Session::delete('cate');
				return json(['code' => 200,'message' => '添加成功！','data' => $data]);
			}else{
				return json(['code' => 400,'message' => '添加失敗！']);
			}
		}
	}
