
/**
 * select发生改变事件
 * @param  {[type]} $self_id [本身id值]
 * @param  {[type]} $id      [需要修改id值]
 * @return {[type]}          [description]
 */
function change_sel($self_id,$id)
{
	// 获取当前值
	var res = $("#"+$self_id).find("option:selected").val();
	// 修改
	$('#'+$id).val(res);
}

/**
 * 是否限购
 * @param  {[type]}  $self_id [本身id值]
 * @param  {[type]}  $id      [需要修改id值]
 * @return {Boolean}          [description]
 */
// function is_limit_buy($self_id,$id)
// {
// 	// 获取当前值
// 	var res = $("#"+$self_id).find("option:selected").val();
// 	if(res == 0){
// 		// 修改
// 		$('#'+$id).val('');
// 		$('#'+$id).attr('disabled',false);
// 	}else{
// 		// 修改
// 		$('#'+$id).val('0');
// 		$('#'+$id).attr('disabled',true);
// 	}
// }