<?php
	/**
	 * @ HkShop
	 * 前台基础类
	 * @Date:   2016-12-29 15:37:53
	 * @Last Modified time: 2017-01-16 11:26:11
	 */

	namespace app\shop\controller;

	use think\Controller;
	use think\Session;
	use think\Db;
	use think\Cache;
	use think\Request;
	use app\shop\model\emailSend;

	class Base extends Controller
	{
		/**
		 * 判断是否登录
		 * @return [type] [description]
		 */
		public function _initialize()
		{
			if(empty(Session::get('user.id','hk_shop_user'))){
				$this->redirect('login/login');
			}
		}

		/**
		 * 退出登录
		 * @return [type] [description]
		 */
		public function loginOut()
		{
			Session::clear('hk_shop_user');
			if(empty(Session::get('user.id','hk_shop_user'))){
				$this->success('退出成功','login/index');		
			}
		}
		
		/**
		 * 单文件上传
		 * @param  [type] $file [文件信息]
		 * @return [type]       [description]
		 */
		public function upload($file)
		{
		    // 移动到框架应用根目录/public/uploads/ 目录下
		    $info = $file->rule('sha1')->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . date('Ymd'));
		    if($info){
		        // 成功上传后 获取上传信息
		        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
		        return $info->getSaveName();
		    }else{
		        // 上传失败获取错误信息
		        return $file->getError();
		    }
		}

		
		/**
		 * 多文件上传
		 * @param  [type] $files [文件上传信息]
		 * @return [type]        [description]
		 */
		public function uploads($files)
		{
		    $data = [];
		    foreach($files as $file){
		        // 移动到框架应用根目录/public/uploads/ 目录下
		        $info = $file->rule('sha1')->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . date('Ymd'));
		        if($info){
		            // 成功上传后 获取上传信息
		            // 输出 42a79759f284b767dfcb2a0197904287.jpg
		            $data[] = $info->getSaveName(); 
		        }else{
		            // 上传失败获取错误信息
		            return $file->getError();
		        }    
		    }
		   
		    return $data;
		}

	 	/**
	 	 * 邮箱发送
	 	 * @param  [type] $data [用户邮箱信息]
	 	 * @return [type]       [description]
	 	 */
	 	public function email_send($data)
		{
			$Send = new emailSend;
			$result = $Send->email([
				'email'  => $data['email'],
				'subject'  => $data['subject'],
				'message'  => $data['message'],
			]);
			if($result !== true){
				return 'error';
			}
			return 'success';
		}
	}
