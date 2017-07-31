<?php

	namespace app\api\model;
	use think\Validate;
    use think\Log;
	use think\Db;
	class Express extends \think\Model
	{

        /**
         * 立即送
         * @param  [type] $order  [订单信息]
         * @param  [type] $shop   [商铺信息]
         * @param  [type] $status [请求地址]
         * @return [type]         [description]
         */
        public function immediately($order,$shop,$status=true)
        {
            $data = Db::name('config_immediately')
                    ->find();

            $userName = $data['user_name']; // 商户账号 人人快递提供
            $appKey = $data['app_key']; // appKey 人人快递提供
            $timeStamp = date ( 'Y-m-d' ); // 时间 加入请求头用以校验 【非常重要】
            if($status == true){
                $interfaceUrl = $data['price_url']; // 下单接口地址【测试环境】
            }else{
                $interfaceUrl = $data['order_url']; // 下单接口地址【测试环境】
            }
            $startingAddress = $shop['address']; // 发货地
            $consigneeAddress = $order['address_address']; // 收货地

            $sign = strtolower ( md5 ( $appKey . md5 ( $timeStamp ) . strtolower ( md5 ( $userName . $startingAddress . $consigneeAddress ) ) ) ); // 下单接口sign值生成规则请参加文档

            $postData = [  // 参数含义参见文档
                    'userName' => $userName,
                    'goodsName' => '都市贵族红酒',
                    'goodsWeight' => ceil($order['total_weight'] / 1000),
                    'goodsWorth' => floor($order['price']),
                    // 'startingLng' => 104.05759,
                    // 'startingLat' => 30.62921,
                    // 'consigneeLng' => 104.065886,
                    // 'consigneeLat' => 30.640848,
                    // 'mapFrom' => 1,
                    'startingProvince' => $shop['province'],
                    'startingCity' => $shop['city'],
                    'startingAddress' => $startingAddress,
                    'startingPhone' => $shop['phone'],
                    'startingName' => $shop['name'],
                    'consigneeName' => $order['username'],
                    'consigneePhone' => $order['address_mobile'],
                    'callbackUrl' => 'http://xxxx.com',
                    'consigneeProvince' => $order['address_province'],
                    'consigneeCity' => $order['address_city'],
                    'consigneeAddress' => $consigneeAddress,
                    'businessNo' => $order['order_num'], // 商家方订单号
                    'dispatchers' => '',
                    'payType' => 4,//支付方式
                    'serviceFees' => 0,
                    'remark' => '这是备注',
                    'sign' => $sign,
                    'version' => 2.0 
            ];
            
            $header [] = "Content-Type: application/json"; // 指定请求头为application/json 【非常重要】
            $header [] = "timestamp:" . $timeStamp; // 【非常重要】

            $result = $this->curlPost($interfaceUrl, json_encode($postData),10,$header);
            if (! empty ( $result )) {
                $res = json_decode ( $result, true );
                if($res['status'] == 1){
                    $res['price'] = $res['price'] + $data['price'];
                }
                return $res;
             
            }
        }
        /**
         * curl POST
         * 
         */
        public function curlPost($url, $post_data = array(), $timeout = 15, $header = array(), $post_File = false) {
            $post_string = null;
            if (is_array ( $post_data ) && ! $post_File) {
                $post_string = http_build_query ( $post_data );
            } else {
                $post_string = $post_data;
            }

            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_string );
            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
            curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header ); // 模拟的header头
            $result = curl_exec ( $ch );
            curl_close ( $ch );
            return $result;
        }
		
    }



?>