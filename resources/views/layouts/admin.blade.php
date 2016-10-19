<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Fifish - 后台管理</title>

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/AdminLTE.min.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/bootstrap.plugins.min.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/admin.css') }}" rel="stylesheet">
    
    @yield('partial_css')
    
    <style>
        @yield('customize_css')
    </style>
</head>
<body class="skin-blue sidebar-mini">
    <header class="main-header">
        <a href="../../index2.html" class="logo">
            <span class="logo-mini">
                Fifish
            </span>
            <span class="logo-lg">
                Fifish Admin
            </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <a class="sidebar-toggle" role="button" data-toggle="offcanvas" href="#">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">1</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 1 messages</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="http://s3.qysea.com/img/avatar!smx50.png" class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                Sender Name<small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <p>Message Excerpt</p>
                                        </a>
                                    </li><!-- end message -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">See All Messages</a>
                            </li>
                        </ul>
                    </li>
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">1</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 1 notifications</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="ion ion-ios-people info"></i> Notification title
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all</a>
                            </li>
                        </ul>
                    </li>
                    <!-- Tasks: style can be found in dropdown.less -->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">2</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 2 tasks</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Design some buttons <small class="pull-right">20%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li><!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ Auth::user()->avatar->small }}" class="user-image">
                            <span class="hidden-xs">{{ Auth::user()->username }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ Auth::user()->avatar->small }}" class="img-circle" alt="User Image">
                                <p>
                                    {{ Auth::user()->username }} <small>Member since Nov. 2012</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="/auth/logout" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    
    <aside class="main-sidebar">
        <!-- Inner sidebar -->
        <section class="sidebar" style="height: auto;">
            <!-- Search Form (Optional) -->
            <form action="#" method="get" class="sidebar-form">
                  <div class="input-group">
                      <input type="text" name="q" class="form-control" placeholder="Search...">
                      <span class="input-group-btn">
                          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                      </span>
                  </div>
            </form><!-- /.sidebar-form -->

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">Menu</li>
                <!-- Optionally, you can add icons to the links -->
                <li class="{{ $sitebar_menu_overview or '' }}">
                    <a href="/admin">
                        <i class="fa fa-dashboard" aria-hidden="true"></i> <span>概况</span>
                    </a>
                </li>
                <li class="{{ $sitebar_menu_stuff or '' }}">
                    <a href="/admin/stuffs">
                        <i class="fa fa-photo" aria-hidden="true"></i> <span>分享管理</span>
                    </a>
                </li>
                <li class="{{ $sitebar_menu_columns or '' }}">
                    <a href="/admin/columns">
                        <i class="fa fa-cubes" aria-hidden="true"></i> <span>栏目管理</span>
                    </a>
                </li>
                <li class="{{ $sitebar_menu_comments or '' }}">
                    <a href="/admin/comments">
                        <i class="fa fa-comments" aria-hidden="true"></i> <span>评论管理</span>
                    </a>
                </li>
                <li class="{{ $sitebar_menu_tags or '' }}">
                    <a href="/admin/tags">
                        <i class="fa fa-tags" aria-hidden="true"></i> <span>标签管理</span>
                    </a>
                </li>
                <li class="{{ $sitebar_menu_columnspaces or '' }}">
                    <a href="/admin/columnspaces">
                        <i class="fa fa-square" aria-hidden="true"></i> <span>栏目位管理</span>
                    </a>
                </li>
                <li class="treeview {{ $sitebar_menu_users or '' }}">
                    <a href="/admin/users">
                        <i class="fa fa-user" aria-hidden="true"></i> <span>用户管理</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/admin/users?type=people" class="{{ $sitebar_subnav_people or '' }}">普通用户</a></li>
                        <li><a href="/admin/users?type=administer" class="{{ $sitebar_subnav_administer or '' }}">管理员</a></li>
                    </ul>
                </li>
                <li class="{{ $sitebar_menu_assets or '' }}">
                    <a href="/admin/assets">
                        <i class="fa fa-file-image-o" aria-hidden="true"></i> <span>附件管理</span>
                    </a>
                </li>
                <li class="treeview {{ $sitebar_menu_system or '' }}">
                    <a href="/admin/settings">
                        <i class="fa fa-circle-o" aria-hidden="true"></i> <span>系统管理</span>
                    </a>
                    <ul class="treeview-menu">
                        
                        <li><a href="#">数据统计</a></li>
                        <li><a href="#">缓存管理</a></li>
                    </ul>
                </li>
            </ul><!-- /.sidebar-menu -->
        </section><!-- /.sidebar -->
    </aside><!-- /.main-sidebar -->
    
    <div class="content-wrapper" style="min-height: 398px;">
        @yield('content')
    </div>
    
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2016-2017 <a href="http://qysea.com">QYsea</a>.</strong> All rights reserved.
    </footer>
    
    @yield('footer')
    
    <!-- JavaScripts -->
    <script src="{{ asset('js/jquery-3.0.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/AdminLTE.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plupload/plupload.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ elixir('js/jquery.plugins.min.js') }}" type="text/javascript"></script>
    <script src="{{ elixir('js/app.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            $(".select2").select2();
            
            @yield('jquery')
        });
    </script>
</body>
</html>
