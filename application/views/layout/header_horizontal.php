<?php 
 if(!isset($_GET['rel'])){ 
?>
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
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url('assets/images/mmc.ico'); ?>">
     <title><?php echo $this->config->item('web_title'); ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/jqueryui/jquery-ui.css'); ?>">

    <!-- Daterange picker plugins css -->
    <link href="<?php echo site_url('assets/plugins/timepicker/bootstrap-timepicker.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css'); ?>" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?php echo site_url('assets/horizontal/css/style.css'); ?>" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?php echo site_url('assets/horizontal/css/colors/blue.css'); ?>" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
  <!--   <link rel="stylesheet" href="<?php echo site_url('assets/plugins/datatables/jquery.dataTables.min.css'); ?>"> -->
    <link rel="stylesheet" href="<?php echo site_url('assets/css/jquery.autocomplete.css'); ?>">
    <link href="<?php echo site_url('assets/plugins/clockpicker/dist/jquery-clockpicker.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css'); ?>">
    <!--alerts CSS -->
    <link href="<?php echo site_url('assets/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet" type="text/css">
    <style type="text/css">
        td.dataTables_empty { text-align: center; }
        .demo-checkbox label, .demo-radio-button label {
        min-width: 130px;
        margin-bottom: 0;
        }    
        a:focus { 
            color: #fff;
        }
        .btn:active,
        .btn:focus,
        .btn.active {
          background-image: none;
          outline: 0;
          -webkit-box-shadow: none;
                  box-shadow: none;
           outline: none !important;
        }
        .sweet-alert h2 {
            font-size: 26px;
        }
        .card-body {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
        }
    </style>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?php echo site_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/jqueryui/jquery-ui.js'); ?>"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo site_url('assets/plugins/bootstrap/js/tether.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/bootstrap3-typeahead.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/hmis.js'); ?>"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo site_url('assets/horizontal/js/jquery.slimscroll.js'); ?>"></script>
    <!--Wave Effects -->
    <script src="<?php echo site_url('assets/horizontal/js/waves.js'); ?>"></script>
    <!--Menu sidebar -->
    <script src="<?php echo site_url('assets/horizontal/js/sidebarmenu.js'); ?>"></script>
    <!--stickey kit -->
    <script src="<?php echo site_url('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo site_url('assets/horizontal/js/custom.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/moment/moment.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/clockpicker/dist/jquery-clockpicker.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- This is data table -->
    <script src="<?php echo site_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
   <!--  <script src="<?php echo site_url('assets/plugins/datatables/dataTables.bootstrap.js'); ?>"></script> -->
    <script src="<?php echo site_url('assets/plugins/jquery.autocomplete.js'); ?>"></script>
    <!-- Sweet-Alert  -->
    <script src="<?php echo site_url('assets/plugins/sweetalert/sweetalert.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/sweetalert/jquery.sweet-alert.custom.js'); ?>"></script>
    <!-- Mask Money -->
    <script src="<?php echo site_url('assets/js/jquery.maskMoney.js'); ?>" type="text/javascript"></script>
    <!-- Validation-->
    <script src="<?php echo site_url('assets/plugins/jquery-validation/js/jquery.validate.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/validation.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/validator.js'); ?>" type="text/javascript"></script>
    <!-- SELECT2 -->
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/select2/dist/css/select2.min.css'); ?>">
    <script src="<?php echo site_url('assets/plugins/select2/dist/js/select2.full.min.js'); ?>"></script>
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/icheck/skins/all.css'); ?>">
    <script src="<?php echo site_url('assets/plugins/icheck/icheck.min.js'); ?>"></script>

    <script src="<?php echo site_url('assets/plugins/morrisjs/morris.min.js'); ?>"></script> 
    <script src="<?php echo site_url('assets/plugins/raphael/raphael-min.js'); ?>"></script>
    <script type="text/javascript">
        function formatErrorMessage(jqXHR, exception)
        {
            if (jqXHR.status === 0) {
               return ('Not connected.\nPlease verify your network connection.');
            } else if (jqXHR.status == 404) {
                return ('The requested page not found.');
            }  else if (jqXHR.status == 401) {
                return ('Sorry!! You session has expired. Please login to continue access.');
            } else if (jqXHR.status == 500) {
                return ('Internal Server Error.');
            } else if (exception === 'parsererror') {
                return ('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                return ('Time out error.');
            } else if (exception === 'abort') {
                return ('Ajax request aborted.');
            } else {
                return ('Unknown error occured. Please try again.');
            }
        }
    </script>

 

  </head>

  <body class="fix-header fix-sidebar card-no-border logo-center">
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
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="<?php echo base_url()."assets/images/logos/".$this->config->item('logo_url'); ?>" alt="homepage" class="dark-logo img-responsive" style="max-width:45px;" />
                            <!-- Light Logo icon -->
                            <img src="<?php echo base_url()."assets/images/logos/".$this->config->item('logo_url'); ?>" alt="homepage" class="light-logo img-responsive" style="max-width:45px;" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         <b alt="homepage" class="dark-logo" style="font-size: 14px;"><?php echo $this->config->item('namasingkat'); ?></b>
                         <!-- Light Logo text -->   
                         <b alt="homepage" class="light-logo" style="font-size: 14px;"><?php echo $this->config->item('namasingkat'); ?></b></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                    <!--     <li class="nav-item hidden-sm-down search-box">
                            <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><?php echo $title; ?></a>
                        </li> -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                       
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <?php 
                    if ($user_info->foto==NULL || $user_info->foto=='') 
                      $foto = site_url().'upload/user/unknown.png';
                    else 
                      $foto = site_url().'upload/user/'.$user_info->foto;
                    ?>  
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                       <!--  <li class="nav-item dropdown ms-hover">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell" style="font-size: 24px;"></i>
                                <div class="notify pull-left"><span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="drop-title"><i class="fa fa-bell"></i> Notifikasi</div>
                                    </li>
                                    <li>
                                        <div class="slimScrollDiv">
                                            <div class="message-center">
                                            <a href="#">
                                                <div class="mail-contnet" style="width: 100%">
                                                    <h5>Ruangan Salawati</h5> <span class="mail-desc">Merubah Jenis Diet menjadi DM 1100, DJ 1 </span> <span class="time"><i class="fa fa-calendar"></i> 15 Mei 2018 <i class="fa fa-clock-o"></i> 9:30</span> </div>
                                            </a>
                                            </div>
                                            <div class="slimScrollBar"></div>
                                            <div class="slimScrollRail"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Lihat Semua</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li> -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $foto; ?>" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="<?php echo $foto; ?>" alt="user"></div>
                                            <div class="u-text">
                                                <h4><?php echo $user_info->username; ?></h4>
                                                <p class="text-muted"><?php echo $user_info->name; ?></p>
                                        </div>
                                    </li>
                                    <li><a href="<?php echo site_url('user/Change_password'); ?>"><i class="ti-key"></i> Change Password</a></li>
                                    <li><a href="<?php echo site_url('logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
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
            <div class="col-md-12">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <?php echo buildMenu2(); ?>  
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            </div>
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
        <div class="col-md-12">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div id="container-fluid" class="container-fluid">
<?php 
 }
?>            
                <!-- ============================================================== -->
              <!-- Bread crumb and right sidebar toggle -->
              <!-- ============================================================== -->
               <div class="row page-titles">
                    <div class="col-md-12 align-self-center">
                        <?php if (isset($title)) { ?>
                            <h3 class="text-themecolor"><?php echo $title; ?></h3>
                        <?php } ?>
                        <ol class="breadcrumb">
                            <?php echo buildBreadcrumb2(); ?>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
