<?php

namespace app\api\model;
use think\Validate;
use vendor\alipay\aop\AopClient;
use vendor\alipay\aop\request\AlipayTradeAppPayRequest;
use vendor\wxpay\WxPay_Api;
use vendor\wxpay\WxPay_NativePay;
use think\Log;
class Pay extends \think\Model
{

	public $alipay_config = [
		'partner_id' 		=> '',//支付宝pid，2088开头数字
		'app_id' 			=> '',//app_id
		'private_key'	 	=> '',//支付宝私钥
		'public_key'	 	=> '',//支付宝公钥
		'charset' 			=> 'utf-8',
		'signType' 			=> 'RSA2',
		'format' 			=> 'JSON',
		
	];
	// public function alipay($data=[])
	// {
	
	// 	$config = self::$alipay_config;
	// 	vendor('alipay.alipay');
	// 	$parameter = [
	// 		"service"       	=> $config['service'],
	// 		"partner"       	=> $config['partner_id'],
	// 		// "seller_id"  		=> $config['seller_id'],
	// 		"payment_type"		=> $config['payment_type'],
	// 		"notify_url"		=> $data['notify_url'],
	// 		"return_url"		=> $data['return_url'],
	// 		"anti_phishing_key"	=> $config['anti_phishing_key'],
	// 		"exter_invoke_ip"	=> $config['exter_invoke_ip'],
	// 		"out_trade_no"		=> $data['out_trade_no'],
	// 		"subject"			=> $data['subject'],
	// 		"total_fee"			=> $data['total_fee'],
	// 		"body"				=> $data['body'],
	// 		"_input_charset"	=> $config['input_charset']
	// 	];
	// 	$alipaySubmit = new \AlipaySubmit($config);
	// 	return ['code'=>1,'msg'=>$alipaySubmit->buildRequestForm($parameter,"get", "确认")];
	// }

	/**
	 * 支付宝支付
	 * @param  array  $data [description]
	 * @return [type]       [description]
	*/
	public function alipay($data=array())
	{	
		$config = $this->alipay_config;
		vendor('alipay.aop.AopClient');

		$aop = new AopClient;
		$aop->appId = $config['app_id'];
		$aop->rsaPrivateKey = $config['private_key'];
		$aop->format = $config['format'];
		$aop->charset = $config['charset'];
		$aop->signType = $config['signType'];
		$aop->alipayrsaPublicKey = $config['public_key'];
		
		//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
		vendor('alipay.aop.request.AlipayTradeAppPayRequest');

		$request = new AlipayTradeAppPayRequest();

		//SDK已经封装掉了公共参数，这里只需要传入业务参数
		$bizcontent = "{\"body\":\"".$data['body']."\","
		                . "\"subject\": \"".$data['subject']."\","
		                . "\"out_trade_no\": \"".$data['out_trade_no']."\","
		                . "\"timeout_express\": \"".$data['timeout_express']."\","
		                . "\"total_amount\": \"".$data['total_amount']."\","
		                . "\"product_code\":\"QUICK_MSECURITY_PAY\""
		                . "}";
		$request->setNotifyUrl(request()->domain().url('api/order/back_alipay'));
		
		$request->setBizContent($bizcontent);

		//这里和普通的接口调用不同，使用的是sdkExecute
		$response = $aop->sdkExecute($request);
		
		return $response;
	}

	// private function _weixin_config(){//微信支付公共配置函数
	// 	define('WXPAY_APPID', "");//微信公众号APPID
	// 	define('WXPAY_MCHID', "");//微信商户号MCHID
	// 	define('WXPAY_KEY', "");//微信商户自定义32位KEY
	// 	define('WXPAY_APPSECRET', "");//微信公众号appsecret
	// 	vendor('wxpay.WxPay_Api');
	// 	vendor('wxpay.WxPay_NativePay');
	// }

	// public function weixin($data=[])
	// {//发起微信支付，如果成功，返回微信支付字符串，否则范围错误信息
	// 	$validate = new Validate([
	// 		['body','require','请输入订单描述'],
	// 		['attach','require','请输入订单标题'],
	// 		['out_trade_no','require|alphaNum','订单编号输入错误|订单编号输入错误'],
	// 		['total_fee','require|number|gt:0','金额输入错误|金额输入错误|金额输入错误'],
	// 		['notify_url','require','异步通知地址不为空'],
	// 		['trade_type','require|in:JSAPI,NATIVE,APP','交易类型错误'],
	// 	]);
	// 	if (!$validate->check($data)) {
	// 		return ['code'=>0,'msg'=>$validate->getError()];
	// 	}
	// 	$this->_weixin_config();
	// 	$notify = new \NativePay();
	// 	$input = new \WxPayUnifiedOrder();
	// 	$input->SetBody($data['body']);
	// 	$input->SetAttach($data['attach']);
	// 	$input->SetOut_trade_no($data['out_trade_no']);
	// 	$input->SetTotal_fee($data['total_fee']);
	// 	$input->SetTime_start($data['time_start']);
	// 	$input->SetTime_expire($data['time_expire']);
	// 	$input->SetGoods_tag($data['goods_tag']);
	// 	$input->SetNotify_url($data['notify_url']);
	// 	$input->SetTrade_type($data['trade_type']);
	// 	$input->Setip($data['spbill_create_ip']);
	// 	$result = $notify->GetPayUrl($input);
	// 	if($result['return_code'] != 'SUCCESS'){
	// 		return ['code'=>0,'msg'=> $result['return_msg']];
	// 	}
	// 	if($result['result_code'] != 'SUCCESS'){
	// 		return ['code'=>0,'msg'=> $result['err_code_des']];
	// 	}
	// 	return ['code'=>1,'msg'=>$result["code_url"]];
	// }

	// public function notify_weixin($data='')
	// {//微信支付异步通知
	// 	if(!$data){
	// 		return false;
	// 	}
	// 	$this->_weixin_config();
 //    	$doc = new \DOMDocument();
	// 	$doc->loadXML($data);
	// 	$out_trade_no = $doc->getElementsByTagName("out_trade_no")->item(0)->nodeValue;
	// 	$transaction_id = $doc->getElementsByTagName("transaction_id")->item(0)->nodeValue;
	// 	$openid = $doc->getElementsByTagName("openid")->item(0)->nodeValue;
	// 	$input = new \WxPayOrderQuery();
	// 	$input->SetTransaction_id($transaction_id);
	// 	$result = \WxPayApi::orderQuery($input);
	// 	if(array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS"){
	// 		// 处理支付成功后的逻辑业务
	// 		Log::init([
	// 			'type'  =>  'File',
	// 			'path'  =>  LOG_PATH.'../paylog/'
	// 		]);
	// 		Log::write($result,'log');
	// 		return 'SUCCESS';
	// 	}
	// 	return false;
	// }



}
?>