<?php
	/**
	* @Author: Yoshop
	* 购物车类
	* @Date:   2016-12-29 15:38:14
	* @Last Modified time: 2016-12-29 16:20:06
	*/

	namespace app\shop\controller;

	use think\Controller;
	// use think\Cache;

	class Cart extends Controller
	{
		public function shopping_cart()
		{
			return $this->fetch('shopping_cart');
		}

	}
 