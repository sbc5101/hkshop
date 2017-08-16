<?php
	namespace app\shop\controller;

	use app\shop\controller\Base;
	use think\Validate;
	use think\Db;
	use think\Request;
	use think\Session;
	/**
	* @Author: Yoshop
	* 个人中心类
	* @Date:   2016-12-30 15:38:14
	* @Last Modified time: 2016-12-30 16:20:06
	*/
	class Member extends Base 
	{
		/**
		 * 个人中心
		 * @return [type] [后台会员数据]
		 */
		public function personal_center()
		{
			$first_name = Session::get('user.first_name','hk_shop_user');
			$last_name = Session::get('user.last_name','hk_shop_user');
			$name =  $last_name . ' ' . $first_name;
			return $this->fetch('personal_center',['name' => $name]);
		}
	}