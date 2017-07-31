<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:65:"D:\phpStudy\WWW\hkshop/application/admin\view\cates\rev_cate.html";i:1498615335;s:64:"D:\phpStudy\WWW\hkshop/application/admin\view\Public\public.html";i:1500953573;}*/ ?>
<!DOCTYPE html>
<html lang="en">

  <head>
  
    <!-- Basic -->
    <meta charset="UTF-8" />
    
	<title>修改分类</title>

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
    
    <!-- <script type="text/javascript" src="/public/admin/assets/js/pages/index.js"></script> -->
    
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
                      <i class="fa fa-home" aria-hidden="true"></i><span>首页</span>
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
                        <a href="<?php echo url('admin/cates/index'); ?>"><span class="text"> 分类管理</span></a>
                      </li>
                      <li>
                        <a href="<?php echo url('admin/goods/index'); ?>"><span class="text"> 商品管理</span></a>
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
                
	<li class="active">分类管理</li>
	<li class="active">修改分类</li>

              </ol>           
            </div>
        <!--    <div class="pull-right">
              <h2>Dashboard</h2>
            </div>     -->      
          </div>
          <!-- End Page Header -->
          
          <div class="row">
          
	<div class="panel panel-default bk-bg-white col-md-6 col-md-offset-3">
		<div class="panel-heading bk-bg-white">
			<h6><i class="fa fa-indent red"></i>修改分类</h6>							
			<div class="panel-actions">
				<a href="#" class="btn-minimize"><i class="fa fa-caret-up"></i></a>
				<a href="#" class="btn-close"><i class="fa fa-times"></i></a>
			</div>
		</div>
		<div class="panel-body">
			<form action="<?php echo url('admin/cates/action_rev_cate'); ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $data['id']; ?>">
				<div class="form-group">
					<label for="nf-user">分类名</label>
					<input type="text" id="nf-user" name="cname" value="<?php echo $data['cname']; ?>" class="form-control">
				</div>
				<div class="form-group">
					<label for="nf-password">排序</label>
					<input type="text" name="sort" value="<?php echo $data['sort']; ?>" class="form-control" maxlength="3">
				</div>
				<div class="form-group">
					<label for="nf-password">图片</label>
					<input type="file" id="file-input" name="file">
				</div>
				<div class="form-group">
					<select class="form-control" name="display">
						<option value="0" <?php if($data['display'] == '0'): ?> selected <?php endif; ?>>显示</option>
						<option value="1" <?php if($data['display'] == '1'): ?> selected <?php endif; ?>>隐藏</option>
					</select>
				</div>
				
				<button type="submit" class="btn btn-primary col-md-3 pull-right">确认</button>
			</form>
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