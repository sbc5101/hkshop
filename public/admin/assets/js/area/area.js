
/**
 * 地区三级联动
 * @param  {[type]} $url    [ajax请求地址]
 * @param  {[type]} $selfid [本身元素id值]
 * @param  {[type]} $id     [变动元素id值]
 * @param  {[type]} $status [状态 0 城市 1 地区]
 * @return {[type]}         [description]
 */
function areaChange($url,$selfid,$id,$status)
{
	// 清空原有信息
	if($status == 0){
		$('#'+$id).next().html('<option>请选择</option>');
	}
	var id = $('#'+$selfid).val();

	var elements = '';
	$.post($url,{"id":id,'status':$status},function(data){
		if(data){
			for (var i = 0; i < data.length; i++) {
				elements += '<option value='+data[i][$id+'id']+'>'+data[i][$id]+'</option>';
			}
			$('#'+$id).html('<option>请选择</option>'+elements);
		}
	},'json')
}
