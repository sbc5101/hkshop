<?php
	/**
	* @Author: Yoshop
	* 后台首页类
	* @Date:   2016-12-29 15:38:14
	* @Last Modified time: 2016-12-29 16:20:06
	*/

	namespace app\shop\controller;

	use think\Controller;
	// use think\Cache;

	class Index extends Controller
	{
		public function index()
		{
			return $this->fetch('index');
		}

	}
 