<?php 
	use think\Session;
	use think\Db;
	use think\Cache;

	function get_cates()
	{
		if(!empty(Cache::get('shop_cates'))){
			return Cache::get('shop_cates');
		}
		$data = Db::name('cates')
					->cache('shop_cates',3600)
					->select();
		// 排序
		return $data;
	}

 ?>