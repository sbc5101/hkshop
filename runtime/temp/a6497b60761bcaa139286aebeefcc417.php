<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:66:"D:\phpStudy\WWW\yoshop/application/admin\view\goods\rev_goods.html";i:1488175489;s:64:"D:\phpStudy\WWW\yoshop/application/admin\view\Public\public.html";i:1488347998;}*/ ?>
<!DOCTYPE html>
<html lang="en">

  <head>
  
    <!-- Basic -->
    <meta charset="UTF-8" />
    
	<title>修改商品</title>

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
                
	<li class="active"><a href="<?php echo url('admin/goods/index'); ?>">商品管理</a></li>
	<li class="active">修改商品</li>

              </ol>           
            </div>
        <!--    <div class="pull-right">
              <h2>Dashboard</h2>
            </div>     -->      
          </div>
          <!-- End Page Header -->
          
          <div class="row">
          
  	<script type="text/javascript" src="/public/ueditor/ueditor.config.js"></script>
  	<script type="text/javascript" src="/public/ueditor/ueditor.all.min.js"></script>
  	<script type="text/javascript" src="/public/ueditor/lang/zh-cn/zh-cn.js"></script>
  	<script type="text/javascript" src="/public/admin/assets/js/my.js"></script>
	<div class="panel panel-default bk-bg-white col-md-9 col-md-offset-2">
		<div class="panel-heading bk-bg-white">
			<h6><i class="fa fa-indent red"></i>修改商品</h6>							
			<div class="panel-actions">
				<a href="#" class="btn-minimize"><i class="fa fa-caret-up"></i></a>
				<a href="#" class="btn-close"><i class="fa fa-times"></i></a>
			</div>
		</div>
		<div class="panel-body">
			<form action="<?php echo url('admin/goods/action_rev_goods'); ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="goods_id" value="<?php echo $goods['id']; ?>">
				<div class="form-group">
					<label for="nf-user">商品名称</label>
					<input type="text" name="gname" class="form-control" value="<?php echo $goods['title']; ?>" placeholder="请输入商品名">
				</div>
				<div class="form-group">
					<label for="nf-password">商品类型</label>
					<select name="type" class="form-control">
						<option value="0" selected>跨境商品</option>
						<option value="1">完税商品</option>
						<option value="2">免税商品</option>
					</select>
				</div>
				<div class="form-group">
					<label for="nf-user">是否上架销售</label>
					<div >
						<div class="radio-custom radio-inline" style="float:left;">
							<input type="radio" id="status1" name="status" <?php if($goods['status'] == '0'): ?> checked <?php endif; ?> value="0"> 
							<label for="status1"> 是</label>
						</div>
						<div class="radio-custom radio-inline">
							<input type="radio" id="status2" name="status" value="1" <?php if($goods['status'] == '1'): ?> checked <?php endif; ?>> 
							<label for="status2"> 否</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="nf-password">选择商品区域</label>
					<select name="area_id" class="form-control">
						<?php if(is_array($area) || $area instanceof \think\Collection): $i = 0; $__LIST__ = $area;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<option value="<?php echo $vo['id']; ?>" <?php if($goods['area_id'] == $vo['id']): ?> selected <?php endif; ?>><?php echo $vo['new_path']; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="nf-password">选择分类</label>
					<select name="cate_id" class="form-control">
						<?php if(is_array($cate) || $cate instanceof \think\Collection): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<option value="<?php echo $vo['id']; ?>" <?php if($goods['cate_id'] == $vo['id']): ?> selected <?php endif; ?>><?php echo $vo['new_path']; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="nf-user">年份</label>
					<input type="text" name="years" class="form-control" value="<?php echo $goods['years']; ?>" placeholder="请输入年份">
				</div>
				<div class="form-group">
					<label for="nf-user">基础价</label>
					<input type="text" name="productprice" class="form-control" value="<?php echo $goods['productprice']; ?>" placeholder="元">
				</div>
				<div class="form-group">
					<label for="nf-user">税点</label>
					<input type="text" name="tax_point" class="form-control" value="<?php echo $goods['tax_point']; ?>" placeholder="%">
				</div>
				<div class="form-group">
					<label for="nf-user">零售价</label>
					<input type="text" name="marketprice" class="form-control" value="<?php echo $goods['marketprice']; ?>" placeholder="(基础价+基础价*税点)">
				</div>
				<div class="form-group">
					<label for="nf-user">市场价</label>
					<input type="text" name="storeprice" class="form-control" value="<?php echo $goods['storeprice']; ?>" placeholder="请输入市场价">
				</div>
				<div class="form-group">
					<label for="nf-user">分润配置</label>
					<div >
						<div class="radio-custom radio-inline" style="float:left;">
							<span>省代</span>
							<input style="width:100px;" type="text" name="agentp" class="form-control" value="<?php echo $goods['agentp']; ?>" placeholder="%"> 
						</div>
						<div class="radio-custom radio-inline">
							<span>市代</span>
							<input style="width:100px;" type="text" name="agentc" class="form-control" value="<?php echo $goods['agentc']; ?>" placeholder="%">
						</div>
						<div class="radio-custom radio-inline">
							<span>业务员</span>
							<input style="width:100px;" type="text" name="agentyy" class="form-control" value="<?php echo $goods['agentyy']; ?>" placeholder="%">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="nf-user">备案商品编号</label>
					<input type="text" name="record_num" class="form-control" value="<?php echo $goods['record_num']; ?>" placeholder="请输入备案商品编号">
				</div>
				<div class="form-group">
					<label for="nf-user">商品货号</label>
					<input type="text" name="record_goosnum" class="form-control" value="<?php echo $goods['record_goosnum']; ?>" placeholder="请输入商品货号">
				</div>
				<div class="form-group">
					<label for="nf-user">产地</label>
					<div>
						<div class="radio-custom radio-inline" style="float:left;">
							<select name="origin-sel" onchange="change_sel('origin','origin-txt')" class="form-control" id="origin">
								<option value="">自定义产地</option>
								<option value="法国 波尔多">法国 波尔多</option>
								<option value="智利 卡萨布兰卡山谷">智利 卡萨布兰卡山谷</option>
								<option value="西班牙 佩内德斯">西班牙 佩内德斯</option>
								<option value="德国 莱茵黑森">德国 莱茵黑森</option>
							</select>
						</div>
						<div class="radio-custom radio-inline" style="padding:0;">
							<input type="text" id="origin-txt" name="origin-txt" class="form-control" value="<?php echo $goods['origin']; ?>">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="nf-user">等级</label>
					<div>
						<div class="radio-custom radio-inline" style="float:left;">
							<select name="level-sel" onchange="change_sel('level','level-txt')" class="form-control" id="level">
								<option value="">自定义等级</option>
								<option value="A">A</option>
							</select>
						</div>
						<div class="radio-custom radio-inline" style="padding:0;">
							<input type="text" name="level-txt" id="level-txt" class="form-control" value="<?php echo $goods['level']; ?>">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="nf-user">葡萄品种</label>
					<div>
						<div class="radio-custom radio-inline" style="float:left;">
							<select name="variety-sel" class="form-control" id="variety" onchange="change_sel('variety','variety-txt')">
								<option value="">自定义葡萄品种</option>
								<option value="白葡萄">白葡萄</option>
							</select>
						</div>
						<div class="radio-custom radio-inline" style="padding:0;">
							<input type="text" name="variety-txt" id="variety-txt" class="form-control" value="<?php echo $goods['variety']; ?>">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="nf-user">酒庄</label>
					<div>
						<div class="radio-custom radio-inline" style="float:left;">
							<select name="chateau-sel" class="form-control" id="chateau" onchange="change_sel('chateau','chateau-txt')">
								<option value="">自定义酒庄</option>
								<option value="巴加芙庄园">巴加芙庄园</option>
							</select>
						</div>
						<div class="radio-custom radio-inline" style="padding:0;">
							<input type="text" name="chateau-txt" id="chateau-txt" class="form-control" value="<?php echo $goods['chateau']; ?>">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="nf-user">口感</label>
					<input type="text" name="taste" class="form-control" value="<?php echo $goods['taste']; ?>">
				</div>
				<div class="form-group">
					<label for="nf-user">成分</label>
					<input type="text" name="component" class="form-control" value="<?php echo $goods['component']; ?>">
				</div>
				<div class="form-group">
					<label for="nf-user">保存条件</label>
					<input type="text" name="condition" class="form-control" value="<?php echo $goods['condition']; ?>">
				</div>
				
				<div class="form-group">
					<label for="nf-user">酒精度</label>
					<input type="text" name="alcohol" class="form-control" value="<?php echo $goods['alcohol']; ?>">
				</div>
				<div class="form-group">
					<label for="nf-user">香气</label>
					<input type="text" name="smell" class="form-control" value="<?php echo $goods['smell']; ?>">
				</div>
				<div class="form-group">
					<label for="nf-user">建议醒酒时间</label>
					<input type="text" name="breathing" class="form-control" value="<?php echo $goods['breathing']; ?>">
				</div>
				<div class="form-group">
					<label for="nf-user">重量</label>
					<input type="text" name="weight" class="form-control" value="<?php echo $goods['weight']; ?>" placeholder="克">
				</div>
				<div class="form-group">
					<label for="nf-user">库存</label>
					<input type="text" name="stock" class="form-control" value="<?php echo $goods['stock']; ?>">
				</div>
				<div class="form-group">
					<label for="nf-user">减库存方式</label>
					<div >
						<div class="radio-custom radio-inline" style="float:left;">
							<input type="radio" id="stock-sta1" name="stock_sta" value="0" <?php if($goods['stock_sta'] == '0'): ?> checked <?php endif; ?>> 
							<label for="stock-sta1"> 拍下减库存</label>
						</div>
						<div class="radio-custom radio-inline">
							<input type="radio" id="stock-sta2" name="stock_sta" value="1" <?php if($goods['stock_sta'] == '1'): ?> checked <?php endif; ?>> 
							<label for="stock-sta2"> 永不减库存</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="nf-user">商品属性</label>
					<div>
						<!-- <div class="checkbox-custom checkbox-inline" style="float:left;">
							<input type="checkbox" id="is-new" name="is_new" value="0" <?php if($goods['is_new'] == '0'): ?> checked <?php endif; ?>> 
							<label for="is-new"> 新品</label>
						</div> -->
						<div class="checkbox-custom checkbox-inline" style="float:left;">
							<input type="checkbox" id="is_hot" name="is_hot" value="0" <?php if($goods['is_hot'] == '0'): ?> checked <?php endif; ?>> 
							<label for="is_hot"> 热卖</label>
						</div>
						<div class="checkbox-custom checkbox-inline">
							<input type="checkbox" id="is_home" name="is_home" value="0" <?php if($goods['is_home'] == '0'): ?> checked <?php endif; ?>> 
							<label for="is_home"> 首页推荐</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="nf-user">免运费商品</label>
					<div>
						<div class="checkbox-custom checkbox-inline" style="float:left;">
							<input type="checkbox" id="is-free" name="is_free" value="0" <?php if($goods['is_free'] == '0'): ?> checked <?php endif; ?>> 
							<label for="is-free">
								打勾表示此商品不会产生运费花销，否则按照正常运费计算。
							</label>	
						</div>
					</div>
				</div>
				<br>
				<div class="form-group">
					<label for="nf-user">商品详细描述：</label>	
					<script id="editor" name="goods_msg" type="text/plain" style="width:750px;height:400px;"><?php echo $goods['content']; ?></script>
				</div>
				<div class="form-group">
					<label for="nf-password">排序</label>
					<input type="text" maxlength="3" name="sort" class="form-control" value="<?php echo $goods['sort']; ?>">
				</div>
				<button type="submit" class="btn btn-primary col-md-3 pull-right">确认</button>
			</form>
		</div>								
	</div>
	<script type="text/javascript">
	    //实例化编辑器
	    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	    var ue = UE.getEditor('editor',{
	     toolbars: [
	         ['fullscreen', 'source', 'undo', 'redo'],
	         ['bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc','simpleupload','insertimage']
	     ]
	    });
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