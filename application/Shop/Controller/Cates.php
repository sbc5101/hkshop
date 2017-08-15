<?php
	/**
	* @Author: Hkshop
	* 分类管理类
	* @Date:   2016-12-31 15:38:14
	* @Last Modified time: 2016-12-31 16:20:06
	*/

	namespace app\shop\controller;

	use app\shop\controller\Base;
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
		public function cate_list()
		{
			return $this->fetch('cate_list');
		}

	}
