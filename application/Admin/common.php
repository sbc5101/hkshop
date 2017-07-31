<?php 
	use think\Session;
	use think\Db;
	use think\Cache;
	/**
	 * 管理员各权限类型是否存在
	 * @return [type] [description]
	 */
	function rule_count($pid)
	{
		$rule_id = Session::get('user.rule','admin_user');
		$rules = Cache::get('rule_group'.$rule_id);
		if(empty($rules)){
			$rules = Db::name('admin_group_rule')
					->where('id',$rule_id)
					->find()['rules'];
			Cache::set('rule_group'.$rule_id,$rules,3600);
		}

		$rule = Db::name('admin_rule')
					->where('id','in',$rules)
					->where('pid',$pid)
					->find();

		if(!empty($rule)){
			return '1';
		}else{
			return '0';
		}
	
	}

	/**
	 * 是否有该权限
	 * @param  [type]  $str [跳转路径]
	 * @return boolean      [description]
	 */
	function is_rule($str)
	{
		$rule_id = Session::get('user.rule','admin_user');

		$rules = Cache::get('rule_group'.$rule_id);
		if(empty($rules)){
			$rules = Db::name('rule_group')
					->where('id',$rule_id)
					->find()['rules'];
			Cache::set('rule_group'.$rule_id,$rules,3600); 
		}

		$id = Db::name('rule')
					->where('condition',$str)
					->find()['id'];
		$rules = explode(',', $rules);
		if(in_array($id,$rules)){
			return '1';
		}else{
			return '0';
		}
	
	}



 ?>