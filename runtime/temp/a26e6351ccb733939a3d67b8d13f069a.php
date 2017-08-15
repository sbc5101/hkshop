<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:66:"D:\phpStudy\WWW\hkshop/application/admin\view\goods\add_goods.html";i:1502698617;s:64:"D:\phpStudy\WWW\hkshop/application/admin\view\Public\public.html";i:1502701349;}*/ ?>
<!DOCTYPE html>
<html lang="en">

  <head>
  
    <!-- Basic -->
    <meta charset="UTF-8" />
    
	<title>添加商品</title>

    <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    
      <link rel="shortcut icon" href="/favicon.ico" />  
      <!-- start: CSS file-->
    
    <!-- Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/vendor/skycons/css/skycons.css" />
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/vendor/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/vendor/css/pace.preloader.css" />
    
    <!-- Plugins CSS-->
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/plugins/jquery-ui/css/jquery-ui-1.10.4.min.css" />  
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/plugins/scrollbar/css/mCustomScrollbar.css" />
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/plugins/bootkit/css/bootkit.css" />
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/plugins/magnific-popup/css/magnific-popup.css" />
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/plugins/fullcalendar/css/fullcalendar.css" />
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/plugins/jqvmap/jqvmap.css" />
    
    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/css/jquery.mmenu.css" />
    
    <!-- Page CSS -->   
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/css/add-ons.min.css" />
    <link rel="stylesheet" type="text/css" href="/public/admin/assets/css/my.css" />
    
    <!-- end: CSS file--> 
      
    
    <!-- Head Libs -->
    <script type="text/javascript" src="/public/admin/assets/plugins/modernizr/js/modernizr.js"></script>    
      <!-- start: JavaScript-->
    
    <!-- Vendor JS-->       
    <script type="text/javascript" src="/public/admin/assets/vendor/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="/public/admin/assets/vendor/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="/public/admin/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/public/admin/assets/vendor/skycons/js/skycons.js"></script>
    <script type="text/javascript" src="/public/admin/assets/vendor/js/pace.min.js"></script>
    
    <!-- Plugins JS-->
    <script type="text/javascript" src="/public/admin/assets/plugins/jquery-ui/js/jquery-ui-1.10.4.min.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/bootkit/js/bootkit.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/magnific-popup/js/magnific-popup.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/moment/js/moment.min.js"></script>  
    <script type="text/javascript" src="/public/admin/assets/plugins/fullcalendar/js/fullcalendar.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/flot/js/jquery.flot.min.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/flot/js/jquery.flot.pie.min.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/flot/js/jquery.flot.resize.min.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/flot/js/jquery.flot.stack.min.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/flot/js/jquery.flot.time.min.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/flot-tooltip/js/jquery.flot.tooltip.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/chart-master/js/Chart.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/jqvmap/jquery.vmap.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/jqvmap/data/jquery.vmap.sampledata.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/jqvmap/maps/jquery.vmap.world.js"></script>
    <script type="text/javascript" src="/public/admin/assets/plugins/sparkline/js/jquery.sparkline.min.js"></script>
    
    <!-- Theme JS -->   
    <script type="text/javascript" src="/public/admin/assets/js/jquery.mmenu.min.js"></script>
    <script type="text/javascript" src="/public/admin/assets/js/core.min.js"></script>
    
    <!-- Pages JS -->
    
<!--     <script type="text/javascript" src="/public/admin/assets/js/pages/index.js"></script> -->
    
    <!-- end: JavaScript-->
  </head>
  
  <body>
  <?php use think\Session; ?>

    <!-- Start: Header -->
    <div class="navbar" role="navigation">
      <div class="container-fluid container-nav">
        <!-- Navbar Action -->
        <!-- <ul class="nav navbar-nav navbar-actions navbar-left">
          <li class="visible-md visible-lg"><a href="#" id="main-menu-toggle"><i class="fa fa-th-large"></i></a></li>
          <li class="visible-xs visible-sm"><a href="#" id="sidebar-menu"><i class="fa fa-navicon"></i></a></li>      
        </ul>
 -->        <!-- Navbar Left -->
        <div class="navbar-left">
          <!-- Search Form -->          
          <!-- <form class="search navbar-form">
            <div class="input-group input-search">
              <input type="text" class="form-control bk-radius" name="q" id="q" placeholder="搜索...">
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
              </span>
            </div>            
          </form> -->
        </div>
        <!-- Navbar Right -->
        <div class="navbar-right">          
          <!-- End Notifications -->          
          <!-- Userbox -->
          <div class="userbox">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <figure class="profile-picture hidden-xs">
                <img src="/public/admin/assets/img/avatar.jpg" class="img-circle" alt="" />
              </figure>
              <div class="profile-info">
                <span class="name"><?php echo Session::get('user.name','admin_user') ?></span>
                <span class="role"><i class="fa fa-circle bk-fg-success"></i> 管理員</span>
              </div>      
              <i class="fa custom-caret"></i>
            </a>
            <div class="dropdown-menu">
              <ul class="list-unstyled">
                <li class="dropdown-menu-header bk-bg-white bk-margin-top-15">            
                  <div class="progress progress-xs  progress-striped active">
                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                      60%
                    </div>
                  </div>              
                </li> 
          <!--       <li>
                  <a href="page-profile.html"><i class="fa fa-user"></i> 个人中心</a>
                </li> -->
                <li>
                  <a href="<?php echo url('admin/message/index'); ?>"><i class="fa fa-bell"></i> 消&nbsp;息</a>
                </li>
                <li>
                  <a href="<?php echo url('admin/base/loginOut'); ?>"><i class="fa fa-power-off"></i> 退&nbsp;出</a>
                </li>
              </ul>
            </div>            
          </div>
          <!-- End Userbox -->
        </div>
        <!-- End Navbar Right -->
        <div class="profile-info pull-right" style="margin-right: 25px">
          <a style="font-size: 16px;color: #3c3c3c; text-decoration: none;" href="<?php echo url('admin/base/clear_refresh'); ?>"><i class="fa fa-refresh"></i> 刷&nbsp;新</a>
        </div> 
      </div>    
    </div>
    <!-- End: Header -->
    <!-- Start: Content -->
    <div class="container-fluid content"> 
      <div class="row">
      
        <!-- Sidebar -->
        <div class="sidebar">
          <div class="sidebar-collapse">
            <!-- Sidebar Header Logo-->
            <div class="sidebar-header" style="padding: 0 35px;">
              <!-- <img src="/public/admin/assets/img/avatar.jpg" style="width: 150px;height: 62px;" class="img-responsive" alt="" /> -->
            </div>
            <!-- Sidebar Menu-->
            <div class="sidebar-menu">            
              <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-sidebar">
                  <div class="panel-body text-center">                
                    <!-- <div class="flag">
                      <img src="/public/admin/assets/img/flags/USA.png" class="img-flags" alt="" />
                    </div> -->
                  </div>
                  <li class="active">
                    <a href="<?php echo url('admin/index/index'); ?>">
                      <i class="fa fa-home" aria-hidden="true"></i><span>首頁</span>
                    </a>
                  </li>
       <!--            <li>
                    <a href="mailbox-inbox.html">
                      <span class="pull-right label label-danger">235</span>
                      <i class="fa fa-envelope" aria-hidden="true"></i><span>Mail</span>
                    </a>
                  </li>-->   
                  <li class="nav-parent">
                    <a>
                      <i class="fa fa-shopping-cart" aria-hidden="true"></i><span>商品管理</span>
                    </a>
                    <ul class="nav nav-children">
                     <li>
                        <a href="<?php echo url('admin/cates/index'); ?>"><span class="text"> 分類管理</span></a>
                      </li>
                      <li>
                        <a href="<?php echo url('admin/goods/index'); ?>"><span class="text"> 商品管理</span></a>
                      </li>
                      <li>
                        <a href="<?php echo url('admin/goods/area_list'); ?>"><span class="text"> 商品區域</span></a>
                      </li>
                      <li>
                        <a href="<?php echo url('admin/score/score_list'); ?>"><span class="text"> 商品評分管理</span></a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-parent">
                    <a>
                      <i class="fa fa-group" aria-hidden="true"></i><span>會員管理</span>
                    </a>
                    <ul class="nav nav-children">
                      <li>
                        <a href="<?php echo url('admin/member/users'); ?>"><span class="text"> 會員列表</span></a>
                      </li>
                      <li>
                        <a href="<?php echo url('admin/member/add_user'); ?>"><span class="text"> 新增會員</span></a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-parent">
                    <a>
                      <i class="fa fa-cogs" aria-hidden="true"></i><span>商城設置</span>
                    </a>
                    <ul class="nav nav-children">
                      <li>
                        <a href="<?php echo url('admin/advert/carousel_list'); ?>"><span class="text"> 輪播圖管理</span></a>
                      </li>
                    </ul>
                  </li>
                  <!-- <?php  if(rule_count(1) == 1){  ?> -->
                  <li class="nav-parent">
                    <a>
                      <i class="fa fa-shopping-cart" aria-hidden="true"></i><span>商品管理</span>
                    </a>
                    <ul class="nav nav-children">
                     <li>
                        <a href="<?php echo url('admin/cates/index'); ?>"><span class="text"> 分类管理</span></a>
                      </li>
                      <li>
                        <a href="<?php echo url('admin/goods/index'); ?>"><span class="text"> 商品管理</span></a>
                      </li>
                     <!--  <?php  if(is_rule('admin/cates/index') == 1){   }  ?> -->
                    </ul>
                  </li>
                  <!-- <?php  }  ?> -->

                </ul>
              </nav>
            </div>
            <!-- End Sidebar Menu-->
          </div>
          <!-- Sidebar Footer-->
          <div class="sidebar-footer">          
        <!-- 
            <ul class="sidebar-terms bk-margin-top-10">
              <li><a href="#">Terms</a></li>
              <li><a href="#">Privacy</a></li>
              <li><a href="#">Help</a></li>
              <li><a href="#">About</a></li>
            </ul>  -->        
          </div>
          <!-- End Sidebar Footer-->
        </div>
        <!-- End Sidebar -->
            
        <!-- Main Page -->
        <div class="main ">
          <!-- Page Header -->
          <div class="page-header">
            <div class="pull-left">
              <ol class="breadcrumb visible-sm visible-md visible-lg">                
                <li><a href="<?php echo url('admin/index/index'); ?>"><i class="icon fa fa-home"></i>Home</a></li>
                
	<li class="active"><a href="<?php echo url('admin/goods/index'); ?>">商品管理</a></li>
	<li class="active">添加商品</li>

              </ol>           
            </div>
        <!--    <div class="pull-right">
              <h2>Dashboard</h2>
            </div>     -->      
          </div>
          <!-- End Page Header -->
          
          <div class="row">
          
  	<script type="text/javascript" src="/public/kindeditor/kindeditor-all-min.js"></script>
  	<script type="text/javascript" src="/public/kindeditor/lang/zh-CN.js"></script>
  	<script type="text/javascript" src="/public/admin/assets/js/my.js"></script>
	<div class="panel panel-default bk-bg-white col-md-6 col-md-offset-3">
		<div class="panel-heading bk-bg-white">
			<h6><i class="fa fa-indent red"></i>添加商品</h6>							
			<div class="panel-actions">
				<a href="#" class="btn-minimize"><i class="fa fa-caret-up"></i></a>
				<a href="#" class="btn-close"><i class="fa fa-times"></i></a>
			</div>
		</div>
		<div class="panel-body">
			<form action="<?php echo url('admin/goods/action_add_goods'); ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="winetype" value="" id="winetype">
				<div class="form-group">
					<label for="nf-user">商品中文名稱*</label>
					<input type="text" name="hk_title" class="form-control" value="" placeholder="請輸入中文名">
				</div>
				<div class="form-group">
					<label for="nf-user">商品英文名稱*</label>
					<input type="text" name="eng_title" class="form-control" value="" placeholder="請輸入英文名">
				</div>
				<div class="form-group">
					<label for="nf-user">是否上架銷售</label>
					<div >
						<div class="radio-custom radio-inline" style="float:left;">
							<input type="radio" id="status1" name="status" value="0"> 
							<label for="status1"> 是</label>
						</div>
						<div class="radio-custom radio-inline">
							<input type="radio" id="status2" name="status" value="1" checked> 
							<label for="status2"> 否</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="nf-password">商品區域*</label>
					<select id="cate" name="area_id" class="form-control">
						<?php if(is_array($areas_data) || $areas_data instanceof \think\Collection): $i = 0; $__LIST__ = $areas_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<option value="<?php echo $vo['id']; ?>"><?php echo $vo['area_name']; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="nf-password">分類*</label>
					<br>
					<br>
						<?php if(is_array($cates_data) || $cates_data instanceof \think\Collection): $i = 0; $__LIST__ = $cates_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['pid'] == '0'): ?>
							<input type="checkbox" class="one" data_id="<?php echo $vo['id']; ?>" id="cate_id<?php echo $vo['id']; ?>" name="cate_id[]" value="<?php echo $vo['id']; ?>"> 
							<label for="cate_id<?php echo $vo['id']; ?>"><?php echo $vo['cname']; ?></label>
							<?php if(is_array($cates_data) || $cates_data instanceof \think\Collection): $i = 0; $__LIST__ = $cates_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($v['pid'] == $vo['id']): ?>
							<br>
							&nbsp;&nbsp;&nbsp;
							<input class="one<?php echo $vo['id']; ?> second" data_id="<?php echo $v['id']; ?>" data_pid="<?php echo $vo['id']; ?>" type="checkbox" id="second<?php echo $v['id']; ?>" name="cate_id[]" value="<?php echo $v['id']; ?>"> 
							<label for="second<?php echo $v['id']; ?>"><?php echo $v['cname']; ?></label>
							<br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php if(is_array($cates_data) || $cates_data instanceof \think\Collection): $i = 0; $__LIST__ = $cates_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;if($val['pid'] == $v['id']): ?>
							<input class="one<?php echo $vo['id']; ?> second<?php echo $v['id']; ?> three" type="checkbox" id="cate_id<?php echo $val['id']; ?>" data_ppid="<?php echo $vo['id']; ?>" data_pid="<?php echo $v['id']; ?>" name="cate_id[]" value="<?php echo $val['id']; ?>"> 
							<label for="cate_id<?php echo $val['id']; ?>"><?php echo $val['cname']; ?></label>
							<?php endif; endforeach; endif; else: echo "" ;endif; ?>
							<br>
							<?php endif; endforeach; endif; else: echo "" ;endif; ?>
							<br>
							<br>
						<?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</div>
			
				<div class="form-group">
					<label for="nf-user">年份*</label>
					<input type="text" name="years" class="form-control" value="" placeholder="請輸入年份">
				</div>
				<div class="form-group">
					<label for="nf-user">零售價*</label>
					<input type="text" name="marketprice" id="marketprice" class="form-control" value="" placeholder="請輸入零售價">
				</div>
				<div class="form-group">
					<label for="nf-user">市場價*</label>
					<input type="text" name="storeprice" class="form-control" value="" placeholder="請輸入市場價">
				</div>
				<div class="form-group">
					<label for="nf-user">商品貨號*</label>
					<input type="text" name="record_goosnum" class="form-control" value="" placeholder="請輸入商品貨號">
				</div>
				<div class="form-group">
					<label for="nf-user">重量*</label>
					<input type="text" name="weight" class="form-control" value="0" >
				</div>
				<div class="form-group">
					<label for="nf-user">庫存*</label>
					<input type="text" name="stock" class="form-control" value="0">
				</div>
				<div class="form-group">
					<label for="nf-user">商品主圖*</label>
					<input type="file" id="file-input" name="image">
				</div>
				<div class="form-group">
					<label for="nf-user">其他圖片</label>
					<input type="file" id="file-input" multiple name="images[]">
				</div>
				<div class="form-group">
					<label for="nf-user">商品詳細描述*：</label>	
					<textarea  id="container" name="goods_msg" style="width:750px;height:400px;"></textarea>
				</div>
				<div class="form-group">
					<label for="nf-user">是否首頁展示</label>
					<div >
						<div class="radio-custom radio-inline" style="float:left;">
							<input type="radio" id="is_home1" name="is_home" value="0" checked> 
							<label for="is_home1"> 否</label>
						</div>
						<div class="radio-custom radio-inline">
							<input type="radio" id="is_home2" name="is_home" value="1"> 
							<label for="is_home2"> 是</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="nf-password">排序</label>
					<input type="text" maxlength="3" name="sort" class="form-control" value="0">
				</div>
				<button type="submit" class="btn btn-primary col-md-3 pull-right">確認</button>
			</form>
		</div>								
	</div>
	<script>
        var ke;
		KindEditor.ready(function(K) {
			ke=K.create('textarea[id="container"]', {
				filterMode : false,
				uploadJson : '/public/kindeditor/php/upload_json.php',
		        fileManagerJson : '/public/kindeditor/php/file_manager_json.php',
		        imageSizeLimit : '10MB', //批量上传图片单张最大容量
    			imageUploadLimit : 100 ,
		        allowFileManager : true
			});
		});
	</script>
	<script type="text/javascript">
		// 第一级选择
		$('.one').click(function(){
			var is_check = $(this).is(':checked');
			var id =　$(this).attr('data_id');
			if(is_check == false){
				$('.one'+id).removeAttr('checked');
			}
		})

		// 第二级选择
		$('.second').click(function(){
			var is_check = $(this).is(':checked');
			var id =　$(this).attr('data_id');
			var pid =　$(this).attr('data_pid');
			if(is_check == true){
				$('#cate_id'+pid).attr('checked','true');
			}else{
				$('.second'+id).removeAttr('checked');
			}
		})

		// 第三级选择
		$('.three').click(function(){
			var is_check = $(this).is(':checked');
			var id =　$(this).attr('data_id');
			var ppid =　$(this).attr('data_ppid');
			var pid =　$(this).attr('data_pid');
			if(is_check == true){
				$('#second'+pid).attr('checked','true');
				$('#cate_id'+ppid).attr('checked','true');
			}else{
				$('.three'+id).removeAttr('checked');
			}
		})
	</script>

          </div>  

        </div>
        <!-- End Main Page -->
        
        <!-- Footer -->
<!--         <div id="footer">

        </div> -->
        <!-- End Footer -->
      
      </div>
    </div><!--/container-->
    
    
    <div class="clearfix"></div>    
    
    
  
    
  </body>
  
</html>