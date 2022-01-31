<?php
$routeName = request()->getLoadedRoute()->getName();
/**
* render header dashboard
*/
view()->render( 'header-dashboard' );

$user = wp_get_current_user();
?>
<!-- Main content -->
<div class="main-content" id="panel">
  <!-- Topnav -->
  <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Search form -->
        <div class="form-inline mr-sm-3">
          <h3 style="color: white"> Sistem Pembayaran SPP SMP TAHFIDZ AL-HIDAYAT SALAMAN</h3>
        </div>
        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center  ml-md-auto ">
        </ul>
        <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" src="<?php echo get_dist_directory(); ?>/assets/img/theme/team-4.jpg">
                </span>
                <div class="media-body  ml-2  d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold"><?php echo $user->username; ?></span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu  dropdown-menu-right ">
              <div class="dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome!</h6>
              </div>
              <div class="dropdown-divider"></div>
              <a href="<?php echo url( 'logout', null, array( 'wp_csrf_token' => csrf_token() ) ); ?>" class="dropdown-item">
                <i class="ni ni-user-run"></i>
                <span>Logout</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Header -->
  <?php
  /*
   <!-- Header -->
  <div class="header bg-primary pb-6">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row align-items-center py-4">
          <div class="col-lg-6 col-7">
            <h6 class="h2 text-white d-inline-block mb-0">Default</h6>
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
              <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
                <li class="breadcrumb-item active" aria-current="page">Default</li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-6 col-5 text-right">
            <a href="#" class="btn btn-sm btn-neutral">New</a>
            <a href="#" class="btn btn-sm btn-neutral">Filters</a>
          </div>
        </div>
        <!-- Card stats -->
        <div class="row">
          <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
              <!-- Card body -->
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Total traffic</h5>
                    <span class="h2 font-weight-bold mb-0">350,897</span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                      <i class="ni ni-active-40"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                  <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                  <span class="text-nowrap">Since last month</span>
                </p>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
              <!-- Card body -->
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">New users</h5>
                    <span class="h2 font-weight-bold mb-0">2,356</span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                      <i class="ni ni-chart-pie-35"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                  <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                  <span class="text-nowrap">Since last month</span>
                </p>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
              <!-- Card body -->
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>
                    <span class="h2 font-weight-bold mb-0">924</span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                      <i class="ni ni-money-coins"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                  <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                  <span class="text-nowrap">Since last month</span>
                </p>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
              <!-- Card body -->
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Performance</h5>
                    <span class="h2 font-weight-bold mb-0">49,65%</span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                      <i class="ni ni-chart-bar-32"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                  <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                  <span class="text-nowrap">Since last month</span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  */
  ?>
<?php
/**
* do action before specific content dashboard while rendered
*/
do_action( "render-{$routeName}-content" );

/**
* render footer dashboard
*/
view()->render( 'footer-dashboard' );