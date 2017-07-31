<?php 
		/**
	* @Author: Yoshop
	* 商品管理类
	* @Date:   2016-1-2 15:38:14
	* @Last Modified time: 2016-1-2 16:20:06
	*/

	namespace app\Api\controller;

	use app\Api\controller\Base;
	use think\Validate;
	use think\Db;
	use think\Request;

	class Api extends Base
	{

		public function wine_seeking()
		{
			header("Access-Control-Allow-Origin:*");
			$data = Request::instance()->post();

			// 判断数据不能为空
			$rule = [
				['cname','require','商品中文名不能为空'],
				['ename','require|alphaDash','商品英文名不能为空|商品英文名必须为英文'],
				['years','require','商品年份不能为空'],
				['num','require','商品数量不能为空'],
				['real_name','require','用户名不能为空'],
				['mobile','require|/^1[34578]\d{9}$/','手机号不能为空|请输入正确的手机号'],
			   
			];
			$msg = [
				'cname'  	=> $data['goods_cnName'],
				'ename'  	=> $data['goods_enName'],
				'years'  	=> $data['goods_years'],
				'num'		=> $data['goods_accounts'],
				'real_name' => $data['userName'],
				'mobile'  	=> $data['telephone'],
				'wx_num'  	=> $data['weChat_num'],
			];

			$validate = new Validate($rule);
			$result   = $validate->check($msg);

			if(!$result){
			    return json(['data'=>$validate->getError(),'code'=>400,'message'=>'数据错误']);
			}
			
			
			$res = Db::name('wine_seeking')
					->insert($msg);
	
			if($res){
				return json(['data'=>'填写成功','code'=>200,'message'=>'操作成功']);
			}else{
				return json(['data'=>'填写失败','code'=>400,'message'=>'数据错误']);
			}
		}

	}






 ?>