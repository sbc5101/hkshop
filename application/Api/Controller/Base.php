<?php
	/**
	 * @ YoShop
	 * 基础类接口
	 * @Date:   2016-12-27 15:37:53
	 * @Last Modified time: 2016-12-28 14:40:52
	 */

	namespace app\api\controller;

	use think\Controller;
	use think\Db;
	use think\Cache;

	class Base extends Controller
	{
		
		/**
		 * 微商城数据库配置
		 * @var [type]
		 */
		protected  $db1 = [
			    	// 数据库类型
				    'type'     => 'mysql',
				    // 服务器地址
				    'hostname' => '114.55.145.114',
				    // 数据库名
				    'database' => 'ce_chat',
				    // 数据库用户名
				    'username' => 'root',
				    // 数据库密码
				    'password' => 'QxfasdXASD23asd32h',
				    // 数据库连接端口
				    'hostport' => '3306',
				    // 数据库连接参数
				    'params'   => [],
				    // 数据库编码默认采用utf8
				    'charset'  => 'utf8',
				    // 数据库表前缀
				    'prefix'   => '',
				];
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
		protected function get_cities()
		{
	
			if(Cache::get('cities')){
				$data = Cache::get('cities');
			}else{
				$data = Db::name('cities')
						->field('cityid,city,provinceid')
						->select();
				Cache::set('cities',$data,0);
			}

			return $data;
		}

		// 获取区域数据
		protected function get_areas()
		{
			if(Cache::get('areas')){
				$data = Cache::get('areas');
			}else{
				$data = Db::name('areas')
						->field('cityid,area,areaid')
						->select();
				Cache::set('areas',$data,0);
			}

			return $data;
		}

		/**
		 * 成功购买订单增加商品数量
		 * @param  [type] $order_goods 	[订单商品数据]
		 * @return [type]          	 	[description]
		 */
		public function sales_volume($order_goods)
		{
			if(!empty($order_goods)){
				foreach ($order_goods as $v) {
					if($v['is_machine'] !== 1){
						if($v['shop_id'] == 0){
							Db::name('goods')
								->where('id',$v['goodsid'])
								->setInc('sale_number',$v['goods_num']);
						}else{
							Db::name('shop_goods')
								->where('id',$v['goodsid'])
								->setInc('sale_number',$v['goods_num']);
						}
					}
				}
			}

		}

	}