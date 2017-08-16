<?php
	namespace app\admin\controller;

	use think\Controller;
	use think\Db;
	use think\Validate;
	use think\Request;
	use think\Session;

	/**
	* @Author: Hkshop
	* 后台登入类
	* @Date:   2017-07-19 15:38:14
	* @Last Modified time: 2017-07-19 16:20:06
	*/
	class Login  extends Controller
	{
		public function index()
		{
			return $this->fetch('index');
		}

		public function action_login()
		{
			$message = Request::instance()->post();
			// 数据验证
			$rule = [
			    [
			    	'name',
			    	'require|/^[a-zA-Z0-9_]{3,16}$/',
			    	'用户名不能为空|用户名由3到18位字母，数字或下划线组成'
			    ],
			    [
				    'password',
				    'require|/^[a-zA-Z0-9_]{6,18}$/ ',
				    '密码不能为空|密码由6到18位字母，数字或下划线组成'
			    ],
			];
			$data = [
			    'name'  => $message['name'],
			    'password'   => $message['password'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($data);

			if(!$result){
			    $this->error($validate->getError());
			}

			$res = Db::name('admin')
					->field('id,user_name,rule_id')
					->where('user_name',$message['name'])
					->where('password',md5($message['password']))
					->find();
			$request = Request::instance();
			if($res){
				Db::name('admin')
					->where('id',$res['id'])
					->update(['last_time' => date('Y-m-d H:i:s',time()),'last_ip' => $request->ip()]);

				// 设置session
				Session::set('user.id', $res['id'],'hk_admin_user');
				Session::set('user.name', $res['user_name'],'hk_admin_user');
				Session::set('user.rule', $res['rule_id'],'hk_admin_user');

				$this->success('登录成功！','index/index');
			}else{
				$this->error('用户名或密码错误！');
			}
		}
	}