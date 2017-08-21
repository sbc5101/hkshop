<?php
	/**
	* @Author: Yoshop
	* 后台订单管理类
	* @Date:   2016-12-29 15:38:14
	* @Last Modified time: 2016-12-29 16:20:06
	*/

	namespace app\admin\controller;

	use app\admin\controller\Base;
	use think\Db;
	use think\Request;
	use think\Validate;
	use vendor\oms\SvcCall;

	class Order extends Base
	{
		/**
		 * 平台订单列表
		 * @return [type] [description]
		 */
		public function index($status)
		{
			if($status == 'all'){
				$where = '';
			}else{
				$where = 'status='.$status;
			}
			// 获取订单数据
			$order_list = Db::name('order')
							->where($where)
							->order('id desc')
							->paginate(20);
			$item = [];
			foreach ($order_list as $val) {
				$item[] = $val;
			}
			if(!empty($item)){
				foreach ($item as &$v) {
					$v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
					$v['pay_name'] = Db::name('pay')
										->where('id',$v['pay_id'])
										->find()['title'];
					$v['pick_up'] = Db::name('pickup')
										->where('id',$v['pickup_id'])
										->find()['pickup_name'];
				}
			}
			return $this->fetch('index',[
									'data' => $order_list,
									'status' => $status,
									'item' => $item,
								]);
		}

	
		/**
		 * 用户订单详情
		 * @param  [type] $id [$id]
		 * @return [type]     [description]
		 */
		public function detailed($id)
		{
			$order = Db::name('order')
					->where('id',$id)
					->find();
			$order['pay_name'] = Db::name('pay')
									->where('id',$order['pay_id'])
									->find()['title'];
			$order['create_time'] = date('Y-m-d H:i:s',$order['create_time']);
			$goods = Db::name('order_goods')
					->where('order_id',$id)
					->select();

	
			return $this->fetch('detailed',['order' => $order,'goods' => $goods]);
		}


		public function action_rev_status()
		{
			$data = Request::instance()->post();
			if(!empty($data['order_id'])){
				foreach ($data['order_id'] as $v) {
					$res = Db::name('order')
							->where('id',$v)
							->update(['status' => $data['status']]);
				}
				$this->success('修改成功！');
			}else{
				$this->error('請選擇訂單！');
			}
		}

		/**
		 * 确定发货
		 * @return [type] [description]
		 */
		public function confirm_deliver()
		{
			$data = Request::instance()->post();
			$rule = [
				['deliver_id','require','请选择物流方式！'],
			    ['express_num','require','快递单号不能为空！'],
			];
			$msg = [
				'deliver_id'  => $data['deliver_id'],
				'express_num'  => $data['express_num'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			if(!$result){
			    $this->error($validate->getError());
			}
			if($data['is_seller'] == 0){
				$order = Db::name('shop_order')
						->field('status')
						->where('id',$data['order_id'])
						->find();
			}else{
				$order = Db::name('seller_order')
						->field('status')
						->where('id',$data['order_id'])
						->find();
			}
			if($order['status'] != 1){
				$this->error('订单已发货！');
				die;
			}

			$new_data = [
				'order_id' => $data['order_id'],
				'express_id' => $data['deliver_id'],
				'express_number' => $data['express_num'],
				'content' => '订单已发货！',
				'express_datetime' => date('Y-m-d H:i:s',time()),
			];
			if($data['is_seller'] == 0){
				$rev = Db::name('shop_order')
						->where('id',$data['order_id'])
						->update(['status' => 2]);
			}else{
				$rev = Db::name('seller_order')
						->where('id',$data['order_id'])
						->update(['status' => 2]);
			}

			if($rev !== false){
				if($data['is_seller'] == 0){
					$res = Db::name('express_info')
							->insert($new_data);
				}else{
					$res = Db::name('seller_expressinfo')
							->insert($new_data);
				}
				if($res){
					$this->success('发货成功！');
				}else{
					$this->error('发货失败！');
				}
			}		
		}

		/**
		 * ajax获取物流信息
		 * @param  [type] $oid    [订单ID]
		 * @return [type]         [description]
		 */
		public function ajax_get_express($oid)
		{
			//查询订单信息
			$seller_id = Db::name('shop_order')
							->field('seller_id')
							->find($oid)['seller_id'];
			if($seller_id == null){
				$uid = 'null';
				$is_seller = 0;
			}else{
				$uid = $seller_id;
				$is_seller = 1;
			}
			
			// 获取物流方式
			$deliver = Db::name('deliver_info')
						->alias('d')
						->join('__EXPRESS__ e','d.express_id = e.id')
						->field('d.id,d.d_mobile,d.d_province,d.d_name,d.d_city,d.d_area,d.d_address,d.d_postcode,e.title')
						->where('d.uid',$uid)
						->where('d.is_seller',$is_seller)
						->select();
			echo json_encode($deliver);
		}

		/**
		 * ajax获取平台物流信息
		 * @param  [type] $oid    [订单ID]
		 * @return [type]         [description]
		 */
		public function ajax_get_seller_express($oid)
		{
			//查询订单信息
			$seller_id = Db::name('seller_order')
							->field('seller_id')
							->find($oid)['seller_id'];
			
			// 获取物流方式
			$deliver = Db::name('deliver_info')
						->alias('d')
						->join('__EXPRESS__ e','d.express_id = e.id')
						->field('d.id,d.d_mobile,d.d_province,d.d_name,d.d_city,d.d_area,d.d_address,d.d_postcode,e.title')
						->where('d.uid',null)
						->where('d.is_seller',0)
						->select();
			echo json_encode($deliver);
		}

		/**
		 * 获取海关待发货物流单号
		 * @return [type] [description]
		 */
		public function get_not_customs_order_list()
		{

			vendor('oms.SvcCall');
		    $svc = new SvcCall(); 
			$order = Db::name('shop_order')
					->field('customs_order_num,id')
					->where('customs_order_num','<>','null')
					->where('customs_logistics_num','null')
					->where('status',1)
					->select();

			if(!empty($order)){
				foreach ($order as $v) {
				    $params = array(
				        'order_code' => $v['customs_order_num'],
				    );
				    $res = $svc->getOrderByCode($params);
				    if($res['ask'] == 'Success'){
				    	if(!empty($res['data'])){
				    		if($res['data']['order_status'] == 'W'){
		    					Db::name('shop_order')
				    				->where('id',$v['id'])
				    				->update(['customs_logistics_num' => $res['data']['tracking_no']]);
				    		}
				    	}
				    }
				}
			    $this->success('获取待发货物流号成功！');
			}else{
				$this->error('暂无待发货的订单！');
			}
		}


			/**
		 * 获取海关发货信息
		 * @return [type] [description]
		 */
		public function get_customs_order_list()
		{

			vendor('oms.SvcCall');
		    $svc = new SvcCall(); 
			$order = Db::name('shop_order')
					->field('customs_order_num,id')
					->where('customs_order_num','<>','null')
					->where('status',10)
					->select();
		
			if(!empty($order)){
				foreach ($order as $v) {
				    $params = array(
				        'order_code' => $v['customs_order_num'],
				    );
				    $res = $svc->getOrderByCode($params);
				    if($res['ask'] == 'Success'){
				    	if(!empty($res['data'])){
				    		if($res['data']['order_status'] == 'D'){
				    			$express = Db::name('express')
				    						->where('english_name',$res['data']['shipping_method'])
				    						->find();
				    			if(!empty($express)){
				    				$data = [
				    					'content' 			=> '订单已发货！',
				    					'express_datetime' 	=> $res['data']['date_shipping'],
				    					'order_id' 			=> $v['id'],
				    					'express_id' 		=> $express['id'],
				    					'express_number' 	=> $res['data']['tracking_no'],
				    				];
				    				$id = Db::name('express_info')
				    						->insert($data);
				    				if($id){
				    					Db::name('shop_order')
						    				->where('id',$v['id'])
						    				->update(['customs_logistics_num' => $res['data']['tracking_no'],'status' => 2]);
				    				}
				    			}else{
				    				$data = [
				    					'content' 			=> '订单已发货！',
				    					'express_datetime' 	=> $res['data']['date_shipping'],
				    					'order_id' 			=> $v['id'],
				    					'express_id' 		=> 1,
				    					'express_number' 	=> $res['data']['tracking_no'],
				    				];
				    				$id = Db::name('express_info')
				    						->insert($data);
				    				if($id){
				    					Db::name('shop_order')
						    				->where('id',$v['id'])
						    				->update(['customs_logistics_num' => $res['data']['tracking_no'],'status' => 2]);
				    				}
				    			}
				    		}
				    	}
				    }
				}
			    $this->success('获取待海关发货信息成功！');
			}else{
				$this->error('暂无待发货的订单！');
			}
		}

		/**
		 * 获取海关发货物流信息
		 * @return [type] [description]
		 */
		public function get_customs_logistics_info()
		{
			$url = 'http://118.178.122.109:8080/appInterface/expressGetInfo.ashx?oid=';
			$order = Db::name('shop_order')
					->field('id')
					->where('status',2)
					->where('customs_order_num','<>','null')
					->select();
			if(!empty($order)){
				foreach ($order as $v) {
					file_get_contents($url.$v['id']);
				}
				$this->success('获取成功！');
			}else{
				$this->error('暂无此订单信息！');
			}

		}
	}
