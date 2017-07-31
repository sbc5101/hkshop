<?php
	/**
	* @Author: Yoshop
	* 商品类接口
	* @Date:   2016-12-27 15:38:14
	* @Last Modified time: 2016-12-27 16:20:06
	*/

	namespace app\api\controller;

	use app\api\controller\Base;
	use think\Validate;
	use think\Request;
	use think\Db;
	class Goods extends Base
	{
		public function add_mgoods()
		{
			$data = Request::instance()->post();
			
			// 获取机器信息
			$machine = Db::name('seller_shop')
						->where('machine_code',$data['mcode'])
						->find();
			
			echo '<pre>';
			print_r($machine);
			die;
		}
	}
