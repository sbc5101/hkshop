<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"D:\phpStudy\WWW\yoshop/application/erp\view\index\index.html";i:1498615338;s:62:"D:\phpStudy\WWW\yoshop/application/erp\view\Public\public.html";i:1498702855;}*/ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Basic -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="shortcut icon" href="/favicon.ico" />  
    
	<title>首页</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/public/erp/static/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/public/erp/static/css/site.css" />
 
    <link rel="stylesheet" type="text/css" href="/public/erp/static/css/fullcalendar.css" />
    <link rel="stylesheet" type="text/css" href="/public/erp/static/css/jquery.cleditor.css" />
    <link rel="stylesheet" type="text/css" href="/public/erp/static/css/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="/public/erp/static/css/prettyPhoto.css" />
    <link rel="stylesheet" type="text/css" href="/public/erp/static/css/rateit.css" />
    <link rel="stylesheet" type="text/css" href="/public/erp/static/css/widgets.css" />
    <link rel="stylesheet" type="text/css" href="/public/erp/static/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/public/erp/static/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/public/erp/static/css/font-awesome-4.4.0/css/font-awesome.min.css" />
    

    <!-- JS -->
    <script type="text/javascript" src="/public/erp/static/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/fullcalendar.min.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/jquery.prettyPhoto.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/excanvas.min.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/jquery.flot.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/jquery.flot.resize.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/jquery.flot.pie.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/jquery.noty.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/themes/default.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/layouts/bottom.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/layouts/topRight.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/layouts/top.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/sparklines.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/jquery.cleditor.min.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/bootstrap-switch.min.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/filter.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/custom.js"></script>
    <script type="text/javascript" src="/public/erp/static/js/charts.js"></script>
  </head>

  <body>
    <?php use think\Session; ?>
      <div class="wrap" style="margin-top: 30px;">
        <div class="navbar navbar-fixed-top bs-docs-nav" role="banner">
            <div class="conjtainer">
              <!-- Menu button for smallar screens -->
              <div class="navbar-header">
                  <button class="navbar-toggle btn-navbar" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                    <span>菜单</span>
                  </button>
                  <!-- Site name for smallar screens -->
                  <a href="index.html" class="navbar-brand hidden-lg">首页</a>
                </div>
              
              

              <!-- Navigation starts -->
              <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">         
                <div class="col-md-4">
                  <!-- Logo. -->
                  <div class="logo">
                    <h1><a href="#">都市贵族<span class="bold"></span></a></h1>
                    <p class="meta">ERP系统</p>
                  </div>
                  <!-- Logo ends -->
                </div>
                <!-- Search form -->
      <!--           <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                </form>
                -->
                <!-- Links -->
                <ul class="nav navbar-nav pull-right">
                  <li class="dropdown pull-right">            
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                      <i class="icon-user"></i> <?php echo Session::get('erp.id','erp_users') ?> <b class="caret"></b>              
                    </a>
                    
                    <!-- Dropdown menu -->
                    <ul class="dropdown-menu">
                      <li><a href="#"><i class="icon-user"></i> 资料</a></li>
                      <li><a href="#"><i class="icon-cogs"></i> 设置</a></li>
                      <li>
                        <a href=""><i class="icon-off"></i> 退出</a>
                    </li>
                    </ul>
                  </li>
                </ul>
                <ul class="nav navbar-nav pull-right">
                  <!-- Comment button with number of latest comments count -->
                  <li class="dropdown dropdown-big">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                      <i class="icon-bell-alt"></i> 警报 <span   class="label label-info">6</span> 
                    </a>

                      <ul class="dropdown-menu">
                        <li>
                          <!-- Heading - h5 -->
                          <h5><i class="icon-comments"></i> 聊天</h5>
                          <!-- Use hr tag to add border -->
                          <hr />
                        </li>              
                        <li>
                          <div class="drop-foot">
                            <a href="#">查看所有</a>
                          </div>
                        </li>                                    
                      </ul>
                  </li>

                </ul>
              </nav>

            </div>
          </div>
        <!-- Header ends -->

        <!-- Main content starts -->

        <div class="content">

            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar-dropdown"><a href="#">导航</a></div>

                <!--- Sidebar navigation -->
                <!-- If the main navigation has sub navigation, then add the class "has_sub" to "li" of main navigation. -->
                <ul id="nav">
                  <!-- Main menu with font awesome icon -->
                  <li><a href="#" class="open"><i class="icon-home"></i> 首页</a>
                  </li>
                  <li class="has_sub"><a href="#"><i class="icon-list-alt"></i> 插件页面  <span class="pull-right"><i class="icon-chevron-right"></i></span></a>
                    <ul>
                      <li><a href="widgets1.html">插件页面 #1</a></li>
                      <li><a href="widgets2.html">插件页面 #2</a></li>
                      <li><a href="widgets3.html">插件页面 #3</a></li>
                    </ul>
                  </li>  
                  <li><a href="charts.html"><i class="icon-bar-chart"></i>图表</a></li> 
                </ul>
            </div>
            <!-- Sidebar ends -->
        </div>
        <div class="container">
           

           
        </div>
    </div>
    
  </body>
  
</html>