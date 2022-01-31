<?php view()->render( 'header-auth' ); ?>
<!-- Main content -->
<div class="main-content">
  <!-- Header -->
  <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
    <div class="container">
      <div class="header-body text-center mb-7">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-6 col-md-8 px-5">
            <h1 class="text-white"><?php _e( 'Buat Akun Sebagai Admin', 'WPIC' ) ?></h1>
          </div>
        </div>
      </div>
    </div>
    <div class="separator separator-bottom separator-skew zindex-100">
      <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
      </svg>
    </div>
  </div>
  <!-- Page content -->
  <div class="container mt--9 pb-5">
    <!-- Table -->
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="card bg-secondary border border-soft">
          <div class="card-body px-lg-5 py-lg-5">
            <form action="<?= url(); ?>" method="post">
              <input type="hidden" name="wp_csrf_token" value="<?= csrf_token(); ?>">
              <input type="hidden" name="_register" value="1">
              <div class="form-group">
                <div class="input-group input-group-merge input-group-alternative mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                  </div>
                  <input class="form-control" placeholder="Nama" type="text" name="user.username">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group input-group-merge input-group-alternative mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                  </div>
                  <input class="form-control" placeholder="Email" type="email" name="user.email">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group input-group-merge input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                  </div>
                  <input class="form-control" placeholder="Password" type="password" name="user.pass">
                </div>
              </div>
              <div class="text-muted font-italic"><small><?php _e( 'password strength :', 'WPIC' ) ?><span class="text-success font-weight-700">strong</span></small></div>
              <div class="row my-4">
                <div class="col-12">
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary mt-4"><?php _e( 'Buat Akun', 'WPIC' ) ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php view()->render( 'footer-auth' ); ?>