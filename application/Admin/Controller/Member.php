<?php
	namespace app\admin\controller;

	use app\admin\controller\Base;
	use think\Validate;
	use think\Db;
	use think\Request;
	/**
	* @Author: Yoshop
	* 后台会员管理类
	* @Date:   2016-12-30 15:38:14
	* @Last Modified time: 2016-12-30 16:20:06
	*/
	class Member extends Base 
	{
		/**
		 * 后台会员列表
		 * @return [type] [后台会员数据]
		 */
		public function users()
		{
			// 接收数据
			$name 		= Request::instance()->get('username');
			$user_name = empty($name) ? '' : 'username like "%'.$name.'%"';
	
			$data = Db::name('users')
					->where($user_name)
					->order('id','desc')
					->paginate(20,false,[
						'query' => [
							'username' => $name,
							],
						]);
			$new_data = [];
			if(!empty($data)){
				foreach ($data as $k => $v) {
					$new_data[$k] = $v;
				}
			}
			return $this->fetch('users',['data' => $data,'new_data' => $new_data]);
		}

		/**
		 * [add_user 添加会员操作]
		 */
		public function  add_user()
		{
			return $this->fetch('member/add_user');
		}

		/**
		 * 执行添加动作
		 * @return [type] [description]
		 */
		public function action_add_user()
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
			    'username'   	=> $message['username'],	
			];

			$validate = new Validate($rule);
			$result   = $validate->check($data);

			if(!$result){
				$this>error($validate->getError());
			}
			// 定义数据
			$data['password'] = md5($message['password']);
			$data['create_time'] = date('Y-m-d H:i:s',time());
			$data['is_close'] = 0;

			$res = Db::name('users')
					->insertGetId($data);
			if($res){
				$this->run_log('添加会员用户数据操作。'.$message['username']);
				$this->success('添加用户成功','member/users');
			}else{
				$this->error('添加用户失败');
			}

		}
		
		/**
		 * 会员禁止动作
		 * @param  [type] $id [会员id]
		 * @param  [type] $is_close [会员状态 0 正常 1 禁止]
		 * @return [type]     [是否禁止成功]
		 */
		public function action_rev_status($id,$is_close)
		{
			// 判断参数
			if(isset($id) && !empty($id)){
				$result = Db::name('users')
						->where('id',$id)
						->update(['is_close' => $is_close]);
						
				if($result){
					$msg = Db::name('users')
							->where('id',$id)
							->find();
					$this->run_log('禁止会员用户数据操作。'.$msg['username']);
					$this->success('操作成功');
				}else{
					$this->error('操作失败');
				}
			}else{
				$this->error('参数不能为空');
			}
		}

		/**
		 * 执行后台会员修改
		 * @param  [type] $id [会员id]
		 * @return [type]     [进入修改页面]
		 */
		public function rev_user($id)
		{
			if(isset($id) && !empty($id)){
				$is_agent = 0;
				$data = Db::name('users')
						->find($id);
				return $this->fetch('rev_user',['data' => $data]);
			}else{
				$this->error('参数不能为空');
			}
		}

		/**
		 * 执行修改动作
		 * @return [type] [description]
		 */
		public function action_rev_user()
		{
			$message = Request::instance()->post();
			$uid = Request::instance()->post('id');
			unset($message['username']);

			if(!empty($message['password'])){
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
					    'password',
					    '/^[a-zA-Z0-9_]{6,18}$/ ',
					    '密码不能为空|密码由6到18位字母，数字或下划线组成'
				    ],
				];
				$data = [
				    'first_name'  	=> $message['first_name'],
				    'last_name'  	=> $message['last_name'],
				    'password'   	=> $message['password'],
				];
				$message['password'] = md5($message['password']);
			}else{
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
				];
				$data = [
				    'first_name'  	=> $message['first_name'],
				    'last_name'  	=> $message['last_name'],
				];
				unset($message['password']);
			}
			$validate = new Validate($rule);
			$result   = $validate->check($data);

			if(!$result){
				$this->error($validate->getError());
			}

			$rev = Db::name('users')
					->where('id',$uid)
					->update($message);
			if($rev !== false){
				$msg = Db::name('users')
						->where('id',$uid)
						->find();
				$this->run_log('修改会员用户数据操作。'.$msg['username']);
				$this->success('修改成功','member/users');
			}else{
				$this->error('修改失败');
			}

		}
	}