
/**
 * 添加评分
 */
$('#add_score').click(function(){
  $('#title').html('添加评分');
  $('#score_id').val('');
  $('#url').attr('action','/admin/score/action_add_score.html');
  $('#score_num').val('');
  $('#score_content').val('');
  $('#mechanism').val('');
  $('#links').css('display','block');  
});

/**
 * 修改评分
 */
$('.rev_score').click(function(){
  var id = $(this).attr('score-id');
  var url = '/admin/score/ajax_get_score.html';
  $('#url').attr('action','/admin/score/action_rev_score.html');
  $('#title').html('修改评分');
  $.post(url,{"id":id},function(data){
    if(data.code == 200){
      $('#score_id').val(id);
      $('#score_num').val(data.data.score_num);
      $('#score_content').val(data.data.score_content);
      $('#mechanism').val(data.data.mechanism);
    }
  },'json');
  $('#links').css('display','block');  
});
