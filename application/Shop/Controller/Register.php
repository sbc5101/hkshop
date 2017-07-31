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
		public function action_login()
		{
			$message = Request::instance()->post();
			// 数据验证
			$rule = [
			    [
			    	'first_name',
			    	'require|chsAlpha',
			    	'first name不能为空|请输入正确的first name'
			    ],
			    [
			    	'last_name',
			    	'require|chsAlpha',
			    	'last name不能为空|请输入正确的last name'
			    ],
			    [
				    'username',
				    'require|email|unique:users,username',
				    '邮箱不能为空|邮箱格式不正确|邮箱地址已存在'
			    ],
			    [
				    'password',
				    'require|/^[a-zA-Z0-9_]{6,18}$/ ',
				    '密码不能为空|密码由6到18位字母，数字或下划线组成'
			    ],
			];
			$data = [
			    'first_name'  	=> $message['first_name'],
			    'last_name'  	=> $message['last_name'],
			    'password'   	=> $message['password'],
			    'username'   		=> $message['username'],	
			];

			$validate = new Validate($rule);
			$result   = $validate->check($data);

			if(!$result){
				return json(['code' => 400,'message' => $validate->getError()]);
			}
			// 定义数据
			$data['password'] = md5($message['password']);
			$data['create_time'] = date('Y-m-d H:i:s',time());
			$data['is_close'] = 1;

			$res = Db::name('users')
					->insertGetId($data);
			if($res){
				$this->success('注册成功！');
			}else{
				$this->error('注册失败！');
			}
		}

		// // 设置session
		// Session::set('user.id', $res['id'],'admin_user');
		// Session::set('user.name', $res['user_name'],'admin_user');
		// Session::set('user.rule', $res['rule_id'],'admin_user');
	}