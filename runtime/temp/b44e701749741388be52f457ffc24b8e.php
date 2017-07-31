<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:65:"D:\phpStudy\WWW\yoshop/application/admin\view\seller\sellers.html";i:1488353905;s:64:"D:\phpStudy\WWW\yoshop/application/admin\view\Public\public.html";i:1488347998;}*/ ?>
<!DOCTYPE html>
<html lang="en">

  <head>
  
    <!-- Basic -->
    <meta charset="UTF-8" />
    
	<title>商户列表</title>

    <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    
        
    <!-- Favicon and touch icons -->
    <link rel="apple-touch-icon" href="/public/admin/assets/ico/apple-touch-icon.png" />
    
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
    
    <script type="text/javascript" src="/public/admin/assets/js/pages/index.js"></script>
    
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
                <span class="role"><i class="fa fa-circle bk-fg-success"></i> 管理员</span>
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
                  <a href="<?php echo url('admin/base/loginOut'); ?>"><i class="fa fa-power-off"></i> 退出</a>
                </li>
              </ul>
            </div>            
          </div>
          <!-- End Userbox -->
        </div>
        <!-- End Navbar Right -->
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
            <div class="sidebar-header">
              <img src="/public/admin/assets/img/logo.png" class="img-responsive" alt="" />
            </div>
            <!-- Sidebar Menu-->
            <div class="sidebar-menu">            
              <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-sidebar">
                  <div class="panel-body text-center">                
                    <div class="flag">
                      <img src="/public/admin/assets/img/flags/USA.png" class="img-flags" alt="" />
                    </div>
                  </div>
                  <li class="active">
                    <a href="<?php echo url('admin/index/index'); ?>">
                      <i class="fa fa-laptop" aria-hidden="true"></i><span>首页</span>
                    </a>
                  </li>
                  <li>
                    <a href="mailbox-inbox.html">
                      <span class="pull-right label label-danger">235</span>
                      <i class="fa fa-envelope" aria-hidden="true"></i><span>Mail</span>
                    </a>
                  </li>
                  <li class="nav-parent">
                    <a>
                      <i class="fa fa-copy" aria-hidden="true"></i><span>商品管理</span>
                    </a>
                    <ul class="nav nav-children">
                      <li><a href="<?php echo url('admin/cates/index'); ?>"><span class="text"> 分类管理</span></a></li>
                      <li><a href="<?php echo url('admin/goods/index'); ?>"><span class="text"> 商品管理</span></a></li>
                      <li><a href="<?php echo url('admin/goods/goods_recycle'); ?>"><span class="text"> 商品回收站</span></a></li>
                    </ul>
                  </li>
                  <li class="nav-parent">
                    <a>
                      <i class="fa fa-copy" aria-hidden="true"></i><span>活动管理</span>
                    </a>
                    <ul class="nav nav-children">
                      <li><a href="<?php echo url('admin/activity/time_limit'); ?>"><span class="text"> 限时抢购</span></a></li>
                      <li><a href="<?php echo url('admin/activity/festival'); ?>"><span class="text"> 节日促销</span></a></li>
                      <li><a href="<?php echo url('admin/activity/new_recommend'); ?>"><span class="text"> 新品推荐</span></a></li>
                   <!--    <li><a href="<?php echo url('admin/activity/festival'); ?>"><span class="text"> 团购商品</span></a></li> -->
                    </ul>
                  </li>
                  <li class="nav-parent">
                    <a>
                      <i class="fa fa-copy" aria-hidden="true"></i><span>会员管理</span>
                    </a>
                    <ul class="nav nav-children">
                      <li><a href="<?php echo url('admin/member/users'); ?>"><span class="text"> 会员列表</span></a></li>
                      <li><a href="<?php echo url('admin/member/add_user'); ?>"><span class="text"> 新增会员</span></a></li>
                    </ul>
                  </li>
                  <li class="nav-parent">
                    <a>
                      <i class="fa fa-copy" aria-hidden="true"></i><span>商户管理</span>
                    </a>
                    <ul class="nav nav-children">
                      <li><a href="<?php echo url('admin/seller/sellers'); ?>"><span class="text"> 商户列表</span></a></li>
                      <li><a href="<?php echo url('admin/seller/add_seller'); ?>"><span class="text"> 新增商户</span></a></li>
                      <li><a href="<?php echo url('admin/member/shops'); ?>"><span class="text"> 店铺管理</span></a></li>
                    </ul>
                  </li>
                  <li class="nav-parent">
                    <a>
                      <i class="fa fa-copy" aria-hidden="true"></i><span>权限管理</span>
                    </a>
                    <ul class="nav nav-children">
                      <li><a href="<?php echo url('admin/power/users'); ?>"><span class="text"> 管理员列表</span></a></li>
                      <li><a href="<?php echo url('admin/power/add_user'); ?>"><span class="text"> 新增用户</span></a></li>
                    </ul>
                  </li>
                  <li class="nav-parent">
                    <a>
                      <i class="fa fa-copy" aria-hidden="true"></i><span>系统管理</span>
                    </a>  
                    <ul class="nav nav-children">
                      <li><a href="<?php echo url('admin/advert/carousel'); ?>"><span class="text"> 广告管理</span></a></li>
                      <li><a href="<?php echo url('admin/areas/index'); ?>"><span class="text"> 区域管理</span></a></li>
                      <!-- <li><a href="<?php echo url('admin/power/add_user'); ?>"><span class="text"> 新增用户</span></a></li> -->
                    </ul>
                  </li>
                  <li class="nav-parent">
                    <a>
                      <i class="fa fa-copy" aria-hidden="true"></i><span>插件管理</span>
                    </a>  
                    <ul class="nav nav-children">
                      <li><a href="<?php echo url('admin/setpay/index'); ?>"><span class="text"> 支付管理</span></a></li>
                      <!-- <li><a href="<?php echo url('admin/areas/index'); ?>"><span class="text"> 区域管理</span></a></li> -->
                      <!-- <li><a href="<?php echo url('admin/power/add_user'); ?>"><span class="text"> 新增用户</span></a></li> -->
                    </ul>
                  </li>
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
                
	<li class="active">商户管理</li>
	<li class="active">商户列表</li>

              </ol>           
            </div>
        <!--    <div class="pull-right">
              <h2>Dashboard</h2>
            </div>     -->      
          </div>
          <!-- End Page Header -->
          
          <div class="row">
          
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default bk-bg-white">
			<div class="panel-heading bk-bg-white">
				<h6><i class="fa fa-table red"></i><span class="break"></span>商户列表</h6>							
				<div class="panel-actions">
					<a href="#" class="btn-minimize"><i class="fa fa-caret-up"></i></a>
					<a href="#" class="btn-close"><i class="fa fa-times"></i></a>
				</div>
			</div>
			<div class="panel-body">
				
					<div class="col-sm-12 col-md-6 pull-right">
					<div id="datatable-editable_filter" class="dataTables_filter pull-right">
					<form action="<?php echo url('admin/seller/sellers'); ?>" method="get">
						<label>
							<input type="text" name="user_name" class="form-control" placeholder="按用户名搜索">
						</label>
						<button type="submit" class="btn btn-success">确定</button>
					</form>
					</div>
					</div><div class="table-responsive"><table class="table table-bordered table-striped mb-none dataTable no-footer" id="datatable-editable" role="grid" aria-describedby="datatable-editable_info">
					<thead>
						<tr role="row">
							<th>用户名</th>
							<th>真实名称</th>
							<th>座机</th>
							<th>移动电话</th>
							<th>状态</th>
							<th>注册时间</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($data) || $data instanceof \think\Collection): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "<tr><td colspan='8' align='center'>暂无数据</td></tr>" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<tr class="gradeA odd" role="row">
							<td><?php echo $vo['seller_name']; ?></td>
							<td><?php echo $vo['true_name']; ?></td>
							<td><?php echo $vo['phone']; ?></td>
							<td><?php echo $vo['mobile']; ?></td>
							<td>
								<?php if($vo['is_lock'] == '0'): ?>
									<span class="label label-success">正常</span>
									<?php else: ?>
									<span class="label label-danger">锁定</span>
								<?php endif; ?>
							</td>
							<td><?php echo $vo['create_time']; ?></td>
							<td class="actions">
								<a href="<?php echo url('admin/seller/rev_seller',['id' => $vo['id']]); ?>" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
								<a href="<?php echo url('admin/seller/action_del_vo',['id' => $vo['id']]); ?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
							</td>
						</tr>
						<?php endforeach; endif; else: echo "<tr><td colspan='8' align='center'>暂无数据</td></tr>" ;endif; ?>
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