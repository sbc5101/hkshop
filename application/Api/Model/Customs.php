<?php

	namespace app\api\model;
	use think\Validate;
	use think\Log;
	use think\Db;
	use vendor\oms\SvcCall;
	class Customs extends \think\Model
	{

		/**
		 * 海关申报配置信息
		 * @var array
		 */
		private $customs_config = array(
				'sign_type'			=> '0',//签名方式
				'service_version'	=> '1.0',//版本号
				'input_charset'		=> 'UTF-8',//字符集
				'mcht_id'			=> '103910170307008',//商户号
				'mcht_customs_code' => 'DXPENT0000014200',//海关备案编号
				'mcht_customs_name' => '平潭优欧跨境电子商务有限公司',//海关备案名称
				'currency'			=> '156',//币种 人民币
				'customs_type'		=> '00002006',//海关
				'id_type'			=> '01',//证件号 01 身份证
				'is_split'			=> 'Y',//
				'key'				=> 'cvdsGErt5erygdfdhyu8u5rtdHLIUt45',//商户秘钥
		);

		/**
		 * 跨境订单推送配置信息
		 * @var array
		 */
		private $order_push_config = array(
				'url'		=> 'http://218.104.239.231:82/default/svc/web-service',
				'appToken'	=> '20995c86d5afc6a5599e6b43df16ca4d',
				'appKey'	=> '9cf7163c8fdaa867239d4cc0f056639e',
		);

		/**
		 * 推送海关申报信息
		 * @param  [type] $order_num [订单号]
		 * @param  [type] $order     [订单数据]
		 * @return [type]            [description]
		 */
		public function customs($order_num,$order)
		{
			$data = array(
				'sign_type'			=> $this->customs_config['sign_type'],
				'service_version'	=> $this->customs_config['service_version'],
				'input_charset'		=> $this->customs_config['input_charset'],
				'request_id'		=> 'app'.$order_num,	
				'notify_url'		=> request()->domain().url('api/order/back_customs'),
				'mcht_id'			=> $this->customs_config['mcht_id'],
				'mcht_customs_code' => $this->customs_config['mcht_customs_code'],
				'mcht_customs_name' => $this->customs_config['mcht_customs_name'],
				'currency'			=> $this->customs_config['currency'],
				'amount'			=> $order['price'] * 100,
				'customs_type'		=> $this->customs_config['customs_type'],
				'id_type'			=> $this->customs_config['id_type'],
				'id_no'				=> $order['idcard'],
				'id_name' 			=> $order['username'],
				'is_split'			=> $this->customs_config['is_split'],
				'sub_order_no'		=> $order_num,
			);
		
			ksort($data);
			$stringToBeSigned = '';
			$i = 0;
			foreach ($data as $k => $v) {
				if ($i == 0) {
						$stringToBeSigned .= "$k" . "=" . "$v";
				} else {
						$stringToBeSigned .= "&" . "$k" . "=" ."$v";
				}
				$i++;
			}
			$key = strtoupper(md5($stringToBeSigned.'&key='.$this->customs_config['key']));
		
			$data['sign_msg'] = $key;
			$str = '';
			$j = 0;
			foreach ($data as $k => $v) {
				if ($j == 0) {
						$str .= "$k" . "=" . urlencode($v);
				} else {
						$str .= "&" . "$k" . "=" .urlencode($v);
				}
				$j++;
			}
			return $str;
			
		}


		/**
		 * 跨境订单推送
		 * @param  [type] $order       [订单数据]
		 * @param  [type] $order_goods [订单商品数据]
		 * @return [type]              [description]
		 */
		public function cross_border_oder_push($order,$order_goods)
		{
			$orderInfo = array(
	       		'platform' => 'B2C',
		        'warehouse_code' => 'KJCK',
		        'shipping_method' => 'STO',
		        'reference_no' => $order['order_num'],
		        'order_desc' => '都市贵族红酒跨境商品订单。',
		        'country_code' => 'CN',
		        'province' => $order['address_province'],
		        'city' => $order['address_city'],
		        'address1' => $order['address_area'],
		        'address2' => $order['address_address'],
		        'zipcode' => $order['postcode'],
		        'name' => $order['recipients'],
		        'identityNo' => $order['idcard'],
		        'phone' => $order['address_mobile'],
		        // 'verify' => 1,
		    );
		    $items = array();
		    foreach ($order_goods as $v) {
		    	if(strpos($v['title'],'*') != false){
					$num = strpos($v['title'],'*')+1;
					$v['goods_num'] = substr($v['title'],$num,1);
				}
		    	$items[] = array(
			        'product_sku' => $v['record_goosnum'],
			        'quantity' => $v['goods_num']
		    	);
		    }
		    
		    $orderInfo['items'] = $items;
	
		    vendor('oms.SvcCall');
		    $svc = new SvcCall(); 

		    $res = $svc->createOrder($orderInfo);
			return $res;
		}


		/**
		 * 获取海关订单列表
		 * @return [type] [description]
		 */
		public function get_customs_order_list()
		{
		    $params = array(
		        'pageSize' => '',
		        'page' => '',
		        'order_code' => '',
		        'order_code_arr' => array(),
		        'create_date_from' => '',
		        'create_date_to' => '',
		        'modify_date_from' => '',
		        'modify_date_to' => ''
		    );

			vendor('oms.SvcCall');
		    $svc = new SvcCall(); 
		    $res = $svc->getOrderList($params);
			return $res;
		}


		/**
		 * 海关回复信息
		 * @return [type] [description]
		 */
		public function back_customs($data)
		{
			$order = Db::name('shop_order')
					->where('customs_request_id',$data['request_id'])
					->find();
			if(!empty($order)){
				if($data['customs_tx_status'] == 1){
					Db::name('customslog')
						->insert(['code' => 1,'msg' => '待申报！','createtime' => date('Y-m-d H:i:s',time()),'request_id' => $data['request_id']]);
				}elseif ($data['customs_tx_status'] == 3) {
					Db::name('customslog')
						->insert(['code' => 3,'msg' => '申报中！','createtime' => date('Y-m-d H:i:s',time()),'request_id' => $data['request_id']]);
				}elseif ($data['customs_tx_status'] == 4) {
					Db::name('customslog')
						->insert(['code' => 4,'msg' => '申报成功！','createtime' => date('Y-m-d H:i:s',time()),'request_id' => $data['request_id']]);
					Db::name('shop_order')
						->where('customs_request_id',$data['request_id'])
						->update(['declare_payment_no' => $data['declare_payment_no'],'customs_order_id' => $data['customs_order_id']]);
					return 'success';
				}else{
					Db::name('customslog')
						->insert(['code' => 5,'msg' => '申报失败！','createtime' => date('Y-m-d H:i:s',time()),'request_id' => $data['request_id']]);
				}
			}
		}



	}



?>