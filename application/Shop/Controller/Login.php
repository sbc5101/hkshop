<?php
	namespace app\shop\controller;

	use think\Controller;
	use think\Db;
	use think\Validate;
	use think\Request;
	use think\Session;

	/**
	* @Author: Yoshop
	* 前台登入类
	* @Date:   2017-07-19 15:38:14
	* @Last Modified time: 2017-07-19 16:20:06
	*/
	class Login  extends Controller
	{
		/**
		 * 跳转登入页面
		 * @return [type] [description]
		 */
		public function login()
		{
			return $this->fetch('login');
		}

		/**
		 * 用户执行登入
		 * @return [type] [description]
		 */
		public function action_login()
		{
			$message = Request::instance()->post();
			// 数据验证
			$rule = [
			    [
			    	'username',
			    	'require|email',
			    	'郵箱不能為空|郵箱格式不正確'
			    ],
			    [
				    'password',
				    'require|/^[a-zA-Z0-9_]{6,18}$/ ',
				    '密碼不能為空|密碼由6到18位字母，數字或下劃線組成'
			    ],
			];
			$data = [
			    'username'  => $message['username'],
			    'password'   => $message['password'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($data);

			if(!$result){
			    return json(['code' => 400,'message' => $validate->getError()]);
			}

			$res = Db::name('users')
					->field('id,username,first_name,last_name')
					->where('username',$message['username'])
					->where('password',md5($message['password']))
					->find();
			$request = Request::instance();
			if(!empty($res)){
				Db::name('users')
					->where('id',$res['id'])
					->update([
							'last_time' => date('Y-m-d H:i:s',time()),
							'last_ip' 	=> $request->ip(),
							]);

				// 设置session
				Session::set('user.id', $res['id'],'hk_shop_user');
				Session::set('user.name', $res['username'],'hk_shop_user');
				Session::set('user.first_name', $res['first_name'],'hk_shop_user');
				Session::set('user.last_name', $res['last_name'],'hk_shop_user');
				return json(['code' => 200,'message' => '登錄成功',]);
			}else{
				return json(['code' => 400,'message' => '密碼或用戶名錯誤']);
			}
		}
	}