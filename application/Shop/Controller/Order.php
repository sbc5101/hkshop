<?php
	/**
	* @Author: Yoshop
	* 后台首页类
	* @Date:   2016-12-29 15:38:14
	* @Last Modified time: 2016-12-29 16:20:06
	*/

	namespace app\shop\controller;

	use app\shop\controller\Base;
	// use think\Cache;

	class Order extends Base
	{
		public function order_detail()
		{
			return $this->fetch('order_detail');
		}

	}
 