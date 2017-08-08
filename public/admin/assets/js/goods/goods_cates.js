
/**
 * 添加子类
 */
$('.add_child').live('click',function(){
  var id = $(this).attr('data-id');
  var name = $(this).attr('data-name');
  $('#parent_id').val(id);
  $('#parent_name').val(name);
  $('#child_name').val('');
  $('#child_state').find("option[value = 0]").attr("selected","selected");
  $('#child_sort').val('0');
  $('#children').css('display','block');  
});

/**
 * 添加子类动作
 */
$('#add_child').click(function(){
  var url = "/admin/cates/action_add_child_cate.html";
  var id = $('#parent_id').val();
  var cname = $('#child_name').val();
  var display = $('#child_state').val();
  var sort = $('#child_sort').val();

  if(cname == ''){
    alert('分类名称不能为空！');
    return false;
  }

  $.post(url,{'pid':id,'cname':cname,'display':display,'sort':sort},function(data){
      if(data.code == 400){
        alert(data.message);
        return false;
      }else{
        var data = data.data;
        var display = '';
        if(data.display == 0){
          display = '<span class="label label-success">显示</span>';
        }else{
          display = '<span class="label label-warning">隐藏</span>';
        }
        var str = '<tr id="cate'+data.id+'" data-tt-id="'+data.id+'"  data-tt-parent-id="'+data.pid+'"><td></td><td>'+data.cname+'</td><td>'+display+'</td><td><a class="add_child btn btn-success" href="javascript:void(0);" data-id="'+data.id+'" data-name="'+data.cname+'"><i class="fa fa-plus "></i> 添加子类</a> <a class="btn btn-info" href="javascript:void(0);" data-id="'+data.id+'"><i class="fa fa-edit "></i> 修改</a> <a class="action_del_cate btn btn-danger" href="javascript:void(0);" data-id="'+data.id+'"><i class="fa fa-trash-o "></i> 删除</a></td></tr>';
        $('#cate'+data.pid).after(str);
        $('#children').css('display','none');  
      }
  },'json');
});
$('.action_del_cate').live('click',function(){
  if(!confirm('确认删除？')){
    return false;
  }
  var url = '/admin/cates/action_del_cate.html';
  var id = $(this).attr('data-id');
  var my = $(this);
  $.post(url,{'id':id},function(data){
      if(data.code == 400){
        alert(data.message);
        return false;
      }else{
        my.parent().parent().remove();
      }
  },'json');
})

/**
 * 修改分类操作
 */
$('.rev_cate').live('click',function(){
  var id = $(this).attr('data-id');
  var url = '/admin/cates/rev_cate.html';
  $.get(url,{"id":id},function(data){
    if(data.code == 200){
      var message = data.data;
      $('#rev_cate_id').val(id);
      $('#rev_name').val(message.cname);
      $('#rev_state').find("option[value = "+message.display+"]").attr("selected","selected");
      $('#rev_sort').val(message.sort);
    }
  },'json');
  $('#revcate').css('display','block');  
});

$('#rev_cate').click(function(){
  var id = $('#rev_cate_id').val();
  var cname = $('#rev_name').val();
  var display = $('#rev_state').val();
  var sort = $('#rev_sort').val();
  var url = '/admin/cates/action_rev_cate.html';
  $.post(url,{"id":id,"cname":cname,"display":display,"sort":sort},function(data){
    if(data.code == 200){
      var message = data.data;
      if(display == 0){
        var str = '<span class="label label-success">显示</span>';
      }else{
        var str = '<span class="label label-warning">隐藏</span>';
      }
      $('#cate'+id).children("td:first").next().html(cname);
      $('#cate'+id).children("td:first").next().next().html(str);
      $('#revcate').css('display','none');
    }else{
      alert(data.message);
    }
  },'json');
})