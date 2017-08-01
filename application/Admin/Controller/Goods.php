<?php
	/**
	* @Author: Yoshop
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
			$title = Request::instance()->get('title');
			$type = Request::instance()->get('type');
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
			// 特殊字符处理
			$title = urlencode($title);

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
							'type' => $type,
							'status' => $status,
							'title' => $title,
							],
						]);
			$title = urldecode($title);

			return $this->fetch('index',['data' => $data,'title' => $title,'type' => $type,'status' => $status,'page' => $page]);
		}

		/**
		 * 添加商品操作
		 */
		public function add_goods()
		{
			$cate_data = self::cate_route('cates','cate');
		
			return $this->fetch('add_goods',[
							'cate_data' => $cate_data,
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
			$title = Request::instance()->post('gname');
			$highlight_img = Request::instance()->file('highlight_img');
			$vender_img = Request::instance()->file('vender_img');

			$filemsg = '';
			$filemsgs = '';
		
			// 检测数据
			$goods_data = $this->check_goods_data($msg,$highlight_img,$vender_img);
	
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
							->where('type',$msg['type'])
							->where('title',$title)
							->where('years',$msg['years'])
							->find();
			if($title_exists){
				$this->error('商品名已存在！');
			}
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
				$this->run_log('新增商品数据操作。'.$title);
				$this->success('商品添加成功！','goods/add_goods');
			}else{
				$this->error('商品添加失败！');
			}	
			
		}

		/**
		 * 检测上传商品数据
		 * @param  [type] $data 		 [商品信息]
		 * @param  [type] $highlight_img [售货机亮点背景图]
		 * @param  [type] $vender_img	 [售货机商品图]
		 * @return [type]       		 [description]
		 */
		private function check_goods_data($data,$highlight_img,$vender_img)
		{	
			// 初始化数据
			$highlightImg = '';
			$venderImg = '';
			if(!array_key_exists('goods_msg', $data)){
				$data['goods_msg'] = '';
			}

			// 判断数据不能为空
			$rule = [
				['title','require','商品名不能为空'],
			    ['years','require','年份不能为空'],
			    ['productprice','require','基础价不能为空'], 
			    ['tax_point','require','税点不能为空'],
			    ['marketprice','require','零售价不能为空'],
			    ['storeprice','require','市场价不能为空'],
			    // ['package_price','require','组合套餐价格不能为空'],
			    ['weight','require','商品重量不能为空'],
			    ['content','require','商品描述不能为空'],
			    ['stock','require','库存不能为空'],
			];
			$msg = [
				'title'  => $data['gname'],
			    'years'  => $data['years'],
			    'productprice'  => $data['productprice'],
			    'tax_point'  => $data['tax_point'],
			    'marketprice'  => $data['marketprice'],
			    'storeprice'  => $data['storeprice'],
			    // 'package_price'  => $data['package_price'],
			    'weight'  => $data['weight'],
			    'content'  => $data['goods_msg'],
			    'stock' => $data['stock'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			if(!$result){
			    $this->error($validate->getError());
			}

			// 检测分类
			if($data['cate_id'][0] == 1){
				$cate_id = $data['cate_id'][0];
			}else{
				$cate_id = join(',',$data['cate_id']);
			}
			// 售货机亮点背景图
			if(!empty($highlight_img) && isset($highlight_img)){
				$highlightImg = $this->upload($highlight_img);
				if(!$highlightImg){
					$this->error($highlightImg);
				}
			}
			// 售货机商品主图
			if(!empty($vender_img) && isset($vender_img)){
				$venderImg = $this->upload($vender_img);
				if(!$venderImg){
					$this->error($venderImg);
				}
			}
			// 处理产区数据
			$origin_count = count($data['origin_id']);
			$origin_id = '';
			for ($i = 0; $i < $origin_count; $i++) { 
				if(!empty($data['origin_id'][$i])){
					$origin_id .= $data['origin_id'][$i].',';
				}
			}
			$origin_id = rtrim($origin_id,',');

			// 上架下架处理
			if($data['status'] ==  0){
				$status = '上架';
			}else{
				$status = '下架';
			}

			// 添加数据
			$arr =[
				'level' 			=> 	$data['level-txt'],
				'variety' 			=> 	$data['variety-txt'],
				'chateau' 			=> 	$data['chateau-txt'],
				'origin' 			=> 	$data['origin-txt'],
				'taste'  			=> 	$data['taste'],
				'component' 		=> 	$data['component'],
				'alcohol'  			=> 	$data['alcohol'],
				'condition' 		=> 	$data['condition'],
				'breathing' 		=> 	$data['breathing'],
				'stock_sta' 		=> 	$data['stock_sta'],
				'is_new'  			=> 	array_key_exists('is_new',$data) ? $data['is_new'] : '1',
				'is_hot'  			=>	array_key_exists('is_hot',$data) ? $data['is_hot'] : '1',
				'is_free'  			=> 	array_key_exists('is_free',$data) ? $data['is_free'] : '1',
				'is_home'  			=> 	array_key_exists('is_home',$data) ? $data['is_home'] : '1',
				'type'  			=> 	$data['type'],
				'status'  			=> 	$data['status'],
				'smell' 			=> 	$data['smell'],
				'area_id' 			=> 	$data['area_id'],
				'cate_id'  			=> 	$cate_id,
				'echoosewine'		=> 	empty($data['echoosewine']) ? '' : join(',',$data['echoosewine']),
				'quick_cateid'		=> 	empty($data['quick_cateid']) ? '' : ',' . join(',',$data['quick_cateid']) . ',',
				'origin_id'			=> 	$origin_id,
				'blend_id'			=> 	empty($data['blend_id']) ? '' : $data['varieties'].':'.join(',',$data['blend_id']),
				'winetype' 			=> 	empty($data['winetype']) ? '' : $data['winetype'],
				'price_id' 			=> 	empty($data['price_id']) ? '' : $data['price_id'],
				'type_id' 			=> 	empty($data['type_id']) ? '' : $data['type_id'],
			    'record_goosnum'  	=> 	$data['record_goosnum'],
			    'is_presale'  		=> 	$data['is_presale'],
			    'presale'  			=> 	$data['presale'],
			    'is_europe'  		=> 	$data['is_europe'],
			    'product_category'  => 	$data['product_category'],
			    'package_price'  	=> 	$data['package_price'],
			    'record_num'  		=> 	$data['record_num'],
			    'color'  			=> 	$data['color'],
			    'highlight1'  		=> 	$data['highlight1'],
			    'highlight2'  		=> 	empty($data['highlight2']) ? '' : str_replace('；',';',trim($data['highlight2'])),
			    'highlight_img'  	=> 	str_replace('\\','/','/public/uploads/'.date('Ymd') .'/'. $highlightImg),
			    'vender_img'  		=> 	str_replace('\\','/','/public/uploads/'.date('Ymd') .'/'. $venderImg),
			    'chateau_id'		=> 	$data['chateau_id'],
			    'temperature'		=> 	$data['temperature'],
			    'last_time'			=> 	date('Y-m-d H:i:s',time()),
			    'status_log'		=> 	$this->getAdminName().':'.$status.':'.date('Y-m-d H:i:s',time()),
			    'sort'				=> 	$data['sort'],
			    'otitle'			=> 	$data['otitle'],
			    'advanced'			=> 	empty($data['advanced']) ? '' : join(',',$data['advanced']),
			    'wine_style'		=> 	empty($data['wine_style']) ? '' : join(',',$data['wine_style']),
			    'fine_wine'			=> 	empty($data['fine_wine']) ? '' : join(',',$data['fine_wine']),
			    'theme'			=> 	empty($data['theme']) ? '' : join(',',$data['theme']),
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
			$title = Request::instance()->get('title');
			$type = Request::instance()->get('type');
			$status = Request::instance()->get('status');
			$page = Request::instance()->get('page');

			$area_data = self::cate_route('goods_areas','area');
			$cate_data = self::cate_route('cates','cate');
			$goods_data = Db::name('goods')
						->where('id',$id)
						->find();
			// 酒庄数据
			$chateau = Db::name('goods_chateau')
						->select();

			// 初始化数据
			$manor = '';
			$blend = [];
			$varieties = '';

			$quick_cate = Db::name('cates_quick')
						->field('id,quick_name')
						->where('display',0)
						->select();
			$theme_data = Db::name('activity_theme')
							->field('id,t_title')
							->where('is_close',1)
							->select();
			// 处理数据
			$goods_data['content'] 	= htmlspecialchars_decode($goods_data['content']);
			$echoosewine 			= empty($goods_data['echoosewine']) ? '' : explode(',',$goods_data['echoosewine']);
			$advanced 				= empty($goods_data['advanced']) ? '' : explode(',',$goods_data['advanced']);
			$wine_style 			= empty($goods_data['wine_style']) ? '' : explode(',',$goods_data['wine_style']);
			$fine_wine 				= empty($goods_data['fine_wine']) ? '' : explode(',',$goods_data['fine_wine']);
			$theme 				= empty($goods_data['theme']) ? '' : explode(',',$goods_data['theme']);
			$blend 					= empty($goods_data['blend_id']) ? '' : explode(',',$goods_data['blend_id']);
			$origin 				= empty($goods_data['origin_id']) ? '' : explode(',',$goods_data['origin_id']);
			$quick_cateid 			= empty($goods_data['quick_cateid']) ? '' : explode(',',trim($goods_data['quick_cateid'],','));
			$cate 					= empty($goods_data['cate_id']) ? '' : explode(',',$goods_data['cate_id']);

			// 防止数据为空
			if(empty($origin[0])){
				$origin[0] = '';
			}		
			if(empty($origin[1])){
				$origin[1] = '';
			}
			if(empty($origin[2])){
				$origin[2] = '';
			}
			if(empty($origin[3])){
				$origin[3] = '';
			}
			if(empty($origin[4])){
				$origin[4] = '';
			}

			// 判断分类混酿类型ID不为空
			if(!empty($goods_data['blend_id'])){
				$blend_id 	= explode(':',$goods_data['blend_id']);
				$varieties 	= $blend_id[0];
				if(!empty($blend_id[1])){
					$blend 	=  explode(',',$blend_id[1]);
				}
			}

			// 判断分类产地不为空
			if(!empty($origin)){
				$manor = Db::name('cates')
						->where('pid',$origin[0])
						->select();
			}
	
			return $this->fetch('rev_goods',[
					'goods_id' 		=> $id,
					'cate' 			=> $cate_data,
					'goods' 		=> $goods_data,
					'area'			=> $area_data,
					'echoosewine' 	=> $echoosewine,
					'blend' 		=> $blend,
					'origin' 		=> $origin,
					'manor' 		=> $manor,
					'cate_id' 		=> $cate,
					'quick_cateid' 	=> $quick_cateid,
					'quick_cate' 	=> $quick_cate,
					'varieties' 	=> $varieties,
					'title' 		=> $title,
					'type' 			=> $type,
					'status' 		=> $status,
					'page' 			=> $page,
					'chateau' 		=> $chateau,
					'advanced' 		=> $advanced,
					'wine_style' 	=> $wine_style,
					'fine_wine' 	=> $fine_wine,
					'theme_data' 	=> $theme_data,
					'theme' 		=> $theme,
				]);
		}

		/**
		 * 商品修改动作
		 * @return [type] [是否修改成功]
		 */
		public function action_rev_goods()
		{
			$msg = Request::instance()->post();
			$goods_id = Request::instance()->post('goods_id');
			$title = Request::instance()->post('gname');
			$highlight_img = Request::instance()->file('highlight_img');
			$vender_img = Request::instance()->file('vender_img');
			
			$boolean = Db::name('goods')
						->where('id','<>',$goods_id)
						->where('type',$msg['type'])
						->where('title',$title)
						->where('years',$msg['years'])
						->find();
		
			if($boolean){
				$this->error('该商品已存在！');
			}

			// 检测数据
			$goods_data = $this->check_goods_data($msg,$highlight_img,$vender_img);

			$res = Db::name('goods')
					->where('id',$goods_id)
					->update($goods_data);
			if($res !== false){
				$this->run_log('修改商品数据操作。'.$title);
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
							->field('title')
							->where('id',$res['goods_id'])
							->find();
				$this->run_log('删除商品图片操作。'.$msg['title']);
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
							->field('title')
							->where('id',$goods_id)
							->find();
				$this->run_log('新增商品图片操作。'.$msg['title']);
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
							->field('title')
							->where('id',$goods_id)
							->find();
					$this->run_log('修改商品图片封面操作。'.$msg['title']);
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
		 * 商品年份管理组
		 * @return [type] [description]
		 */
		public function year_group()
		{
			$data = Db::name('goods_group')
					->paginate(15);
			return $this->fetch('year_group',['data' => $data]);
		}

		/**
		 * 添加商品年份管理组
		 */
		public function add_year_group()
		{
			$data = Db::name('goods')
					->field('id,title,years,year_groupid')
					->where('year_groupid','null')
					->where('is_delete','0')
					->order('years','asc')
					->select();
			return $this->fetch('add_year_group',['data' => $data]);	
		}

		/**
		 * ajax获取商品信息
		 * @param  [type] $group_name [description]
		 * @return [type]             [description]
		 */
		public function ajax_get_yeargoods($group_name)
		{
			if(!empty($group_name)){
				$data = Db::name('goods')
						->field('id,title,years,year_groupid')
						->where('year_groupid','null')
						->where('is_delete','0')
						->where('title','like', '%'.$group_name.'%')
						->order('id','desc')
						->select();
			}else{
				$data = Db::name('goods')
						->field('id,title,years,year_groupid')
						->where('year_groupid','null')
						->where('is_delete','0')
						->order('id','desc')
						->select();
			}

			if(!empty($data)){
				foreach ($data as &$v) {
					// $group_name = Db::name('goods_group')
					// 				->field('group_name')
					// 				->where('id',$v['year_groupid'])
					// 				->find();
					// if(!empty($group_name['group_name'])){
					// 	$v['group_name'] = $group_name['group_name'];
					// }else{
						$v['group_name'] = '暂无分组';
					// }
				}
			}
			echo json_encode($data);
		}

		/**
		 * 添加分组动作
		 * @return [type] [description]
		 */
		public function action_add_year_group()
		{
			$msg = Request::instance()->post();
			$rule = [
				['group_name','require|unique:goods_group,group_name','组名不能为空|组名已存在'],
				['goodsid','require','请选择商品'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			if(!$result){
			    $this->error($validate->getError());
			}

			$data = [
				'group_name' 	=> $msg['group_name'],
				'goods_id'		=> ','.implode(',',$msg['goodsid']).',',
			];

			$id = Db::name('goods_group')
					->insertGetId($data);
			if($id){
				foreach ($msg['goodsid'] as $v) {
					Db::name('goods')
						->where('id',$v)
						->update(['year_groupid' => $id]);
				}
				$this->run_log('添加年份分组操作。'.$msg['group_name']);
				$this->success('添加成功！');
			}else{
				$this->error('添加失败！');
			}
		}

		/**
		 * 修改年份分组
		 * @param  [type] $id   [分组id]
		 * @return [type]       [description]
		 */
		public function rev_year_group($id){
			$goods_group = Db::name('goods')
							->field('id,title,years,year_groupid')
							->where('year_groupid',$id)
							->order('years','asc')
							->select();

			$goods = Db::name('goods')
					->field('id,title,years,year_groupid')
					->where('year_groupid','null')
					->where('status','0')
					->where('is_delete','0')
					->order('years','asc')
					->select();
			$name = Db::name('goods_group')
					->where('id',$id)
					->find();

			return $this->fetch('rev_year_group',['goods_group' => $goods_group,'goods' => $goods,'id' => $id,'name' => $name['group_name']]);
		}

		/**
		 * 修改分组动作
		 * @return [type] [description]
		 */
		public function action_rev_year_group()
		{
			$msg = Request::instance()->post();
			
			if(empty($msg['goodsid'])){
				$msg['goodsid'] = [];
			}
			$rule = [
				['group_name','require','组名不能为空'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			if(!$result){
			    $this->error($validate->getError());
			}
			$boolean = Db::name('goods_group')
						->where('group_name',$msg['group_name'])
						->where('id','<>',$msg['id'])
						->find();
			if(!empty($boolean)){
				$this->error('组名已存在！');
			}
			$goods_group = Db::name('goods_group')
							->where('id',$msg['id'])
							->find();

			$sel_goodsid = explode(',',trim($goods_group['goods_id'],','));
			foreach ($sel_goodsid as $v) {
				if(in_array($v,$msg['sel_goodsid'])){
					continue;
				}
				Db::name('goods')
					->where('id',$v)
					->update(['year_groupid' => null]);
			}
	
			$new_goodsid = array_merge($msg['sel_goodsid'],$msg['goodsid']);



			foreach ($new_goodsid as $v) {
				Db::name('goods')
					->where('id',$v)
					->update(['year_groupid' => $msg['id']]);
			}
			$goods = Db::name('goods')
					->field('id')
					->where('year_groupid',$msg['id'])
					->order('years','asc')
					->select();
			$str = ',';
			foreach ($goods as $v) {
				$str .= $v['id'];
			}
			$str = $str.',';
			$data = [
				'group_name' 	=> $msg['group_name'],
				'goods_id'		=> $str,
			];
			$res = Db::name('goods_group')
					->where('id',$msg['id'])
					->update($data);
			if($res !== false){
				$this->run_log('修改年份分组操作。'.$msg['group_name']);
				$this->success('修改成功！');
			}else{
				$this->error('修改失败！');
			}
		}

		/**
		 * 删除年份分组
		 * @param  [type] $id [年份分组ID]
		 * @return [type]     [description]
		 */
		public function action_del_year_group($id)
		{
			$data = Db::name('goods_group')
					->where('id',$id)
					->find();
			if(!empty($data)){
				$goods_id = explode(',',trim($data['goods_id'],','));
				if(!empty($goods_id)){
					foreach ($goods_id as $v) {
						Db::name('goods')
							->where('id',$v)
							->update(['year_groupid' => null]);
					}
				}
				$res = Db::name('goods_group')
						->where('id',$id)
						->delete();	
				if($res !== false){
					$this->run_log('删除年份分组操作。'.$data['group_name']);
					$this->success('删除成功！');
				}else{
					$this->error('删除失败！');
				}

			}
		}

		/**
		 * 查询品种混酿信息
		 * @param  [type] $id [分类ID]
		 * @return [type]     [description]
		 */
		public function ajax_get_varieties($id)
		{
			$data = Db::name('cates')
					->field('id,cname')
					->where('display',0)
					->where('pid',$id)
					->select();
			echo json_encode($data);
		}

		/**
		 * excel批量导入商品
		 * @return [type] [description]
		 */
		public function add_excel_goods()
		{
			return $this->fetch('add_excel_goods');
		}

		/**
		 * excel批量导入商品动作
		 * @return [type] [description]
		 */
		public function action_add_excel_goods()
		{
			$msg  = Request::instance()->post();
			$page_name  = Request::instance()->post('page_name');
			$file = Request::instance()->file('excel');

			$rule = [
				['field_row','require','当前字段行数不能为空'],
				['start_row','require','数据开始行数不能为空'],
				['end_row','require','数据结束行数不能为空'],
				['cel_num','require','列数不能为空'],
				['file','require','Excel不能为空'],
			];
			$msg = [
				'field_row'  => $msg['field_row'],
				'start_row'  => $msg['start_row'],
				'end_row'  => $msg['end_row'],
				'cel_num'  => $msg['cel_num'],
				'file'  => $file,
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			if(!$result){
			    $this->error($validate->getError());
			}
			// 初始化数据
			$field = '';
			$values = '';

			// 处理数据
			if(!empty($page_name)){
				$sheetName = array($page_name);
			}else{
				$sheetName = array("Sheet1");
			}

			// 上传Excel文件
			$filename = $this->uploadExcel($file);

			// Excel文件生成数组
			$ExcelToArrary = new ExcelToArrary;
			$res = $ExcelToArrary->read ($filename,$sheetName);

			//遍历生成字段
			foreach ($res[$msg['field_row']-1] as $k => $v) {
				if($k < $msg['cel_num']){
					$field .= '`'.$v.'`,';
				}
			}
			$field = trim($field,',');
			// 遍历生成数据
			foreach ($res as $k => $v) {
				if($k >= $msg['start_row']-1 && $k <= $msg['end_row']-1){
					// 处理标题数据
					$original_title = trim($v[0]); 
					// 检测标题是否存在|
					$is_vertical = strstr($original_title,'|');
					if($is_vertical){
						// 截取字符串|前面部分
						$title = trim(explode('|',$original_title)[0]);
						// 替换年份为%
						$title = str_replace($v[2],'%',$title);
						// 替换空格为%
						$title = str_replace(' ','%',$title);
						$title = str_replace('%%','%',$title);
						$title = '%'.trim($title,'%').'%';

						$data = Db::name('goods')
								->field('id')
								->where('title','like',$title)
								->where('type',$v[1])
								->where('years',$v[2])
								->find();
					}else{
						$data = Db::name('goods')
								->field('id')
								->where('title',$v[0])
								->where('type',$v[1])
								->where('years',$v[2])
								->find();
					}
	
					if(empty($data)){
						foreach ($v as $key => $value) {
							if($key == 0){
								$values .= "('".str_replace("'","\'",$value)."',";
							}
							if($key > 0 && $key < $msg['cel_num'] -1){
								$values .= "'".str_replace("'","\'",$value)."',";
							}
							if($key == $msg['cel_num']-1){
								$values .= "'".str_replace("'","\'",$value)."'),";
							}
						}
					}
				}
			}
		
			$values = trim($values,',');

			// 插入数据
			$res = Db::execute("INSERT INTO `yo_goods`(".$field.") VALUES".$values);
			if($res){
				$this->run_log('批量导入商品操作。');
				$this->success('导入成功！','goods/index');
			}else{
				$this->error('导入失败！');
			}
		}

		/**
		 * 商品酒庄列表
		 * @return [type] [description]
		 */
		public function chateau_index()
		{
			$data = Db::name('goods_chateau')
					->paginate('20');

			return $this->fetch('chateau_index',['data' => $data]);
		}

		/**
		 * 添加酒庄
		 * @return [type] [description]
		 */
		public function add_chateau()
		{
			return $this->fetch('add_chateau');
		}

		/**
		 * 添加酒庄动作
		 * @return [type] [description]
		 */
		public function action_add_chateau()
		{
			$data = Request::instance()->post();
			$file = Request::instance()->file('c_img');

			// 验证数据
			$rule = [
				['c_title','require','酒庄名称不能为空'],
				['c_content','require','酒庄内容不能为空'],
				['file','require','酒庄图片不能为空'],
			];
			$msg = [
				'c_title'  	 => $data['c_title'],
				'c_content'  => $data['c_content'],
				'file'  	 => $file,
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			if(!$result){
			    $this->error($validate->getError());
			}

			// 上传图片
			$filemsg = $this->upload($file);
			if(!$filemsg){
				$this->error($filemsg);
			}
			$data['c_img'] = str_replace('\\','/','/public/uploads/'.date('Ymd') .'/'. $filemsg);

			// 插入数据
			$res = Db::name('goods_chateau')
					->insert($data);

			if($res){
				$this->run_log('添加酒庄操作。'.$data['c_title']);
				$this->success('添加成功！');
			}else{
				$this->error('添加失败！');
			}
			
		}

		/**
		 * 修改酒庄信息
		 * @param  [type] $id [酒庄ID]
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
		 * 修改酒庄动作
		 * @return [type] [description]
		 */
		public function action_rev_chateau()
		{
			$data = Request::instance()->post();
			$id = Request::instance()->post('id');
			$file = Request::instance()->file('c_img');
			unset($data['id']);
			// 验证数据
			$rule = [
				['c_title','require','酒庄名称不能为空'],
				['c_content','require','酒庄内容不能为空'],
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

			// 上传图片
			if(!empty($file)){
				$filemsg = $this->upload($file);
				if(!$filemsg){
					$this->error($filemsg);
				}
				$data['c_img'] = str_replace('\\','/','/public/uploads/'.date('Ymd') .'/'. $filemsg);
			}

			// 修改数据
			$res = Db::name('goods_chateau')
					->where('id',$id)
					->update($data);

			if($res !== false){
				$this->run_log('修改酒庄操作。'.$data['c_title']);
				$this->success('修改成功！');
			}else{
				$this->error('修改失败！');
			}
			
		}

		/**
		 * 删除酒庄信息动作
		 * @param  [type] $id [酒庄ID]
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
				$this->run_log('删除酒庄操作。'.$data['c_title']);
				$this->success('删除成功！');
			}else{
				$this->error('删除失败！');
			}
		}

	}
