<?php
	/**
	* @Author: Hkshop
	* 商品管理类
	* @Date:   2016-1-2 15:38:14
	* @Last Modified time: 2016-1-2 16:20:06
	*/

	namespace app\admin\controller;

	use app\admin\controller\Base;
	use app\admin\model\ExcelToArrary;
	use think\Validate;
	use think\Db;
	use think\Request;

	class Goods extends Base
	{
		/**
		 * 商品展示
		 * @return [type] [description]
		 */
		public function index()
		{
			// 初始化數據
			$status = Request::instance()->get('status');
			$page = empty(Request::instance()->get('page')) ? '1' : Request::instance()->get('page');

			$title_where = '';
			$type_where = '';
			$status_where = '';

			// 筛选
			// if(!empty($title)){
			// 	$title_where = 'g.title like "%'.$title.'%"';
			// }
			// if(isset($type) && $type !== ''){
			// 	$type_where = 'g.type="'.$type.'"';
			// }
			// if(isset($status) && $status !== ''){
			// 	$status_where = 'g.status="'.$status.'"';
			// }

			$data = Db::name('goods')
					->where('is_delete=0')
					->where($title_where)
					->where($type_where)
					->where($status_where)
					->where('create_time','>',0)
					->order('sort','desc')
					->order('stock','desc')
					->paginate(20,false,[
						'query' => [
							'status' => $status,
							],
						]);

			return $this->fetch('index',['data' => $data,'status' => $status,'page' => $page]);
		}

		/**
		 * 添加商品操作
		 */
		public function add_goods()
		{
			$cates_data = self::cate_route('cates','cate');
			$areas_data = Db::name('goods_areas')
						->where('display',1)
						->select();
			$score_data = Db::name('goods_score')
							->select();
			$chateau_data = Db::name('goods_chateau')
								->select();
			return $this->fetch('add_goods',[
							'cates_data' 	=> $cates_data,
							'areas_data' 	=> $areas_data,
							'score_data' 	=> $score_data,
							'chateau_data' 	=> $chateau_data,
						]);
		}

		/**
		 * 添加商品动作
		 * @return [type] [添加商品是否成功]
		 */
		public function action_add_goods()
		{
			// 接收數據
			$msg = Request::instance()->post();
			$file = Request::instance()->file('image');
			$files = Request::instance()->file('images');
		
			// 检测數據
			$goods_data = $this->check_goods_data($msg);
	
			if(empty($file) && !isset($file)){
					$this->error('主圖不能為空！');
			}else{
				$filemsg = $this->upload($file);
				if(!$filemsg){
					$this->error($filemsg);
				}
			}

			if(!empty($files) && isset($files)){
				$filemsgs = $this->uploads($files);
				if(!$filemsgs){
					$this->error($filemsgs);
				}
			}
			
			$title_exists = Db::name('goods')
							->where('eng_title',$msg['eng_title'])
							->where('hk_title',$msg['hk_title'])
							->where('years',$msg['years'])
							->find();
			if($title_exists){
				$this->error('商品名已存在！');
			}
			// 合并數據
			$arr = [
				'create_time' => date('Y-m-d H:i:s',time()),
			];
			$goods_data = array_merge($goods_data,$arr);
			// 添加商品數據
			$res = Db::name('goods')
				->insertGetId($goods_data);
			if($res){
				Db::name('goods_images')
					->insert(['iname' => str_replace('\\','/','/public/uploads/'.date('Ymd') .'/'. $filemsg),'goods_id' => $res,'cover' => '0']);
				if($filemsgs){
					foreach ($filemsgs as $v) {
						$imgs[] = ['iname' => str_replace('\\','/','/public/uploads/'.date('Ymd') .'/'. $v),'goods_id' => $res];
					}
					Db::name('goods_images')
						->insertAll($imgs);
				}
				$this->run_log('新增商品數據操作。'.$msg['hk_title']);
				$this->success('商品添加成功！','goods/add_goods');
			}else{
				$this->error('商品添加失敗！');
			}	
			
		}

		/**
		 * 检测上传商品數據
		 * @param  [type] $data 		 [商品信息]
		 * @return [type]       		 [description]
		 */
		private function check_goods_data($data)
		{	
			
			if(!array_key_exists('goods_msg', $data)){
				$data['goods_msg'] = '';
			}
			$cate_id = implode(',',$data['cate_id']);
			// 判断數據不能為空
			$rule = [
				['hk_title','require','商品中文名不能為空'],
				['eng_title','require','商品英文名不能為空'],
			    ['years','require','年份不能為空'],
			    ['marketprice','require','零售價不能為空'],
			    ['storeprice','require','市場價不能為空'],
			    ['weight','require','商品重量不能為空'],
			    ['content','require','商品描述不能為空'],
			    ['stock','require','庫存不能為空'],
			];
			$msg = [
				'hk_title'  => $data['hk_title'],
				'eng_title'  => $data['eng_title'],
			    'years'  => $data['years'],
			    'marketprice'  => $data['marketprice'],
			    'storeprice'  => $data['storeprice'],
			    'weight'  => $data['weight'],
			    'content'  => $data['goods_msg'],
			    'stock' => $data['stock'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			if(!$result){
			    $this->error($validate->getError());
			}
		
			// 添加數據
			$arr =[
				'status'  			=> 	$data['status'],
				'area_id' 			=> 	$data['area_id'],
				'cate_id'  			=> 	$cate_id,
			    'record_goosnum'  	=> 	$data['record_goosnum'],
			    'last_time'			=> 	date('Y-m-d H:i:s',time()),
			    'sort'				=> 	$data['sort'],
			    'is_home'			=> 	$data['is_home'],
			    'score_id'			=> 	empty($data['score_id']) ? '' : implode(',',$data['score_id']),
			    'abstract'			=> 	$data['abstract'],
			    'winemaker_notes'	=> 	$data['winemaker_notes'],
			    'chateau_id'		=> 	$data['chateau_id'],
			];

			//合并数组 
			$new_data = array_merge($msg,$arr);

			return $new_data;
		}

		/**
		 * 修改商品信息操作
		 * @param  [type] $id [商品id]
		 * @return [type]     [description]
		 */
		public function rev_goods($id)
		{	
			$status = Request::instance()->get('status');
			$page = Request::instance()->get('page');
			$cates_data = self::cate_route('cates','cate');
			$areas_data = Db::name('goods_areas')
						->where('display',1)
						->select();
			$goods_data = Db::name('goods')
						->where('id',$id)
						->find();
			$goods_score = explode(',',$goods_data['score_id']);
			$cates = explode(',',$goods_data['cate_id']);
			$score_data = Db::name('goods_score')
							->select();
			$chateau_data = Db::name('goods_chateau')
							->select();		
			return $this->fetch('rev_goods',[
					'goods_id' 		=> $id,
					'cates_data' 	=> $cates_data,
					'areas_data' 	=> $areas_data,
					'goods'			=> $goods_data,
					'status' 		=> $status,
					'page' 			=> $page,
					'cates' 		=> $cates,
					'score_data' 	=> $score_data,
					'goods_score' 	=> $goods_score,
					'chateau_data' 	=> $chateau_data,
				]);
		}

		/**
		 * 商品修改动作
		 * @return [type] [是否修改成功]
		 */
		public function action_rev_goods()
		{
			$msg = Request::instance()->post();
			$goods_id = Request::instance()->post('id');

			$boolean = Db::name('goods')
						->where('id','<>',$goods_id)
						->where('eng_title',$msg['eng_title'])
						->where('hk_title',$msg['hk_title'])
						->where('years',$msg['years'])
						->find();
		
			if($boolean){
				$this->error('该商品已存在！');
			}

			// 检测數據
			$goods_data = $this->check_goods_data($msg);

			$res = Db::name('goods')
					->where('id',$goods_id)
					->update($goods_data);
			if($res !== false){
				$this->run_log('修改商品數據操作。'.$msg['hk_title']);
				$this->success('修改成功！');
			}else{
				$this->error('修改失敗！');
			}

		}

		/**
		 * 商品彻底删除动作
		 * @param  [type] $id [商品id]
		 * @return [type]     [是否彻底删除成功]
		 */
		public function action_del_goods($id)
		{
			$msg = Db::name('goods')
					->field('title')
					->where('id',$id)
					->find();
			$res = Db::name('goods')
					->where('id',$id)
					->delete();			
			if($res){
				$boolean = Db::name('goods_images')
							->where('goods_id',$id)
							->delete();
				if($boolean){
					$this->run_log('删除商品數據操作。'.$msg['title']);
					$this->success('删除成功！');
				}else{
					$this->error('删除失敗！');
				}
			}
		}

		/**
		 * 商品恢復操作
		 * @param  [type] $id     [商品id]
		 * @return [type]         [是否操作成功]
		 */
		public function action_rev_del($id)
		{
			$res = Db::name('goods')
					->where('id',$id)
					->update(['is_delete' => 0]);
			if($res !== false){
				$title = Db::name('goods')
							->where('id',$id)
							->find()['title'];
				$this->run_log('恢復商品數據操作。'.$title);
				$this->success('恢復成功！','goods/goods_recycle');
			}else{
				$this->error('操作失敗！');
			}
		}

		/**
		 * 商品回收站操作
		 * @return [type] [description]
		 */
		public function goods_recycle()
		{
			$data = Db::name('goods')
					->alias('g')
					->join('__GOODS_IMAGES__ i','g.id = i.goods_id')
					->field('g.id,g.title,g.type,g.status,g.is_hot,g.is_new,g.is_free,g.marketprice,g.stock,g.sale_number,i.iname')
					->where('g.is_delete=1 AND i.cover=0')
					->paginate(15);

			return $this->fetch('goods_recycle',['data' => $data]);
		}



		/**
		 * 商品圖片修改操作
		 * @param  [type] $id [商品id]
		 * @return [type]     [是否修改成功]
		 */
		public function rev_images($id)
		{
			$title = Request::instance()->get('title');
			$type = Request::instance()->get('type');
			$status = Request::instance()->get('status');
			$page = Request::instance()->get('page');

			$images = Db::name('goods_images')
						->where('goods_id',$id)
						->select();
			$goods = Db::name('goods')
						->where('id',$id)
						->find();

			return $this->fetch('rev_images',['data' => $images,'goods_id' => $id,'goods' => $goods,'title' => $title,'type' => $type,'status' => $status,'page' => $page]);
		}

		/**
		 * 商品圖片删除动作
		 * @param  [type] $id [商品圖片id]
		 * @return [type]     [返回是否删除成功]
		 */
		public function action_del_img($id)
		{
			$res = Db::name('goods_images')
					->field('goods_id,cover,iname')
					->where('id',$id)
					->find();
			
			if($res['cover'] == 0){
				$this->error('封面無法删除！');
			}
			// if($res['iname']){
			// 	unlink(ROOT_PATH . str_replace('/','\\',ltrim($res['iname'],'/')));
			// }
			$boolean = Db::name('goods_images')
						->where('id',$id)
						->delete();
			if($boolean){
				$msg = Db::name('goods')
							->field('hk_title')
							->where('id',$res['goods_id'])
							->find();
				$this->run_log('删除商品圖片操作。'.$msg['hk_title']);
				$this->success('删除成功！');
			}else{
				$this->error('删除失敗！');
			}
		}

		/**
		 * 添加圖片动作
		 * @return [type] [是否添加成功]
		 */
		public function action_add_imgs()
		{
			$files = Request::instance()->file('images');
			$goods_id = Request::instance()->post('goods_id');

			$data = [];
			if(empty($files) && !isset($files)){
				return $this->error('请选择圖片！');
			}
			$filemsg = $this->uploads($files);

			foreach ($filemsg as $v) {
				$data[] = ['iname' => str_replace('\\','/','/public/uploads/'.date('Ymd').'/'.$v),'goods_id' => $goods_id];
			}

			$res = Db::name('goods_images')
					->insertAll($data);
			if($res){
				$msg = Db::name('goods')
							->field('hk_title')
							->where('id',$goods_id)
							->find();
				$this->run_log('新增商品圖片操作。'.$msg['hk_title']);
				$this->success('增加圖片成功！');
			}else{
				$this->error('增加圖片失敗！');
			}
		}

		/**
		 * 修改圖片封面动作
		 * @param  [type] $id       [商品圖片id]
		 * @param  [type] $goods_id [商品id]
		 * @return [type]           [設置是否成功]
		 */
		public function action_rev_cover($id,$goods_id)
		{
			$res = Db::name('goods_images')
					->where('goods_id',$goods_id)
					->where('cover','0')
					->update(['cover' => '1']);
			if($res !== false){
				$boolean = Db::name('goods_images')
							->where('id',$id)
							->update(['cover' => '0']);
				if($boolean !== false){
					$msg = Db::name('goods')
							->field('hk_title')
							->where('id',$goods_id)
							->find();
					$this->run_log('修改商品圖片封面操作。'.$msg['hk_title']);
					$this->success('修改成功！');
				}else{
					$this->error('修改失敗！');
				}
			}
		}

		/**
		 * ajax获取产区
		 * @return [type] [description]
		 */
		public function ajax_get_origin()
		{
			$pid = Request::instance()->post('pid');

			$data = Db::name('cates')
					->field('id,cname')
					->where('pid',$pid)
					->where('display',0)
					->select();
			echo json_encode($data);
		}

		/**
		 * 商品區域列表
		 * @return [type] [description]
		 */
		public function area_list()
		{
			$data = Db::name('goods_areas')
					->paginate(20);
			return $this->fetch('area_list',['data' => $data]);
		}

		/**
		 * 添加商品區域操作
		 * @return [type] [description]
		 */
		public function add_area()
		{
			return $this->fetch('add_area');
		}
		
		/**
		 * 添加商品區域动作
		 * @return [type] [description]
		 */
		public function action_add_area()
		{
			$message = Request::instance()->post();
			// 數據验证
			$rule = [
			    [
			    	'area_name',
			    	'require|chsAlpha|unique:goods_areas,area_name',
			    	'區域名不能為空|請輸入正確的區域名|區域名已存在'
			    ],
			    [
				    'display',
				    'require',
				    '狀態不能為空'
			    ],
			];
			$data = [
			    'area_name'  	=> $message['area_name'],
			    'display'   	=> $message['display'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($data);

			if(!$result){
				$this>error($validate->getError());
			}

			$res = Db::name('goods_areas')
					->insert($data);
			if($res){
				$this->run_log('添加商品區域數據操作。'.$message['area_name']);
				$this->success('添加成功');
			}else{
				$this->error('添加失敗');
			}
		}

		/**
		 * 修改商品區域操作
		 * @param  [type] $id [商品區域ID]
		 * @return [type]     [description]
		 */
		public function rev_area($id)
		{
			$data = Db::name('goods_areas')
					->where('id',$id)
					->find();
			return $this->fetch('rev_area',['data' => $data]);
		}
		
		/**
		 * 修改商品區域动作
		 * @return [type] [description]
		 */
		public function action_rev_area()
		{
			$message = Request::instance()->post();
			// 數據验证
			$rule = [
				[
			    	'id',
			    	'require',
			    	'區域ID不能為空'
			    ],
			    [
			    	'area_name',
			    	'require|chsAlpha',
			    	'區域名不能為空|請輸入正確的區域名'
			    ],
			    [
				    'display',
				    'require',
				    '狀態不能為空'
			    ],
			];
			$data = [
			    'id'  		=> $message['id'],
			    'area_name' => $message['area_name'],
			    'display'   => $message['display'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($data);

			if(!$result){
				$this>error($validate->getError());
			}
			$area_name = Db::name('goods_areas')
							->where('id','<>',$message['id'])
							->where('area_name',$message['area_name'])
							->find();
			if(!empty($area_name)){
				$this->error('區域名已存在');
			}
			$res = Db::name('goods_areas')
					->where('id',$message['id'])
					->update($data);
			if($res !== false){
				$this->run_log('修改商品區域數據操作。'.$message['area_name']);
				$this->success('修改成功','admin/goods/area_list');
			}else{
				$this->error('修改失敗');
			}
		}

		/**
		 * 删除商品區域动作
		 * @param  [type] $id [商品區域ID]
		 * @return [type] [description]
		 */
		public function action_del_area($id)
		{
			$area_name = Db::name('goods')
							->where('area_id',$id)
							->find();
			if(!empty($area_name)){
				$this->error('该區域下有商品，無法删除！');
			}
			$res = Db::name('goods_areas')
					->where('id',$id)
					->delete();
			if($res !== false){
				$this->run_log('删除商品區域數據操作。'.$message['area_name']);
				$this->success('删除成功');
			}else{
				$this->error('删除失敗');
			}
		}
	}
