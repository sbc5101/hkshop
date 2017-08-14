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
			// 初始化数据
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
			return $this->fetch('add_goods',[
							'cates_data' 	=> $cates_data,
							'areas_data' 	=> $areas_data,
						]);
		}

		/**
		 * 添加商品动作
		 * @return [type] [添加商品是否成功]
		 */
		public function action_add_goods()
		{
			// 接收数据
			$msg = Request::instance()->post();
			$file = Request::instance()->file('image');
			$files = Request::instance()->file('images');
		
			// 检测数据
			$goods_data = $this->check_goods_data($msg);
	
			if(empty($file) && !isset($file)){
					$this->error('主图不能为空！');
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
			// 合并数据
			$arr = [
				'create_time' => date('Y-m-d H:i:s',time()),
			];
			$goods_data = array_merge($goods_data,$arr);
			// 添加商品数据
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
				$this->run_log('新增商品数据操作。'.$msg['hk_title']);
				$this->success('商品添加成功！','goods/add_goods');
			}else{
				$this->error('商品添加失败！');
			}	
			
		}

		/**
		 * 检测上传商品数据
		 * @param  [type] $data 		 [商品信息]
		 * @return [type]       		 [description]
		 */
		private function check_goods_data($data)
		{	
			
			if(!array_key_exists('goods_msg', $data)){
				$data['goods_msg'] = '';
			}
			$cate_id = implode(',',$data['cate_id']);
			// 判断数据不能为空
			$rule = [
				['hk_title','require','商品中文名不能为空'],
				['eng_title','require','商品英文名不能为空'],
			    ['years','require','年份不能为空'],
			    ['marketprice','require','零售价不能为空'],
			    ['storeprice','require','市场价不能为空'],
			    ['weight','require','商品重量不能为空'],
			    ['content','require','商品描述不能为空'],
			    ['stock','require','库存不能为空'],
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

			// 添加数据
			$arr =[
				'status'  			=> 	$data['status'],
				'area_id' 			=> 	$data['area_id'],
				'cate_id'  			=> 	$cate_id,
			    'record_goosnum'  	=> 	$data['record_goosnum'],
			    'last_time'			=> 	date('Y-m-d H:i:s',time()),
			    'sort'				=> 	$data['sort'],
			    'is_home'			=> 	$data['is_home'],
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
			$cates = explode(',',$goods_data['cate_id']);

			return $this->fetch('rev_goods',[
					'goods_id' 		=> $id,
					'cates_data' 	=> $cates_data,
					'areas_data' 	=> $areas_data,
					'goods'			=> $goods_data,
					'status' 		=> $status,
					'page' 			=> $page,
					'cates' 		=> $cates,
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

			// 检测数据
			$goods_data = $this->check_goods_data($msg);

			$res = Db::name('goods')
					->where('id',$goods_id)
					->update($goods_data);
			if($res !== false){
				$this->run_log('修改商品数据操作。'.$msg['hk_title']);
				$this->success('修改成功！');
			}else{
				$this->error('修改失败！');
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
					$this->run_log('删除商品数据操作。'.$msg['title']);
					$this->success('删除成功！');
				}else{
					$this->error('删除失败！');
				}
			}
		}

		/**
		 * 商品恢复操作
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
				$this->run_log('恢复商品数据操作。'.$title);
				$this->success('恢复成功！','goods/goods_recycle');
			}else{
				$this->error('操作失败！');
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
		 * 商品图片修改操作
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
		 * 商品图片删除动作
		 * @param  [type] $id [商品图片id]
		 * @return [type]     [返回是否删除成功]
		 */
		public function action_del_img($id)
		{
			$res = Db::name('goods_images')
					->field('goods_id,cover,iname')
					->where('id',$id)
					->find();
			
			if($res['cover'] == 0){
				$this->error('封面无法删除！');
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
				$this->run_log('删除商品图片操作。'.$msg['hk_title']);
				$this->success('删除成功！');
			}else{
				$this->error('删除失败！');
			}
		}

		/**
		 * 添加图片动作
		 * @return [type] [是否添加成功]
		 */
		public function action_add_imgs()
		{
			$files = Request::instance()->file('images');
			$goods_id = Request::instance()->post('goods_id');

			$data = [];
			if(empty($files) && !isset($files)){
				return $this->error('请选择图片！');
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
				$this->run_log('新增商品图片操作。'.$msg['hk_title']);
				$this->success('增加图片成功！');
			}else{
				$this->error('增加图片失败！');
			}
		}

		/**
		 * 修改图片封面动作
		 * @param  [type] $id       [商品图片id]
		 * @param  [type] $goods_id [商品id]
		 * @return [type]           [设置是否成功]
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
					$this->run_log('修改商品图片封面操作。'.$msg['hk_title']);
					$this->success('修改成功！');
				}else{
					$this->error('修改失败！');
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
		 * 商品区域列表
		 * @return [type] [description]
		 */
		public function area_list()
		{
			$data = Db::name('goods_areas')
					->paginate(20);
			return $this->fetch('area_list',['data' => $data]);
		}

		/**
		 * 添加商品区域操作
		 * @return [type] [description]
		 */
		public function add_area()
		{
			return $this->fetch('add_area');
		}
		
		/**
		 * 添加商品区域动作
		 * @return [type] [description]
		 */
		public function action_add_area()
		{
			$message = Request::instance()->post();
			// 数据验证
			$rule = [
			    [
			    	'area_name',
			    	'require|chsAlpha|unique:goods_areas,area_name',
			    	'区域名不能为空|请输入正确的区域名|区域名已存在'
			    ],
			    [
				    'display',
				    'require',
				    '状态不能为空'
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
				$this->run_log('添加商品区域数据操作。'.$message['area_name']);
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}

		/**
		 * 修改商品区域操作
		 * @param  [type] $id [商品区域ID]
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
		 * 修改商品区域动作
		 * @return [type] [description]
		 */
		public function action_rev_area()
		{
			$message = Request::instance()->post();
			// 数据验证
			$rule = [
				[
			    	'id',
			    	'require',
			    	'区域ID不能为空'
			    ],
			    [
			    	'area_name',
			    	'require|chsAlpha',
			    	'区域名不能为空|请输入正确的区域名'
			    ],
			    [
				    'display',
				    'require',
				    '状态不能为空'
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
				$this->error('区域名已存在');
			}
			$res = Db::name('goods_areas')
					->where('id',$message['id'])
					->update($data);
			if($res !== false){
				$this->run_log('修改商品区域数据操作。'.$message['area_name']);
				$this->success('修改成功','admin/goods/area_list');
			}else{
				$this->error('修改失败');
			}
		}

		/**
		 * 删除商品区域动作
		 * @param  [type] $id [商品区域ID]
		 * @return [type] [description]
		 */
		public function action_del_area($id)
		{
			$area_name = Db::name('goods')
							->where('area_id',$id)
							->find();
			if(!empty($area_name)){
				$this->error('该区域下有商品，无法删除！');
			}
			$res = Db::name('goods_areas')
					->where('id',$id)
					->delete();
			if($res !== false){
				$this->run_log('删除商品区域数据操作。'.$message['area_name']);
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}
