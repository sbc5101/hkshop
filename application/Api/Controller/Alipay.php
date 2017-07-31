<?php

namespace app\api\controller;
use app\api\model\Pay;
error_reporting(0);
class Alipay extends \think\Controller
{

	public function alipay()
	{
		if(request()->isPost()){
			$Pay = new Pay;
			$result = $Pay->alipay([
				'notify_url' => request()->domain().url('index/index/alipay_notify'),
				'return_url' => '',
				'out_trade_no' => input('post.orderid/s','','trim,strip_tags'),
				'subject' => input('post.subject/s','','trim,strip_tags'),
				'total_fee' => input('post.total_fee/f'),//订单金额，单位为元
				'body' => input('post.body/s','','trim,strip_tags'),
			]);
			if(!$result['code']){
				return $this->error($result['msg']);
			}
			return $result['msg'];
		}
		$this->view->orderid = date("YmdHis").rand(100000,999999);
		return $this->fetch();
	}

	public function alipay_notify()
	{
		$Pay = new Pay;
		$result = $Pay->notify_alipay();
		exit($result);
	}
}
