<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"D:\phpStudy\WWW\hkshop/application/admin\view\goods\index.html";i:1502698771;s:64:"D:\phpStudy\WWW\hkshop/application/admin\view\Public\public.html";i:1502701349;}*/ ?>
<!DOCTYPE html>
<html lang="en">

  <head>
  
    <!-- Basic -->
    <meta charset="UTF-8" />
    
	<title>商品列表</title>

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
                
	<li class="active">商品管理</li>
	<li class="active">商品列表</li>

              </ol>           
            </div>
        <!--    <div class="pull-right">
              <h2>Dashboard</h2>
            </div>     -->      
          </div>
          <!-- End Page Header -->
          
          <div class="row">
          
	<div class="col-lg-12">
		<div class="panel panel-default bk-bg-white">
			<div class="panel-heading bk-bg-white">
				<h6><i class="fa fa-table"></i><span class="break"></span>商品管理</h6>
				<div class="panel-actions">
					<a href="#" class="btn-minimize"><i class="fa fa-caret-up"></i></a>
					<a href="#" class="btn-close"><i class="fa fa-times"></i></a>
				</div>
			</div>
			<!-- <div class=" pull-left">
				<form action="<?php echo url('goods/index'); ?>" method="get" style="margin: 10px 0 0 15px;">
					<label>
						<input type="text" name="title" class="form-control" value="" placeholder="按商品名搜索">
					</label>
					<button type="submit" class="btn btn-success">确定</button>
				</form>
			</div> -->
			<!-- &nbsp; -->
			<div class=" pull-left">
				<form action="<?php echo url('goods/index'); ?>" method="get" style="margin: 10px 0 0 15px;">
					<label>商品狀態：</label>
					<label>
						<select name="status" class="form-control">
							<option value="" <?php if($status == ''): ?> selected <?php endif; ?>>請選擇</option>
							<option value="0" <?php if($status == '0'): ?> selected <?php endif; ?>>上架</option>
							<option value="1" <?php if($status == '1'): ?> selected <?php endif; ?>>下架</option>
						</select>
					</label>
					<button type="submit" class="btn btn-success">確定</button>
				</form>
			</div>
			<div class="col-md-1 pull-left" style="margin:10px 0 0 20px;">
				<a class="btn btn-info" href="<?php echo url('admin/goods/index'); ?>">
					顯示所有                                           
				</a>
			</div>
			<div class="col-md-1 pull-right" style="margin:10px 0;">
				<a class="btn btn-success" href="<?php echo url('admin/goods/add_goods'); ?>">
					<i class="fa fa-plus"></i> 添加商品                                           
				</a>
			</div>
			<div class="panel-body">
				<div class="table-responsive">	
					<table class="table table-striped table-bordered bootstrap-datatable datatable">
						<thead>
							<tr>
								<th>序號</th>
								<th>中文名稱</th>
								<th>英文名稱</th>
								<th>年份</th>
								<th>零售價</th>
								<th>市場價</th>
								<th>庫存</th>
								<th>銷量</th>
								<th>狀態</th>
								<th>操作</th>
							</tr>
						</thead>   
						<tbody>
							<?php if(is_array($data) || $data instanceof \think\Collection): $k = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "<tr><td colspan='10' align='center'>暫無數據</td></tr>" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
							<tr class="gradeA odd" role="row">
								<td class="actions"><?php echo $k; ?></td>
								<td class="actions"><?php echo $vo['hk_title']; ?></td>
								<td class="actions"><?php echo $vo['eng_title']; ?></td>
								<td class="actions"><?php echo $vo['years']; ?></td>
								<td class="actions"><?php echo $vo['marketprice']; ?></td>
								<td class="actions"><?php echo $vo['storeprice']; ?></td>
								<td class="actions"><?php echo $vo['stock']; ?></td>
								<td class="actions"><?php echo $vo['sale_number']; ?></td>
								<td>
									<?php if($vo['status'] == '0'): ?>
									<span class="label label-success">上架</span>
									<?php else: ?>
									<span class="label label-danger">下架</span>
									<?php endif; ?>
								</td>
								<td class="actions">
									<a href="<?php echo url('admin/goods/rev_goods',['id' => $vo['id']]); ?>?status=<?php echo $status; ?>&page=<?php echo $page; ?>" class="on-default edit-row" title="修改"><i class="fa fa-pencil"></i></a>
									<a href="<?php echo url('admin/goods/rev_images',['id' => $vo['id']]); ?>?status=<?php echo $status; ?>&page=<?php echo $page; ?>" class="on-default remove-row" title="圖片管理"><i class="fa fa-picture-o"></i></a>
									<a href="<?php echo url('admin/goods/action_rev_del',['id' => $vo['id'],'status' => '1']); ?>" class="on-default remove-row" title="删除" onclick="return confirm('確認删除？');return false;"><i class="fa fa-trash-o"></i></a>
								</td>
							</tr>
							<?php endforeach; endif; else: echo "<tr><td colspan='10' align='center'>暫無數據</td></tr>" ;endif; ?>
						</tbody>
					</table>
				</div>
				<div class="row datatables-footer">
					<div class="col-sm-12 col-md-6 col-md-offset-4">
						<div class="dataTables_paginate paging_bs_normal" id="datatable-editable_paginate">
							<?php echo $data->render(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

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