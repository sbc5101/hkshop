<?php
	namespace app\shop\controller;

	use think\Controller;
	use think\Db;
	use think\Validate;
	use think\Request;
	use think\Session;

	/**
	* @Author: Hkshop
	* 前台注册类
	* @Date:   2017-07-19 15:38:14
	* @Last Modified time: 2017-07-19 16:20:06
	*/
	class Register  extends Controller
	{
		/**
		 *  进入注册页面
		 * @return [type] [description]
		 */
		public function index()
		{
			return $this->fetch('index');
		}

		/**
		 * 用户注册动作
		 * @return [type] [description]
		 */
		public function action_register()
		{
			$message = Request::instance()->post();
			// 数据验证
			$rule = [
			    [
			    	'first_name',
			    	'require|chsAlpha',
			    	'first name不能為空|請輸入正確的first name'
			    ],
			    [
			    	'last_name',
			    	'require|chsAlpha',
			    	'last name不能為空|請輸入正確的last name'
			    ],
			    [
				    'username',
				    'require|email|unique:users,username',
				    '郵箱不能為空|郵箱格式不正確|郵箱地址已存在'
			    ],
			    [
				    'password',
				    'require|/^[a-zA-Z0-9_]{6,18}$/ ',
				    '密碼不能為空|密碼由6到18位字母，數字或下劃線組成'
			    ],
			];
			$data = [
			    'first_name'  	=> $message['first_name'],
			    'last_name'  	=> $message['last_name'],
			    'password'   	=> $message['password'],
			    'username'   		=> $message['email'],	
			];

			$validate = new Validate($rule);
			$result   = $validate->check($data);

			if(!$result){
				return json(['code' => 400,'message' => $validate->getError()]);
			}
			// 定义数据
			$data['password'] = md5($message['password']);
			$data['create_time'] = date('Y-m-d H:i:s',time());
			$data['is_close'] = 0;

			$res = Db::name('users')
					->insertGetId($data);
			$request = Request::instance();
			if($res){
				Db::name('users')
					->where('id',$res['id'])
					->update([
							'last_time' => date('Y-m-d H:i:s',time()),
							'last_ip' 	=> $request->ip(),
							]);

				// 设置session
				Session::set('user.id', $res,'shop_user');
				Session::set('user.name', $message['email'],'shop_user');
				Session::set('user.first_name', $message['first_name'],'shop_user');
				Session::set('user.last_name', $message['last_name'],'shop_user');
				return json(['code' => 200,'message' => 'success','data' => ['access_token' => md5($res)]]);
			}else{
				return json(['code' => 400,'message' => 'error']);
			}
		}

	}