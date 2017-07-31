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
			// if(empty(Session::get('user.id','admin_user'))){
			// 	// $this->error('请登录用户','login/index');
			// 	$this->redirect('login/index');
			// }else{
				
			// }
		}

		/**
		 * 退出登录
		 * @return [type] [description]
		 */
		public function loginOut()
		{
			Session::clear('admin_user');
			if(empty(Session::get('user.id','admin_user'))){
				$this->success('退出成功','login/index');		
			}
		}

		/**
		 * 获取用户id
		 * @return [type] [返回用户id]
		 */
		protected function getAdminId()
		{
			return Session::get('user.id','admin_user');
		}

		/**
		 * 获取用户名
		 * @return [type] [返回用户名]
		 */
		protected function getAdminName()
		{
			return Session::get('user.name','admin_user');
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
		 * 分类路径数据
		 * @return [type] [description]
		 */
		static public function cate_route_str($name,$style)
		{
			$data = Db::name($name)
					->select();
			// 构造新数据
			foreach ($data as $k => $v) {
				if($style == 'cate'){
	                $data[$k]['new_path'] =  str_repeat('**|',substr_count($v['path'],',')).$v['cname'];
				}
				if($style == 'area'){
	                $data[$k]['new_path'] =  str_repeat('**|',substr_count($v['path'],',')).$v['a_name'];
				}
                $data[$k]['path_number'] = substr_count($v['path'],',');
			}
			// 排序
			$res = self::sort($data,'path_number');
	
			return $res;

		}

		/**
		 * 分类路径数据
		 * @return [type] [description]
		 */
		static public function cate_route($name,$style)
		{
			$data = Db::name($name)
					->select();
			// 构造新数据
			foreach ($data as $k => $v) {
				if($style == 'cate'){
	                $data[$k]['new_path'] = $v['cname'];
				}
				if($style == 'area'){
	                $data[$k]['new_path'] = $v['a_name'];
				}
                $data[$k]['path_number'] = substr_count($v['path'],',');
			}
			// 排序
			$res = self::sort($data,'path_number');
	
			return $res;

		}

		/**
	     * 分类排序（降序）
	     */
	    static public function sort($arr,$cols){
	        //子分类排序
	        $n=count($arr);
	        for ($i=0; $i < $n-1; $i++) {
	            for ($j=0; $j < $n-1-$i; $j++) {
	                if($arr[$j][$cols] > $arr[$j+1][$cols]){
	                    $t=$arr[$j];
	                    $arr[$j]=$arr[$j+1];
	                    $arr[$j+1]=$t;
	                }
	            }
	        }
	        return $arr;
	    }

		// 获取省级地区数据
		protected function get_provinces()
		{
			if(Cache::get('provinces')){
				$data = Cache::get('provinces');
			}else{
				$data = Db::name('provinces')
						->field('provinceid,province')
						->select();
				Cache::set('provinces',$data,0);
			}
			return $data;
		}

		// 获取城市地区数据
		protected function get_cities($id)
		{
	
			$res = Db::name('cities')
					->where('provinceid',$id)
					->field('cityid,city,provinceid')
					->select();
		
			return $res;
		}

		// 获取区域数据
		protected function get_areas($id)
		{
		
			$res = Db::name('areas')
					->where('cityid',$id)
					->field('cityid,area,areaid')
					->select();

			return $res;
		}
		
		/** 
		* 模拟提交参数，支持https提交 可用于各类api请求 
		* @param string $url ： 提交的地址 
		* @param array $data :POST数组 
		* @param string $method : POST/GET，默认GET方式 
		* @return mixed 
		*/  
		public function customs_http($url, $data='', $method='POST'){   
		    $curl = curl_init(); // 启动一个CURL会话  
		    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址  
		    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查  
		    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在  
		    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器  
		    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转  
		    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer  
		    if($method=='POST'){  
		        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求  
		        if ($data != ''){  
		            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包  
		        }  
		    }  
		    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环  
		    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容  
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回  
		    $tmpInfo = curl_exec($curl); // 执行操作  
		    curl_close($curl); // 关闭CURL会话  
		    return $tmpInfo; // 返回数据  
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
