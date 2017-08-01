<?php
	/**
	* @Author: Yoshop
	* 商品类
	* @Date:   2016-12-29 15:38:14
	* @Last Modified time: 2016-12-29 16:20:06
	*/

	namespace app\shop\controller;

	use app\shop\controller\Base;
	// use think\Cache;

	class Goods extends Base
	{
		public function goods_detail()
		{
			return $this->fetch('goods_detail');
		}

	}
 