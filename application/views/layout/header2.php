<!DOCTYPE html>
<html lang="en">

  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- Favicon icon -->
      <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url('asset/images/mintohardjo.ico'); ?>">
      <title><?php echo $this->config->item('web_title'); ?></title>
      <!-- Bootstrap Core CSS -->
      <link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
      <!-- chartist CSS -->
      <link href="<?php echo site_url('assets/plugins/chartist-js/dist/chartist.min.css'); ?>" rel="stylesheet">
      <link href="<?php echo site_url('assets/plugins/chartist-js/dist/chartist-init.css'); ?>" rel="stylesheet">
      <link href="<?php echo site_url('assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css'); ?>" rel="stylesheet">
      <!--This page css - Morris CSS -->
      <link href="<?php echo site_url('assets/plugins/c3-master/c3.min.css'); ?>" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="<?php echo site_url('assets/css/style.css'); ?>" rel="stylesheet">
      <!-- You can change the theme colors from here -->
      <link href="<?php echo site_url('assets/css/colors/blue.css'); ?>" id="theme" rel="stylesheet">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->

      <!-- ============================================================== -->
      <!-- All Jquery -->
      <!-- ============================================================== -->
      <script src="<?php echo site_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
      <!-- Bootstrap tether Core JavaScript -->
      <script src="<?php echo site_url('assets/plugins/bootstrap/js/tether.min.js'); ?>"></script>
      <script src="<?php echo site_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
      <!-- slimscrollbar scrollbar JavaScript -->
      <script src="<?php echo site_url('assets/js/jquery.slimscroll.js'); ?>"></script>
      <!--Wave Effects -->
      <script src="<?php echo site_url('assets/js/waves.js'); ?>"></script>
      <!--Menu sidebar -->
      <script src="<?php echo site_url('assets/js/sidebarmenu.js'); ?>"></script>
      <!--stickey kit -->
      <script src="<?php echo site_url('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js'); ?>"></script>
      <script src="<?php echo site_url('assets/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>
      <!--Custom JavaScript -->
      <script src="<?php echo site_url('assets/js/custom.min.js'); ?>"></script>
      <!-- jQuery peity -->
      <script src="<?php echo site_url('assets/plugins/tablesaw-master/dist/tablesaw.js'); ?>"></script>
      <script src="<?php echo site_url('assets/plugins/tablesaw-master/dist/tablesaw-init.js'); ?>"></script>
      <!-- ============================================================== -->
      <!-- Style switcher -->
      <!-- ============================================================== -->
      <script src="<?php echo site_url('assets/plugins/styleswitcher/jQuery.style.switcher.js'); ?>"></script>
  </head>

  <body class="fix-header card-no-border logo-center">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo site_url(); ?>">
                        <!-- Logo icon -->
                        <b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="<?php echo base_url()."assets/images/logos/".$this->config->item('logo_url'); ?>" alt="homepage" class="dark-logo img-responsive" style="max-width:45px;" />
                            <!-- Light Logo icon -->
                            <img src="<?php echo base_url()."assets/images/logos/".$this->config->item('logo_url'); ?>" alt="homepage" class="light-logo img-responsive" style="max-width:45px;" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span>
                         <!-- dark Logo text -->
                         <b alt="homepage" class="dark-logo" ><?php echo $this->config->item('namars'); ?></b>
                         <!-- Light Logo text -->   
                         <b alt="homepage" class="light-logo" ><?php echo $this->config->item('namars'); ?></b>
                        </span>
                      </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
                                            </a>
                                            <a href="#">
                                                <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Event today</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span> </div>
                                            </a>
                                            <a href="#">
                                                <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Settings</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span> </div>
                                            </a>
                                            <a href="#">
                                                <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li> -->
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-email"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox dropdown-menu-right scale-up" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title">You have 4 new messages</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <a href="#">
                                                <div class="user-img"> <img src="<?php echo site_url('assets/images/users/1.jpg'); ?>" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                            </a>
                                            <a href="#">
                                                <div class="user-img"> <img src="<?php echo site_url('assets/images/users/2.jpg'); ?>" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                            </a>
                                            <a href="#">
                                                <div class="user-img"> <img src="<?php echo site_url('assets/images/users/3.jpg'); ?>" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                            </a>
                                            <a href="#">
                                                <div class="user-img"> <img src="<?php echo site_url('assets/images/users/4.jpg'); ?>" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li> -->
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                        <?php 
                        if ($user_info->foto==NULL || $user_info->foto=='') 
                          $foto = site_url().'upload/user/unknown.png';
                        else 
                          $foto = site_url().'upload/user/'.$user_info->foto;
                        ?>  
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $foto; ?>" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="<?php echo $foto; ?>" alt="user"></div>
                                            <div class="u-text">
                                                <h4><?php echo $user_info->name; ?></h4>
                                                <p class="text-muted"><?php echo $user_info->username; ?></p>
                                                <a href="#" class="btn btn-rounded btn-danger btn-sm" onClick="return openUrl('<?php echo site_url('user/Change_password'); ?>');">Change Password</a>
                                              </div>
                                        </div>
                                    </li>
                                    <!-- <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                                    <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                                    <li><a href="#"><i class="ti-email"></i> Inbox</a></li> -->
                                    <!-- <li role="separator" class="divider"></li>
                                    <li><a href="#" onClick="return openUrl('<?php echo site_url('user/Change_password'); ?>');"><i class="ti-settings"></i> Change Password</a></li> -->
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?php echo site_url('logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- Language -->
                        <!-- ============================================================== -->
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-us"></i></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up"> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-in"></i> India</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> Dutch</a> </div>
                        </li> -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li><a href="<?php echo site_url(); ?>"><i class="mdi mdi-home"></i> <span>Beranda</span></a></li>
                        <?php echo buildMenu2(); ?>  
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Table Responsive</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Table Responsive</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>THIS MONTH</small></h6>
                                    <h4 class="m-t-0 text-info">$58,356</h4></div>
                                <div class="spark-chart">
                                    <div id="monthchart"></div>
                                </div>
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>LAST MONTH</small></h6>
                                    <h4 class="m-t-0 text-primary">$48,356</h4></div>
                                <div class="spark-chart">
                                    <div id="lastmonthchart"></div>
                                </div>
                            </div>
                            <div class="">
                                <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <!-- Column -->
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title">Kitchen Sink</h4>
                                <h6 class="card-subtitle">Swipe Mode, ModeSwitch, Minimap, Sortable, SortableSwitch</h6>
                                <table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
                                    <thead>
                                        <tr>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Movie Title</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Rank</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Year</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">
                                                <abbr title="Rotten Tomato Rating">Rating</abbr>
                                            </th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Gross</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Avatar</a></td>
                                            <td>1</td>
                                            <td>2009</td>
                                            <td>83%</td>
                                            <td>$2.7B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Titanic</a></td>
                                            <td>2</td>
                                            <td>1997</td>
                                            <td>88%</td>
                                            <td>$2.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">The Avengers</a></td>
                                            <td>3</td>
                                            <td>2012</td>
                                            <td>92%</td>
                                            <td>$1.5B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Harry Potter and the Deathly Hallows—Part 2</a></td>
                                            <td>4</td>
                                            <td>2011</td>
                                            <td>96%</td>
                                            <td>$1.3B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Frozen</a></td>
                                            <td>5</td>
                                            <td>2013</td>
                                            <td>89%</td>
                                            <td>$1.2B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Iron Man 3</a></td>
                                            <td>6</td>
                                            <td>2013</td>
                                            <td>78%</td>
                                            <td>$1.2B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Transformers: Dark of the Moon</a></td>
                                            <td>7</td>
                                            <td>2011</td>
                                            <td>36%</td>
                                            <td>$1.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">The Lord of the Rings: The Return of the King</a></td>
                                            <td>8</td>
                                            <td>2003</td>
                                            <td>95%</td>
                                            <td>$1.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Skyfall</a></td>
                                            <td>9</td>
                                            <td>2012</td>
                                            <td>92%</td>
                                            <td>$1.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Transformers: Age of Extinction</a></td>
                                            <td>10</td>
                                            <td>2014</td>
                                            <td>18%</td>
                                            <td>$1.0B</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title">Column Toggle Table</h4>
                                <h6 class="card-subtitle">The Column Toggle Table allows the user to select which columns they want to be visible.</h6>
                                <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Movie Title</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Rank</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Year</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">
                                                <abbr title="Rotten Tomato Rating">Rating</abbr>
                                            </th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Gross</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Avatar</a></td>
                                            <td>1</td>
                                            <td>2009</td>
                                            <td>83%</td>
                                            <td>$2.7B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Titanic</a></td>
                                            <td>2</td>
                                            <td>1997</td>
                                            <td>88%</td>
                                            <td>$2.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">The Avengers</a></td>
                                            <td>3</td>
                                            <td>2012</td>
                                            <td>92%</td>
                                            <td>$1.5B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Harry Potter and the Deathly Hallows—Part 2</a></td>
                                            <td>4</td>
                                            <td>2011</td>
                                            <td>96%</td>
                                            <td>$1.3B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Frozen</a></td>
                                            <td>5</td>
                                            <td>2013</td>
                                            <td>89%</td>
                                            <td>$1.2B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Iron Man 3</a></td>
                                            <td>6</td>
                                            <td>2013</td>
                                            <td>78%</td>
                                            <td>$1.2B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Transformers: Dark of the Moon</a></td>
                                            <td>7</td>
                                            <td>2011</td>
                                            <td>36%</td>
                                            <td>$1.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">The Lord of the Rings: The Return of the King</a></td>
                                            <td>8</td>
                                            <td>2003</td>
                                            <td>95%</td>
                                            <td>$1.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Skyfall</a></td>
                                            <td>9</td>
                                            <td>2012</td>
                                            <td>92%</td>
                                            <td>$1.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Transformers: Age of Extinction</a></td>
                                            <td>10</td>
                                            <td>2014</td>
                                            <td>18%</td>
                                            <td>$1.0B</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title">Swipe Table</h4>
                                <h6 class="card-subtitle">The Column Swipe Table allows the user to select which columns they want to be visible.</h6>
                                <table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Movie Title</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Rank</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Year</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">
                                                <abbr title="Rotten Tomato Rating">Rating</abbr>
                                            </th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Gross</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Avatar</a></td>
                                            <td>1</td>
                                            <td>2009</td>
                                            <td>83%</td>
                                            <td>$2.7B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Titanic</a></td>
                                            <td>2</td>
                                            <td>1997</td>
                                            <td>88%</td>
                                            <td>$2.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">The Avengers</a></td>
                                            <td>3</td>
                                            <td>2012</td>
                                            <td>92%</td>
                                            <td>$1.5B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Harry Potter and the Deathly Hallows—Part 2</a></td>
                                            <td>4</td>
                                            <td>2011</td>
                                            <td>96%</td>
                                            <td>$1.3B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Frozen</a></td>
                                            <td>5</td>
                                            <td>2013</td>
                                            <td>89%</td>
                                            <td>$1.2B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Iron Man 3</a></td>
                                            <td>6</td>
                                            <td>2013</td>
                                            <td>78%</td>
                                            <td>$1.2B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Transformers: Dark of the Moon</a></td>
                                            <td>7</td>
                                            <td>2011</td>
                                            <td>36%</td>
                                            <td>$1.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">The Lord of the Rings: The Return of the King</a></td>
                                            <td>8</td>
                                            <td>2003</td>
                                            <td>95%</td>
                                            <td>$1.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Skyfall</a></td>
                                            <td>9</td>
                                            <td>2012</td>
                                            <td>92%</td>
                                            <td>$1.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a href="javascript:void(0)">Transformers: Age of Extinction</a></td>
                                            <td>10</td>
                                            <td>2014</td>
                                            <td>18%</td>
                                            <td>$1.0B</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme working">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme ">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>Chat option</b></li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?php echo site_url('assets/images/users/1.jpg'); ?>" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?php echo site_url('assets/images/users/2.jpg'); ?>" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?php echo site_url('assets/images/users/3.jpg'); ?>" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?php echo site_url('assets/images/users/4.jpg'); ?>" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?php echo site_url('assets/images/users/5.jpg'); ?>" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?php echo site_url('assets/images/users/6.jpg'); ?>" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?php echo site_url('assets/images/users/7.jpg'); ?>" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?php echo site_url('assets/images/users/8.jpg'); ?>" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                © 2017 Material Pro Admin by wrappixel.com
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
          <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End Wrapper -->
      <!-- ============================================================== -->
  </body>

</html>